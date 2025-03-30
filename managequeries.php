<?php
include("config.php");

$sql = "SELECT * FROM contact_messages"; // Fetch all feedback
$result = $conn->query($sql);

$contact_messages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contact_messages[] = $row; // Store the feedback data
    }
}

$conn->close();

// Return the feedback data as JSON
header('Content-Type: application/json');
echo json_encode($contact_messages);
?>
