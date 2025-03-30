<?php
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "Please log in to cancel a booking.";
    header("Location: login.html");
    exit;
}

$user_email = $_SESSION['email'];

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if a booking_id is provided
if (!isset($_POST['booking_id']) || empty($_POST['booking_id'])) {
    header("Location: my_bookings.php?error=invalid_booking");
    exit;
}

$booking_id = $_POST['booking_id'];

// Verify that the booking belongs to the logged-in user
$verify_stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ? AND email = ?");
if ($verify_stmt === false) {
    die("Verify prepare failed: " . $conn->error);
}
$verify_stmt->bind_param("ss", $booking_id, $user_email);
$verify_stmt->execute();
$result = $verify_stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: my_bookings.php?error=unauthorized");
    exit;
}

$booking = $result->fetch_assoc();

// Check if the booking is eligible for cancellation
$current_date = date('Y-m-d');
if ($current_date >= $booking['start_date']) {
    header("Location: my_bookings.php?error=already_started");
    exit;
}

// Calculate refund amount
$start_date = new DateTime($booking['start_date']);
$today = new DateTime($current_date);
$days_until_start = $today->diff($start_date)->format("%a");

$refund_percentage = 0;
if ($days_until_start >= 7) {
    $refund_percentage = 100;
} elseif ($days_until_start >= 3) {
    $refund_percentage = 70;
} else {
    $refund_percentage = 50;
}

$refund_amount = ($booking['total_price'] * $refund_percentage) / 100;

// Start transaction
$conn->begin_transaction();

try {
    // Create a cancellation record
    $cancel_stmt = $conn->prepare("
        INSERT INTO booking_cancellations (
            booking_id, 
            cancellation_date, 
            refund_amount, 
            refund_percentage
        ) VALUES (?, ?, ?, ?)
    ");
    if ($cancel_stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $cancel_stmt->bind_param("ssdi", $booking_id, $current_date, $refund_amount, $refund_percentage);
    $cancel_stmt->execute();

    // Update the booking status to cancelled
    $update_stmt = $conn->prepare("
        UPDATE bookings 
        SET status = 'cancelled' 
        WHERE booking_id = ?
    ");
    if ($update_stmt === false) {
        throw new Exception("Update prepare failed: " . $conn->error);
    }
    $update_stmt->bind_param("s", $booking_id);
    $update_stmt->execute();

    // Make the car available again
    $car_id = $booking['car_id'];
    $update_car_stmt = $conn->prepare("
        UPDATE cars 
        SET status = 'Available' 
        WHERE car_id = ?
    ");
    if ($update_car_stmt === false) {
        throw new Exception("Update car prepare failed: " . $conn->error);
    }
    $update_car_stmt->bind_param("i", $car_id);
    $update_car_stmt->execute();

    // Commit the transaction
    $conn->commit();

    header("Location: refund.php?booking_id=" . urlencode($booking_id) . "&refund=" . $refund_amount);
    exit;

} catch (Exception $e) {
    $conn->rollback();
    header("Location: mybookings.php?error=cancellation_failed&message=" . urlencode($e->getMessage()));
    exit;
}
?>