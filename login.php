<?php
include("config.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"];  // This will be either email or phone number
    $password = $_POST["password"];

    // Check if the login is an email or phone number
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        // If it's an email, query based on email
        $sql = "SELECT * FROM users WHERE email = '$login' AND password = '$password'";
    } else {
        // If it's a phone number, query based on phone number
        $sql = "SELECT * FROM users WHERE phone = '$login' AND password = '$password'";
    }

    // Execute the query
    $result = $conn->query($sql);

    // Check if a user with the given credentials exists
    if ($result->num_rows == 1) {
        $_SESSION["logged_in"] = true;
        $userInfo = $result->fetch_assoc();

        $_SESSION["id"] = $userInfo["id"];
        $_SESSION["email"] = $userInfo["email"];
        $_SESSION["phone"] = $userInfo["phone"];  // Add phone to session if needed
        $_SESSION["usertype"] = $userInfo["usertype"];
        $_SESSION['employee_id'] = $userInfo['id'];
        $_SESSION['employee_name'] = $userInfo['name'];

        $usertype = $userInfo["usertype"];

        // Redirect based on user type
        if ($usertype == "1") {
            header("Location: dashboard.html");
            exit();
        } elseif ($usertype == "2") {
            header("Location: home.html");
            exit();
        } elseif ($usertype == "3") {
            header("Location: employee.html");
            exit();
        } else {
            echo "Unknown role: $usertype";
        }
    } else {
        // Invalid credentials, show an error message
        echo "<script type='text/javascript'>alert('Invalid Username and Password');window.location.href='login.html';</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
