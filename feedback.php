<?php
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Get the booking ID from the URL
if (!isset($_GET['booking_id'])) {
    echo "Invalid request. No booking ID provided.";
    exit;
}

$booking_id = intval($_GET['booking_id']);

// Check if feedback is already submitted
$query = "SELECT COUNT(*) AS count FROM feedback WHERE booking_id = '$booking_id'";
$result = $conn->query($query);
$feedback_exists = $result->fetch_assoc()['count'] > 0;

if ($feedback_exists) {
    echo "Feedback has already been submitted for this booking.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = intval($_POST['rating']);
    $comments = $conn->real_escape_string($_POST['comments']);
    $user_email = $_SESSION['email'];

    // Insert feedback into the database
    $query = "
        INSERT INTO feedback (booking_id, email, rating, comments, submitted_at)
        VALUES ('$booking_id', '$user_email', '$rating', '$comments', NOW())
    ";

    if ($conn->query($query)) {
        echo "<script>alert('Thank you for your feedback!'); window.location.href = 'mybookings.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch booking details for context
$query = "
    SELECT b.booking_id, c.model 
    FROM bookings b
    JOIN cars c ON b.car_id = c.car_id
    WHERE b.booking_id = '$booking_id'
    LIMIT 1
";

$result = $conn->query($query);
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    echo "Booking not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #222;
            border-radius: 8px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, textarea, select, button {
            margin-bottom: 15px;
        }
        button {
            background-color: #ff3b3b;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Feedback for Booking #<?php echo $booking['booking_id']; ?></h1>
        <p><strong>Car Model:</strong> <?php echo $booking['model']; ?></p>
        <form method="POST">
            <label for="rating">Rating (1-5):</label>
            <select id="rating" name="rating" required>
                <option value="" disabled selected>Select a rating</option>
                <option value="1">1 - Very Poor</option>
                <option value="2">2 - Poor</option>
                <option value="3">3 - Average</option>
                <option value="4">4 - Good</option>
                <option value="5">5 - Excellent</option>
            </select>
            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" placeholder="Write your feedback here..." required></textarea>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>
</html>
