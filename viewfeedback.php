<?php
include("config.php");

$sql = "SELECT * FROM feedback ORDER BY submitted_at DESC"; // Fetch all feedback
$result = $conn->query($sql);

$feedback = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback[] = $row; // Store the feedback data
    }
}
$conn->close();
// Return the feedback data as JSON
header('Content-Type: application/json');
echo json_encode($feedback);
?>
