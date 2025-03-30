<?php
include('config.php');

// Initialize $result to avoid undefined variable warning
$result = null;

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "Please log in to view your bookings.";
    header("Location: login.html");
    exit;
}

$user_email = $_SESSION['email'];

// Check if the connection was established
if (!$conn) {
    echo "Database connection failed.";
    exit;
}

// Prepare and execute the query, including all bookings
$stmt = $conn->prepare("
    SELECT 
        b.booking_id, b.start_date, b.end_date, b.total_price, b.model, c.image,
        b.returned_date, b.return_location, b.status,
        (SELECT COUNT(*) FROM feedback f WHERE f.booking_id = b.booking_id) AS feedback_submitted
    FROM 
        bookings b 
    JOIN 
        cars c 
    ON 
        b.car_id = c.car_id 
    WHERE 
        b.email = ?
    ORDER BY 
        b.start_date DESC
");

if ($stmt) {
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Query preparation failed: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento - My Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #0f0f0f;
            color: #f5f5f5;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background-color: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 3px solid #ff2727;
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: 0 4px 20px rgba(255, 39, 39, 0.2);
            z-index: 1000;
            border-radius: 0 0 20px 20px;
        }

        .logo {
            font-family: 'Italianno', sans-serif;
            font-size: 42px;
            color: #ff1e00;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 30, 0, 0.3);
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo span {
            font-family: 'Italianno', sans-serif;
            font-size: 42px;
            color: #fff;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #ff2727;
            bottom: -5px;
            left: 0;
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .container {
            width: 95%;
            max-width: 1600px;
            margin: 120px auto 2rem;
            padding: 2rem;
            background-color: #1a1a1a;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
            flex-grow: 1;
        }

        h1 {
            text-align: center;
            margin-bottom: 2.5rem;
            font-size: clamp(1.8rem, 3vw, 2.8rem);
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
            padding-bottom: 10px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #ff2727, transparent);
            border-radius: 2px;
        }

        .booking {
            display: grid;
            grid-template-columns: minmax(200px, 1fr) minmax(0, 4fr);
            gap: 2rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: #262626;
            border-radius: 12px;
            align-items: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .booking::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #ff2727, #ff5757);
            border-radius: 2px 0 0 2px;
        }

        .booking:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 39, 39, 0.15);
        }

        .booking img {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 8px;
            max-width: 300px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .booking:hover img {
            transform: scale(1.02);
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.2rem;
            align-content: start;
        }

        .booking-details div {
            padding: 0.6rem 0;
            position: relative;
        }

        .booking-details div strong {
            color: #ff5757;
            margin-right: 6px;
            font-weight: 600;
        }

        .status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status.active {
            background-color: rgba(20, 184, 92, 0.2);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .status.completed {
            background-color: rgba(52, 73, 94, 0.2);
            color: #bdc3c7;
            border: 1px solid rgba(189, 195, 199, 0.3);
        }

        .status.upcoming {
            background-color: rgba(41, 128, 185, 0.2);
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.3);
        }

        .status.cancelled {
            background-color: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .button-container {
            display: flex;
            flex-wrap: nowrap;
            gap: 1.2rem;
            align-items: center;
            padding-top: 0.8rem;
            grid-column: 1 / -1;
        }

        .feedback-btn, .submitted-btn, .return-btn, .cancel-btn, .cancelled-label {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            width: auto;
            min-width: 150px;
            text-align: center;
            font-size: 0.95rem;
            font-weight: 500;
            gap: 8px;
        }

        .feedback-btn {
            background: linear-gradient(135deg, #ff3b3b, #ff5757);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(255, 59, 59, 0.3);
        }

        .feedback-btn:hover {
            background: linear-gradient(135deg, #ff5757, #ff7070);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 59, 59, 0.4);
        }

        .submitted-btn {
            background-color: #444;
            color: #ccc;
            cursor: not-allowed;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .submitted-btn::before {
            content: '✓';
            position: relative;
            margin-right: 8px;
            font-weight: bold;
        }

        .return-btn {
            background: linear-gradient(135deg, #ff9800, #ffb74d);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        }

        .return-btn:hover {
            background: linear-gradient(135deg, #ffb74d, #ffc777);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 152, 0, 0.4);
        }

        .cancel-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .cancel-btn:hover {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4);
        }

        .cancelled-label {
            background-color: #444;
            color: #e74c3c;
            cursor: default;
        }

        .booking-card-section {
            margin-top: 1rem;
            grid-column: 1 / -1;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .booking-card {
            background-color: #222;
            padding: 1rem;
            border-radius: 8px;
            flex: 1 0 160px;
            border-left: 3px solid #ff5757;
            min-width: 160px;
        }

        .booking-card .title {
            font-size: 0.8rem;
            color: #999;
            margin-bottom: 0.5rem;
        }

        .booking-card .value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #888;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #444;
        }

        .empty-state p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #222;
            margin: 15% auto;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
            border-left: 5px solid #e74c3c;
        }

        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .modal-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #444;
        }

        .modal-header i {
            font-size: 1.5rem;
            color: #e74c3c;
            margin-right: 1rem;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            margin: 0;
        }

        .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .close-btn:hover {
            color: #fff;
        }

        .modal-body {
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .modal-btn {
            padding: 0.7rem 1.4rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn.cancel {
            background-color: #333;
            color: #fff;
            border: none;
        }

        .modal-btn.cancel:hover {
            background-color: #444;
        }

        .modal-btn.confirm {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .modal-btn.confirm:hover {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .booking {
                grid-template-columns: minmax(180px, 1fr) minmax(0, 4fr);
            }
        }

        @media (max-width: 900px) {
            .booking {
                grid-template-columns: 1fr;
            }

            .booking img {
                max-width: 100%;
            }

            .booking-details {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .button-container {
                flex-wrap: wrap;
            }

            .feedback-btn, .submitted-btn, .return-btn, .cancel-btn, .cancelled-label {
                min-width: 130px;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 0.75rem 3%;
            }

            .container {
                width: 98%;
                padding: 1.2rem;
                margin: 90px auto 1rem;
            }

            .booking {
                padding: 1rem;
                gap: 1.2rem;
            }

            .booking-details {
                grid-template-columns: 1fr;
            }

            .button-container {
                flex-direction: column;
                flex-wrap: nowrap;
            }

            .feedback-btn, .submitted-btn, .return-btn, .cancel-btn, .cancelled-label {
                width: 100%;
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">Car<span>Rento</span></div>
        <div class="nav-links">
            <a href="cars.php" class="nav-link">Cars</a>
            <a href="profile.html" class="nav-link">PROFILE</a>
        </div>
    </header>

    <div class="container">
        <h1>My Bookings</h1>
        <?php if (isset($result) && $result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): 
                $current_date = date('Y-m-d');
                $current_datetime = date('Y-m-d H:i:s'); // Current date and time
                
                $is_active = ($current_date >= $row['start_date'] && $current_date <= $row['end_date'] && !$row['returned_date'] && $row['status'] !== 'cancelled');
                $is_completed = $row['returned_date'] ? true : false;
                $is_upcoming = (($current_date <= $row['start_date']) && !$row['returned_date'] && $row['status'] !== 'cancelled');
                $is_cancelled = ($row['status'] === 'cancelled');

                // Calculate days remaining if active
                $days_remaining = 0;
                if ($is_active) {
                    $end = new DateTime($row['end_date']);
                    $today = new DateTime($current_date);
                    $days_remaining = $today->diff($end)->format("%a");
                }

                // Calculate days until start if upcoming
                $days_until_start = 0;
                if ($is_upcoming) {
                    $start = new DateTime($row['start_date']);
                    $today = new DateTime($current_date);
                    $days_until_start = $today->diff($start)->format("%a");
                }
            ?>
                <div class="booking">
                    <?php if ($is_active): ?>
                        <div class="status active"><i class="fas fa-circle"></i> Active</div>
                    <?php elseif ($is_completed): ?>
                        <div class="status completed"><i class="fas fa-check-circle"></i> Completed</div>
                    <?php elseif ($is_upcoming): ?>
                        <div class="status upcoming"><i class="fas fa-clock"></i> Upcoming</div>
                    <?php elseif ($is_cancelled): ?>
                        <div class="status cancelled"><i class="fas fa-times-circle"></i> Cancelled</div>
                    <?php endif; ?>
                    
                    <img src="uploads/cars/<?php echo $row['image']; ?>" alt="<?php echo $row['model']; ?>">
                    
                    <div class="booking-details">
                        <div class="booking-card-section">
                            <div class="booking-card">
                                <div class="title">Car Model</div>
                                <div class="value"><?php echo $row['model']; ?></div>
                            </div>
                            <div class="booking-card">
                                <div class="title">Booking ID</div>
                                <div class="value">#<?php echo substr($row['booking_id'], 0, 8); ?></div>
                            </div>
                            <div class="booking-card">
                                <div class="title">Total Price</div>
                                <div class="value">₹<?php echo number_format($row['total_price']); ?></div>
                            </div>
                            <?php if ($is_active): ?>
                            <div class="booking-card">
                                <div class="title">Days Remaining</div>
                                <div class="value"><?php echo $days_remaining; ?> day<?php echo $days_remaining != 1 ? 's' : ''; ?></div>
                            </div>
                            <?php elseif ($is_upcoming): ?>
                            <div class="booking-card">
                                <div class="title">Starting In</div>
                                <div class="value"><?php echo $days_until_start; ?> day<?php echo $days_until_start != 1 ? 's' : ''; ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div><strong>Start Date:</strong> <?php echo date('Y M d', strtotime($row['start_date'])); ?></div>
                        <div><strong>End Date:</strong> <?php echo date('Y M d', strtotime($row['end_date'])); ?></div>
                        
                        <?php if ($row['returned_date']): ?>
                            <div><strong>Return Date:</strong> <?php echo date('Y M d', strtotime($row['returned_date'])); ?></div>
                            <div><strong>Return Location:</strong> <?php echo $row['return_location']; ?></div>
                        <?php endif; ?>
                        
                        <div class="button-container">
                            <?php if ($is_cancelled): ?>
                                <span class="cancelled-label"><i class="fas fa-times-circle"></i> Cancelled</span>
                            <?php else: ?>
                                <?php if ($is_completed && $row['feedback_submitted'] == 0): ?>
                                    <a href="feedback.php?booking_id=<?php echo $row['booking_id']; ?>" class="feedback-btn">
                                        <i class="fas fa-star"></i> Give Feedback
                                    </a>
                                <?php elseif ($row['feedback_submitted'] > 0): ?>
                                    <button class="submitted-btn" disabled>Feedback Submitted</button>
                                <?php endif; ?>
                                
                                <?php if (!$row['returned_date'] && $is_active): ?>
                                    <a href="return_car.php?booking_id=<?php echo $row['booking_id']; ?>" class="return-btn">
                                        <i class="fas fa-undo-alt"></i> Return Car
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($is_upcoming): ?>
                                    <button class="cancel-btn" onclick="openCancelModal('<?php echo $row['booking_id']; ?>')">
                                        <i class="fas fa-times-circle"></i> Cancel Booking
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-car"></i>
                <p>No bookings found!</p>
                <a href="cars.php" class="feedback-btn"><i class="fas fa-search"></i> Browse Cars</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Cancel Booking Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeCancelModal()">×</span>
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h2>Cancel Booking</h2>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this booking? This action cannot be undone.</p>
                <p>Cancellation fees may apply based on our cancellation policy:</p>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                    <li>7+ days before start date: Full refund</li>
                    <li>3-7 days before start date: 70% refund</li>
                    <li>Less than 3 days: 50% refund</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel" onclick="closeCancelModal()">Go Back</button>
                <form id="cancelForm" method="post" action="cancel_booking.php">
                    <input type="hidden" id="booking_id_input" name="booking_id" value="">
                    <button type="submit" class="modal-btn confirm">Confirm Cancellation</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        const modal = document.getElementById('cancelModal');
        const bookingIdInput = document.getElementById('booking_id_input');

        function openCancelModal(bookingId) {
            modal.style.display = 'block';
            bookingIdInput.value = bookingId;
        }

        function closeCancelModal() {
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                closeCancelModal();
            }
        }
    </script>
</body>
</html>

<?php
// Close the statement and connection
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>