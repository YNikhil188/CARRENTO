<?php
include('config.php');

if (!$conn) {
    die("Error: Database connection failed - " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['carid'];
    $model = $_POST['model'];
    $price_per_day = $_POST['price_per_day'];
    $name = $_POST['name'];
    $email = $_SESSION["email"] ?? null;
    $phone = $_POST['phone'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (!$email) {
        die("Error: User not logged in or email not set in session.");
    }

    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $diff = $start->diff($end)->days;
    if ($diff < 1) {
        die("Error: Invalid date range.");
    }

    $total_price = $diff * $price_per_day;

    $conn->begin_transaction();

    try {
        // Insert booking
        $stmt = $conn->prepare("
            INSERT INTO bookings (car_id, customer_name, email, phone, start_date, end_date, total_price, model) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("isssssds", $car_id, $name, $email, $phone, $start_date, $end_date, $total_price, $model);
        if (!$stmt->execute()) {
            throw new Exception("Booking insert failed: " . $stmt->error);
        }
        if ($stmt->affected_rows != 1) {
            throw new Exception("Booking insertion affected " . $stmt->affected_rows . " rows.");
        }
        $stmt->close();

        // Update car status
        $update_stmt = $conn->prepare("UPDATE cars SET status = 'Unavailable' WHERE car_id = ?");
        if ($update_stmt === false) {
            throw new Exception("Update prepare failed: " . $conn->error);
        }
        $update_stmt->bind_param("i", $car_id);
        if (!$update_stmt->execute()) {
            throw new Exception("Car status update failed: " . $update_stmt->error);
        }
        if ($update_stmt->affected_rows < 1) {
            $check_stmt = $conn->prepare("SELECT status FROM cars WHERE car_id = ?");
            $check_stmt->bind_param("i", $car_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            $current_status = $result->num_rows > 0 ? $result->fetch_assoc()['status'] : 'Not Found';
            throw new Exception("No rows updated. Car ID: $car_id, Current Status: '$current_status'");
        }
        $update_stmt->close();

        $conn->commit();
        header("Location: payment.php?total_price=$total_price&carid=$car_id&name=" . urlencode($name));
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Error: Invalid request method.";
}

$conn->close();
?>