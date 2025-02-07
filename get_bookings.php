<?php
// Include the database connection file
include('config.php');

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(['error' => 'Error executing query: ' . $conn->error]);
    exit();
}

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode($bookings);

?>
