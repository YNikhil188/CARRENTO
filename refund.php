<?php
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in to view your refund details.');</script>";
    echo "<script>window.location.href = 'login.html';</script>";
    exit;
}

$user_email = $_SESSION['email'];

// Check if refund details are provided in the URL
if (!isset($_GET['booking_id']) || !isset($_GET['refund'])) {
    echo "<script>alert('Invalid refund request.');</script>";
    echo "<script>window.location.href = 'mybookings.php';</script>";
    exit;
}

$booking_id = $_GET['booking_id'];
$refund_amount = floatval($_GET['refund']);

// Verify the cancellation belongs to the user
$stmt = $conn->prepare("
    SELECT bc.booking_id, bc.cancellation_date, bc.refund_amount, bc.refund_percentage, b.model, b.total_price
    FROM booking_cancellations bc
    JOIN bookings b ON bc.booking_id = b.booking_id
    WHERE bc.booking_id = ? AND b.email = ?
");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ss", $booking_id, $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('No refund found for this booking.');</script>";
    echo "<script>window.location.href = 'mybookings.php';</script>";
    exit;
}

$refund = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento - Refund Details</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background-color: rgba(0, 0, 0, 0.85);
            border-bottom: 3px solid #ff2727;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .logo {
            font-family: 'Italianno', sans-serif;
            font-size: 42px;
            color: #ff1e00;
        }
        .logo span {
            color: #fff;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 100px auto 2rem;
            padding: 2rem;
            background-color: #1a1a1a;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }
        h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: #ff5757;
        }
        .refund-details {
            padding: 1.5rem;
            background-color: #262626;
            border-radius: 12px;
            position: relative;
        }
        .refund-details::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #ff2727, #ff5757);
        }
        .refund-details p {
            margin: 0.8rem 0;
            font-size: 1.1rem;
        }
        .refund-details p strong {
            color: #ff5757;
            margin-right: 5px;
        }
        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.9rem;
            background-color: rgba(20, 184, 92, 0.2);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
            margin-top: 1rem;
        }
        .button {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            margin-top: 1.5rem;
            background: linear-gradient(135deg, #ff3b3b, #ff5757);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .button:hover {
            background: linear-gradient(135deg, #ff5757, #ff7070);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">Car<span>Rento</span></div>
    </header>

    <div class="container">
        <h1>Refund Details</h1>
        <div class="refund-details">
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($refund['booking_id']); ?></p>
            <p><strong>Car Model:</strong> <?php echo htmlspecialchars($refund['model']); ?></p>
            <p><strong>Total Price:</strong> ₹<?php echo number_format($refund['total_price'], 2); ?></p>
            <p><strong>Cancellation Date:</strong> <?php echo date('Y M d', strtotime($refund['cancellation_date'])); ?></p>
            <p><strong>Refund Percentage:</strong> <?php echo $refund['refund_percentage']; ?>%</p>
            <p><strong>Refund Amount:</strong> ₹<?php echo number_format($refund['refund_amount'], 2); ?></p>
            <p class="status"><i class="fas fa-check-circle"></i> Refund Requested</p>
            <a href="mybookings.php" class="button">Back to My Bookings</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>