<?php
include('config.php');

// Assuming payment and booking details are passed via URL or session
$razorpay_payment_id = isset($_GET['razorpay_payment_id']) ? $_GET['razorpay_payment_id'] : '';
$carid = isset($_GET['carid']) ? $_GET['carid'] : 0;
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : 0;
$name = isset($_GET['name']) ? $_GET['name'] : '';

// Check if carid is valid
if ($carid <= 0) {
    die("Invalid car ID.");
}

// Fetch car details from the database
$query = "SELECT * FROM cars WHERE car_id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}

$stmt->bind_param('i', $carid);
$stmt->execute();
$car_result = $stmt->get_result();

if ($car_result->num_rows > 0) {
    $car = $car_result->fetch_assoc();
    // Debugging: print the fetched car details
} else {
    die("No car found with the given car ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - CarRento</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: #000 ;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 16px;
            overflow: hidden;
        }

        .receipt-container {
            background: #888;
            color: #000;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1);
            width: 450px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .receipt-container:hover {
            transform: translateY(-10px);
        }

        .logo {
            font-family: 'Italianno', sans-serif;
            font-size: 48px;
            color: #ff6f61;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .logo span {
            font-family: 'Italianno', sans-serif;
            font-size: 48px;
            color: #fff;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .receipt-container h1 {
            color: #000;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .receipt-container p {
            font-size: 14px;
            color: #000;
            margin: 8px 0;
        }

        .receipt-container .details {
            margin-top: 20px;
            border-top: 2px solid #0072ff;
            padding-top: 15px;
        }

        .download-btn {
            display: inline-block;
            background: linear-gradient(to right, #ff6f61, #ff334d);
            color: #fff;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 30px;
            margin-top: 30px;
            text-decoration: none;
            transition: all 0.4s ease-in-out;
            width: 100%; /* Full width to make the button more prominent */
        }

        .download-btn:hover {
            background: linear-gradient(to right, #e84e40, #ff334d);
            transform: scale(1.05);
        }

        .logout {
            display: inline-block;
            background-color: #fff;
            color: #333;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            border-radius: 25px;
            margin-top: 15px; /* Adjust the margin to make space between buttons */
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            width: 100%; /* Full width for consistent alignment */
        }

        .logout:hover {
            background-color: #f1f1f1;
            transform: scale(1.05);
        }

        .receipt-container .details p {
            font-size: 15px;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="logo">Car<span>Rento</span></div>
        <h1>Booking Receipt</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Car Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
        <p><strong>Total Amount:</strong> ₹<?php echo number_format($total_price, 2); ?></p>
        <p><strong>Payment ID:</strong> <?php echo htmlspecialchars($razorpay_payment_id); ?></p>

        <div class="details">
            <h3>Booking Details</h3>
            <p><strong>Booking ID:</strong> <?php echo uniqid('BR-'); ?></p>
            <p><strong>Car ID:</strong> <?php echo $carid; ?></p>
            <p><strong>Amount Paid:</strong> ₹<?php echo number_format($total_price, 2); ?></p>
            <p><strong>Payment Status:</strong> Success</p>
        </div>

        <a href="#" class="download-btn" id="downloadReceipt">Download Receipt</a>
        <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <script>
        document.getElementById('downloadReceipt').addEventListener('click', function (e) {
            e.preventDefault();

            // Create a downloadable receipt in PDF format using jsPDF
            const { jsPDF } = window.jspdf;
            var doc = new jsPDF();
            doc.setFont("helvetica");
            doc.setFontSize(16);
            
            doc.text("CarRento Booking Receipt", 20, 20);
            doc.setFontSize(12);
            doc.text("Name: " + "<?php echo htmlspecialchars($name); ?>", 20, 40);
            doc.text("Car Model: " + "<?php echo htmlspecialchars($car['model']); ?>", 20, 50);
            doc.text("Total Amount: " + "<?php echo number_format($total_price, 2); ?>", 20, 60);
            doc.text("Payment ID: " + "<?php echo htmlspecialchars($razorpay_payment_id); ?>", 20, 70);

            doc.text("Booking Details:", 20, 90);
            doc.text("Booking ID: " + "<?php echo uniqid('BR-'); ?>", 20, 100);
            doc.text("Car ID: " + "<?php echo $carid; ?>", 20, 110);
            doc.text("Amount Paid: " + "<?php echo number_format($total_price, 2); ?>", 20, 120);
            doc.text("Payment Status: Success", 20, 130);

            // Save as PDF
            doc.save('CarRento_Receipt.pdf');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>
</html>
