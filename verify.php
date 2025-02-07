<?php

include('config.php');

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    // Check if the code exists in the database
    $sql = "SELECT * FROM users WHERE verification_code = '$verification_code' AND is_verified = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the user's status to 'verified'
        $sql_update = "UPDATE users SET is_verified = 1 WHERE verification_code = '$verification_code'";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "Your email has been verified successfully!";
        } else {
            echo "Error verifying email: " . $conn->error;
        }
    } else {
        echo "Invalid verification code or email already verified.";
    }
}

$conn->close();

?>
