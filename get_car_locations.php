<?php
include('config.php');

// Fetch car locations
$sql = "SELECT car_id AS id, model, latitude, longitude, status FROM cars";
$result = $conn->query($sql);

$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

// Return the car data as JSON
header('Content-Type: application/json');
echo json_encode($cars);

$conn->close();
?>
