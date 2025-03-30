<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $model = $_POST['model'];
    $price_per_day = $_POST['price_per_day'];
    $gearbox = $_POST['gearbox'];
    $fuel = $_POST['fuel'];
    $doors = $_POST['doors'];
    $air_conditioner = $_POST['air_conditioner'];
    $seats = $_POST['seats'];

    // Handle file upload
    $image = $_FILES['image'];
    $imageName = basename($image['name']);
    $uploadDir = 'uploads/cars/';
    $uploadFile = $uploadDir . $imageName;

    if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
        // Insert data into the `cars` table
        $sql = "INSERT INTO cars (image, model, price_per_day, gearbox, fuel, doors, air_conditioner, seats) 
                VALUES ('$imageName', '$model', '$price_per_day', '$gearbox', '$fuel', '$doors', '$air_conditioner', '$seats')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Car added successfully'); window.location.href='managecars.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}

// Close the database connection
$conn->close();
?>
