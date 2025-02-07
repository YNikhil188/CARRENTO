<?php
include('config.php');
// Get car_id, latitude, and longitude from the POST request
$car_id = $_POST['car_id'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Update the car's location in the database
$sql = "UPDATE cars SET latitude = '$latitude', longitude = '$longitude' WHERE car_id = '$car_id'";
if ($conn->query($sql) === TRUE) {
    echo "Location updated successfully";
} else {
    echo "Error updating location: " . $conn->error;
}

$conn->close();
?>
