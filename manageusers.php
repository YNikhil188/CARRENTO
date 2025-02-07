<?php
include("config.php");

// Ensure user is logged in (check if session is set)
if (!isset($_SESSION['id'])) {
    die("User not logged in. Please log in to access the dashboard.");
}

// Fetch all users with usertype=2 from the database
$sql = "SELECT id, name, email, phone, dob, gender, address_type, pincode, address, license 
        FROM users WHERE usertype = 2";
$result = $conn->query($sql);

// Check if query returns results
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Set the response header to application/json
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode($users);

// Close the database connection
$conn->close();
?>
