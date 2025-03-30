<?php
include("config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];  // This will be either email or phone number
    $newPassword = $_POST["new_password"];  // The new password

    // Check if the login is an email or phone number
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        // If it's an email, query based on email
        $sql = "SELECT * FROM users WHERE email = '$login'";
    } else {
        // If it's a phone number, query based on phone number
        $sql = "SELECT * FROM users WHERE phone = '$login'";
    }

    // Execute the query
    $result = $conn->query($sql);

    // Check if a user with the given credentials exists
    if ($result->num_rows == 1) {
        // User found, update password
        $userInfo = $result->fetch_assoc();
        $userId = $userInfo["id"];

        // Update password in the database (hashed for security)
        $updateSql = "UPDATE users SET password = '$newPassword' WHERE id = '$userId'";

        if ($conn->query($updateSql) === TRUE) {
            // Password updated successfully
            echo "<script>alert('Your password has been successfully updated.'); window.location.href='login.html';</script>";
        } else {
            // If there's an error updating the password
            echo "<script>alert('Error updating password. Please try again later.'); window.location.href='forgotpassword.html';</script>";
        }
    } else {
        // If no user is found with the given login
        echo "<script>alert('No account found with the provided email or phone number.'); window.location.href='forgotpassword.html';</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
