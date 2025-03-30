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

// Fetch booking details
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            background: #000; /* Black background */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.05); /* Slight white tint over black */
            border: 1px solid #ff2727; /* Red border */
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(255, 39, 39, 0.2); /* Red-tinted shadow */
        }

        h1 {
            font-size: 2.2em;
            margin-bottom: 15px;
            color: #ff2727; /* Red heading */
            text-align: center;
            text-shadow: 0 2px 4px rgba(255, 39, 39, 0.3);
        }

        p {
            font-size: 1.1em;
            margin-bottom: 25px;
            text-align: center;
            color: #fff; /* White text */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 1.1em;
            font-weight: 500;
            color: #ff2727; /* Red labels */
        }

        select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ff2727; /* Red border */
            border-radius: 8px;
            background: #1a1a1a; /* Dark gray for contrast */
            color: #fff;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        select:focus, textarea:focus {
            outline: none;
            border-color: #ff5555; /* Lighter red on focus */
            box-shadow: 0 0 10px rgba(255, 39, 39, 0.5); /* Red glow */
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        select option {
            background: #1a1a1a;
            color: #fff;
        }

        button {
            background: #ff2727; /* Solid red button */
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            background: #ff5555; /* Lighter red on hover */
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 39, 39, 0.6);
        }

        button:active {
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 20px;
            }

            h1 {
                font-size: 1.8em;
            }

            p {
                font-size: 1em;
            }

            select, textarea, button {
                font-size: 0.95em;
            }
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