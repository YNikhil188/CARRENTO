<?php

include('config.php');

// Retrieve and sanitize input data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = trim($_POST['password']);

// Check if either email or phone number is provided
if (empty($email) && empty($phone)) {
    echo "<script type='text/javascript'>alert('Please provide either an email or a phone number.');window.location.href='signup.html';</script>";
    exit();
}

// Validate email format (must be @gmail.com)
if (!empty($email) && !preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
    echo "<script type='text/javascript'>alert('Invalid email format. Please use an @gmail.com address.');window.location.href='signup.html';</script>";
    exit();
}

// Validate phone number (must be exactly 10 digits)
if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
    echo "<script type='text/javascript'>alert('Invalid phone number format. Please provide a 10-digit phone number.');window.location.href='signup.html';</script>";
    exit();
}

// Check if the email or phone number already exists in the database
$sql_check_email_or_phone = "SELECT * FROM users WHERE email = ? OR (phone IS NOT NULL AND phone = ?)";
$stmt = $conn->prepare($sql_check_email_or_phone);
$stmt->bind_param("ss", $email, $phone);
$stmt->execute();
$result = $stmt->get_result();

// Handle duplication errors
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['email'] === $email) {
        echo "<script type='text/javascript'>alert('This email is already registered.');window.location.href='signup.html';</script>";
    } elseif ($row['phone'] === $phone) {
        echo "<script type='text/javascript'>alert('This phone number is already registered.');window.location.href='signup.html';</script>";
    }
    exit();
}

// Insert user into the database
$sql = "INSERT INTO users (name, email, phone, password, usertype) 
        VALUES(?, ?, ?, ?, 2)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $phone, $password);

if ($stmt->execute()) {
    echo "<script type='text/javascript'>alert('Signup successful!');window.location.href='login.html';</script>";
} else {
    echo "<script type='text/javascript'>alert('An error occurred during signup. Please try again.');window.location.href='signup.html';</script>";
}

$stmt->close();
$conn->close();
?>
