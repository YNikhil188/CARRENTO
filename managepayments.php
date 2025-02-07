<?php
include("config.php");

$sql = "SELECT * FROM payment"; // Fetch all feedback
$result = $conn->query($sql);

$payment = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payment[] = $row; // Store the feedback data
    }
}

$conn->close();

// Return the feedback data as JSON
header('Content-Type: application/json');
echo json_encode($payment);
?>
