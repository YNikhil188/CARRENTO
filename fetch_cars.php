<?php
include('config.php');

// Get the search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Define rental office location
$office = [
    "latitude" => "37.7749", // Example latitude
    "longitude" => "-122.4194", // Example longitude
];

// Query to fetch car data
$sql = "SELECT id, model, latitude, longitude, status FROM cars";
if ($search) {
    $sql .= " WHERE model LIKE '%$search%' OR status LIKE '%$search%'";
}

$result = $conn->query($sql);

$cars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode([
    "office" => $office,
    "cars" => $cars,
]);

$conn->close();
?>
