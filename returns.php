<?php
include("config.php");

$sql = "SELECT * FROM employee_bookings"; // Fetch all feedback
$result = $conn->query($sql);

$employeee_bookings = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employeee_bookings[] = $row; // Store the feedback data
    }
}

$conn->close();

// Return the feedback data as JSON
header('Content-Type: application/json');
echo json_encode($employeee_bookings);
?>
