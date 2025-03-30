<?php
include("config.php");

// Check if user is logged in
// if (!isset($_SESSION['id'])) {
//     header('Content-Type: application/json');
//     echo json_encode(['error' => 'User not logged in']);
//     exit;
// }

// Fetch all blog posts with user information
$sql = "SELECT b.*, u.name 
        FROM blog_posts b 
        JOIN users u ON b.user_id = u.id 
        ORDER BY b.createdon DESC";

$result = $conn->query($sql);
$posts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Return posts as JSON
header('Content-Type: application/json');
echo json_encode($posts);

$conn->close();
?>
