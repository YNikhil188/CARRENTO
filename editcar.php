<?php
// Include database connection
include('config.php'); // Adjust this to your actual database connection file

// Check if the car ID is set in the URL
if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // Fetch car data from the database
    $query = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    // Check if car data was found
    if (!$car) {
        echo "Car not found!";
        exit;
    }
} else {
    echo "No car ID provided!";
    exit;
}

// Update the car details in the database upon form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = $_POST['model'];
    $price_per_day = $_POST['price_per_day'];
    $gearbox = $_POST['gearbox'];
    $fuel = $_POST['fuel'];
    $doors = $_POST['doors'];
    $air_conditioner = isset($_POST['air_conditioner']) ? 1 : 0;
    $seats = $_POST['seats'];

    $update_query = "UPDATE cars SET model = ?, price_per_day = ?, gearbox = ?, fuel = ?, doors = ?, air_conditioner = ?, seats = ? WHERE car_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssiiii", $model, $price_per_day, $gearbox, $fuel, $doors, $air_conditioner, $seats, $car_id);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        echo "<script>alert('Car edited successfully'); window.location.href='managecars.html';</script>";
    } else {
        echo "<p>Failed to update car details.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
    <style>
        /* General styling for the page */
body {
    font-family: Arial, sans-serif;
    background-color: #000;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

h1 {
    color: #ff1e00;
    font-size: 36px;
    text-align: center;
    margin-bottom: 20px;
}

/* Form container */
form {
    background-color: #333;
    padding: 20px;
    border-radius: 8px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    margin-top: 20px;
    margin-bottom: 20px;
}

/* Form labels and inputs */
label {
    display: block;
    font-size: 18px;
    margin-bottom: 5px;
    color: #fff;
}

input[type="text"],
input[type="number"],
input[type="checkbox"] {
    font-size: 16px;
    width: 95%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #444;
    border-radius: 5px;
    background-color: #222;
    color: #fff;
}

input[type="checkbox"] {
    width: auto;
    margin-left: 10px;
}

/* Submit button */
button[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #444;
    border-radius: 5px;
    background-color: #ff1e00;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #ff4d4d;
}

/* Message styling */
p {
    text-align: center;
    color: #ff1e00;
    font-weight: bold;
    margin-top: 10px;
}
</style>
</head>
<body>
    <form method="POST">
        <h1>Edit Car</h1>
        <label>Model:</label>
        <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required><br><br>

        <label>Price Per Day:</label>
        <input type="number" name="price_per_day" value="<?php echo htmlspecialchars($car['price_per_day']); ?>" required><br><br>

        <label>Gear Box:</label>
        <input type="text" name="gearbox" value="<?php echo htmlspecialchars($car['gearbox']); ?>" required><br><br>

        <label>Fuel:</label>
        <input type="text" name="fuel" value="<?php echo htmlspecialchars($car['fuel']); ?>" required><br><br>

        <label>Doors:</label>
        <input type="number" name="doors" value="<?php echo htmlspecialchars($car['doors']); ?>" required><br><br>

        <label>Air Conditioner:</label>
        <input type="checkbox" name="air_conditioner" <?php if ($car['air_conditioner']) echo "checked"; ?>><br><br>

        <label>Seats:</label>
        <input type="number" name="seats" value="<?php echo htmlspecialchars($car['seats']); ?>" required><br><br>

        <button type="submit">Update Car</button>
    </form>
</body>
</html>
