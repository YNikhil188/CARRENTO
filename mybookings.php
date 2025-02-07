<?php
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "Please log in to view your bookings.";
    exit;
}

// Retrieve logged-in user's email
$user_email = $_SESSION['email'];

// Fetch bookings for the logged-in user
$query = "
    SELECT 
        b.booking_id, b.start_date, b.end_date, b.total_price, b.model, c.image,
        b.returned_date, b.return_location,
        (SELECT COUNT(*) FROM feedback f WHERE f.booking_id = b.booking_id) AS feedback_submitted
    FROM 
        bookings b 
    JOIN 
        cars c 
    ON 
        b.car_id = c.car_id 
    WHERE 
        b.email = '$user_email'
    ORDER BY 
        b.start_date DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento - My Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #000;
                color: #fff;
                margin: 0;
                padding: 0;
            }

            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 50px;
                background-color: #000;
                border-bottom: 5px solid #ff2727;
                position: relative;
                top: 0;
                width: 95%;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                z-index: 1000;
                border-radius: 0 0 16px 16px;
            }

            .logo {
                font-family: 'italianno', sans-serif;
                font-size: 36px;
                color: #ff1e00;
                font-weight: bold;
            }

            .logo span {
                font-family: 'italianno', sans-serif;
                font-size: 36px;
                color: #fff;
                font-weight: bold;
            }

            .container {
                width: 100%;
                max-width: 1200px;
                margin: 20px auto;
                padding: 20px;
                background-color: #222;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(255, 39, 39, 0.5);
            }

            .booking {
                display: flex;
                /* flex-wrap: wrap; Allow the content to wrap */
                margin-bottom: 20px;
                padding: 10px;
                background-color: #333;
                border-radius: 8px;
                width: 100%;
            }

            .booking img {
                width: 120px;
                height: 80px;
                margin-right: 15px;
                border-radius: 5px;
                flex-shrink: 0; /* Prevent the image from shrinking */
            }

            .booking-details {
                display: flex;
                justify-content: space-between;
                /* flex-wrap: wrap; */
                width: 100%;
            }

            .booking-details div {
                margin: 5px;
                width: 100%; /* Ensure the div takes full width by default */
            }

            .feedback-btn, .submitted-btn, .return-btn {
                margin-top: 10px;
                padding: 8px 12px;
                border-radius: 5px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
            }

            .feedback-btn {
                background-color: #ff3b3b;
                color: white;
                border: none;
            }

            .feedback-btn:hover {
                background-color: #ff7070;
            }

            .submitted-btn {
                background-color: #fff;
                color: #000;
                cursor: default;
                border: none;
            }

            .return-btn {
                background-color: #ff9800;
                color: white;
                border: none;
            }

            .return-btn:hover {
                background-color: #ffb74d;
            }

            /* Responsive Design */
            @media (max-width: 1024px) {
                .navbar {
                    padding: 10px 30px;
                }

                .logo {
                    font-size: 30px;
                }

                .container {
                    width: 95%;
                    padding: 15px;
                }

                .booking img {
                    width: 100%;
                    height: auto;
                    margin-right: 0;
                    margin-bottom: 15px;
                }

                .booking-details div {
                    width: 100%;
                    text-align: center;
                }

                .feedback-btn, .submitted-btn, .return-btn {
                    width: 100%;
                    text-align: center;
                }
            }

            @media (max-width: 768px) {
                .navbar {
                    padding: 10px 20px;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .logo {
                    font-size: 28px;
                }

                .container {
                    width: 90%;
                }

                .booking {
                    flex-direction: column;
                    align-items: center;
                }

                .booking img {
                    width: 100%;
                    height: auto;
                    margin-right: 0;
                    margin-bottom: 15px;
                }

                .booking-details div {
                    width: 100%;
                    text-align: center;
                }

                .feedback-btn, .submitted-btn, .return-btn {
                    width: 100%;
                    text-align: center;
                }

                .feedback-btn, .submitted-btn, .return-btn {
                    margin-top: 10px;
                }
            }

            @media (max-width: 480px) {
                .logo {
                    font-size: 24px;
                }

                .container {
                    width: 95%;
                }

                .booking {
                    padding: 10px;
                }

                .booking img {
                    width: 100%;
                    height: auto;
                }

                .booking-details div {
                    margin: 5px 0;
                }

                .feedback-btn, .submitted-btn, .return-btn {
                    padding: 10px 15px;
                }
            }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">Car<span>Rento</span></div>
    </header>

    <div class="container">
        <h1>My Bookings</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="booking">
                    <img src="uploads/cars/<?php echo $row['image']; ?>" alt="<?php echo $row['model']; ?>">
                    <div class="booking-details">
                        <div>
                            <strong>Car Model:</strong> <?php echo $row['model']; ?>
                        </div>
                        <div>
                            <strong>Booking ID:</strong> <?php echo $row['booking_id']; ?>
                        </div>
                        <div>
                            <strong>Start Date:</strong> <?php echo $row['start_date']; ?>
                        </div>
                        <div>
                            <strong>End Date:</strong> <?php echo $row['end_date']; ?>
                        </div>
                        <div>
                            <strong>Total Price:</strong> ₹<?php echo $row['total_price']; ?>
                        </div>
                        <div>
                            <?php if ($row['feedback_submitted'] > 0): ?>
                                <button class="submitted-btn" disabled>Feedback Submitted</button>
                            <?php else: ?>
                                <a href="feedback.php?booking_id=<?php echo $row['booking_id']; ?>" class="feedback-btn">Give Feedback</a>
                            <?php endif; ?>
                        </div>

                        <?php if ($row['returned_date']): ?>
                            <div>
                                <strong>Return Date:</strong> <?php echo $row['returned_date']; ?>
                            </div>
                            <div>
                                <strong>Return Location:</strong> <?php echo $row['return_location']; ?>
                            </div>
                        <?php else: ?>
                            <!-- Return car button if not yet returned -->
                            <button class="return-btn" onclick="window.location.href='return_car.php?booking_id=<?php echo $row['booking_id']; ?>'">Return Car</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No bookings found!</p>
        <?php endif; ?>
    </div>
</body>
</html>
