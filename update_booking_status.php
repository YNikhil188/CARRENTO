<?php
include('config.php');

// Ensure the employee is logged in
if (!isset($_SESSION['employee_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access. Please log in as an employee.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['booking_id'], $data['status'])) {
    $employeeId = $_SESSION['employee_id']; // Logged-in employee ID from session
    $bookingId = $data['booking_id'];
    $status = $data['status'];

    // Debugging: Output the received data
    // var_dump($data);
    
    // Update the booking status
    $updateQuery = "UPDATE bookings SET status = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($updateQuery);

    // Check if prepare() failed
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing the query: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("si", $status, $bookingId);

    if ($stmt->execute()) {
        // Debugging: Check how many rows were affected
        $affectedRows = $stmt->affected_rows;
        if ($affectedRows > 0) {
            // If the status was updated successfully, check if it was accepted
            if ($status === 'accepted') {
                $fetchQuery = "SELECT * FROM bookings WHERE booking_id = ?";
                $stmt = $conn->prepare($fetchQuery);
                $stmt->bind_param("i", $bookingId);
                $stmt->execute();
                $result = $stmt->get_result();
                $booking = $result->fetch_assoc();

                if ($booking) {
                    // Insert into employee_bookings table
                    $insertQuery = "INSERT INTO employee_bookings 
                                        (employee_id, booking_id, car_id, start_date, end_date, latitude, longitude, status) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertQuery);
                    $stmt->bind_param(
                        "iiissdds",  // Ensure correct data types, dd for double (latitude, longitude)
                        $employeeId,
                        $booking['booking_id'],
                        $booking['car_id'],
                        $booking['start_date'],
                        $booking['end_date'],
                        $booking['latitude'],
                        $booking['longitude'],
                        $status
                    );

                    if ($stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Booking accepted and details stored successfully.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error storing employee and booking details.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Booking not found.']);
                }
            } else {
                echo json_encode(['success' => true, 'message' => 'Booking status updated successfully.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No rows affected. The booking might not exist or status is the same.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing the query: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
