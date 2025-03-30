<?php
include("config.php");

// Ensure user is logged in (check if session is set)
if (!isset($_SESSION['id'])) {
    die("User not logged in. Please log in to access the dashboard.");
}

// Fetch all cars from the database
$sql = "SELECT car_id, image, model, price_per_day, gearbox, fuel, doors, air_conditioner, seats 
        FROM cars";
$result = $conn->query($sql);

// Check if query returns results
$cars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}

// Set the response header to application/json
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode($cars);

// Close the database connection
$conn->close();
?>
