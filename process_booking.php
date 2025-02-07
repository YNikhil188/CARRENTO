<?php
include('config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carid = $_POST['carid'];
    $model = $_POST['model'];
    $price_per_day = $_POST['price_per_day'];
    $model = $_POST['model'];
    $name = $_POST['name'];
    $email = $_SESSION["email"];
    $phone = $_POST['phone'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // Calculate the date difference
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $diff = $start->diff($end)->days;
    if ($diff < 1) {
        die("Error: Invalid date range.");
    }
    // Calculate the total price
    $total_price = $diff * $price_per_day;
    // Insert booking into the database
    $query = "INSERT INTO bookings (car_id, customer_name, email, phone, start_date, end_date, total_price, model) 
              VALUES ('$carid', '$name', '$email', '$phone', '$start_date', '$end_date', '$total_price' ,'$model')";
    if ($conn->query($query) === TRUE) {
        // Redirect to the payment page with necessary details
        header("Location: payment.php?total_price=$total_price&carid=$carid&name=" . urlencode($name));
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
