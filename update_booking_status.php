<?php
include('config.php');

// Ensure the employee is logged in
if (!isset($_SESSION['employee_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access. Please log in as an employee.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['booking_id']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input. Missing booking_id or status.']);
    exit();
}

$employeeId = $_SESSION['employee_id']; // Logged-in employee ID from session
$bookingId = $data['booking_id'];
$status = $data['status'];

// Start a transaction to ensure atomicity
$conn->begin_transaction();

try {
    // Step 1: Update the booking status
    $updateQuery = "UPDATE bookings SET status = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt === false) {
        throw new Exception("Error preparing booking update query: " . $conn->error);
    }
    $stmt->bind_param("si", $status, $bookingId);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("No booking found with ID: $bookingId or status unchanged.");
    }
    $stmt->close();

    // Step 2: If status is 'accepted', handle additional actions
    if ($status === 'accepted') {
        // Fetch booking details
        $fetchQuery = "SELECT * FROM bookings WHERE booking_id = ?";
        $stmt = $conn->prepare($fetchQuery);
        if ($stmt === false) {
            throw new Exception("Error preparing fetch query: " . $conn->error);
        }
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();

        if (!$booking) {
            throw new Exception("Booking not found with ID: $bookingId.");
        }

        // Step 3: Insert into employee_bookings table
        $insertQuery = "INSERT INTO employee_bookings 
                        (employee_id, booking_id, car_id, start_date, end_date, latitude, longitude, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        if ($stmt === false) {
            throw new Exception("Error preparing insert query: " . $conn->error);
        }
        $stmt->bind_param(
            "iiissdds", // i: integer, s: string, d: double
            $employeeId,
            $booking['booking_id'],
            $booking['car_id'],
            $booking['start_date'],
            $booking['end_date'],
            $booking['latitude'],
            $booking['longitude'],
            $status
        );
        $stmt->execute();
        if ($stmt->affected_rows === 0) {
            throw new Exception("Failed to insert into employee_bookings.");
        }
        $stmt->close();

        // Step 4: Update car status to 'available'
        $carUpdateQuery = "UPDATE cars SET status = 'available' WHERE car_id = ?";
        $stmt = $conn->prepare($carUpdateQuery);
        if ($stmt === false) {
            throw new Exception("Error preparing car update query: " . $conn->error);
        }
        $stmt->bind_param("i", $booking['car_id']);
        $stmt->execute();
        if ($stmt->affected_rows === 0) {
            throw new Exception("No car found with ID: " . $booking['car_id'] . " or status unchanged.");
        }
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Booking accepted, employee details stored, and car set to available.']);
    } else {
        // If status is not 'accepted', just commit the booking update
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Booking status updated successfully.']);
    }
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>