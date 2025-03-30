<?php
include ('config.php');
$sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);

$feedbacks = [];
while ($row = $result->fetch_assoc()) {
    $feedbacks[] = [
        'feedback_id' => $row['feedback_id'],
        'booking_id' => $row['booking_id'],
        'email' => $row['email'],
        'rating' => $row['rating'],
        'comments' => $row['comments'],
        'submitted_at' => $row['submitted_at']
    ];
}

echo json_encode($feedbacks);

$conn->close();
?>
