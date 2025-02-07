<?php
// Include database connection file
include('config.php');

$sql = "SELECT * FROM bookings"; // Adjust query as necessary
$result = mysqli_query($conn, $sql);

$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

header('Content-Type: application/json');
echo json_encode($bookings);
?>
