<?php
include('config.php');
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You are not logged in! Redirecting to the login page.');</script>";
    echo "<script>window.location.href = 'login.html';</script>";
    exit();
}

$id = $_SESSION['id'];

// Validate session ID
if (empty($id)) {
    echo "<script>alert('Session ID is empty! Redirecting to the login page.');</script>";
    echo "<script>window.location.href = 'login.html?error=Session ID is empty!';</script>";
    exit();
}

// Use prepared statements to fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Check if profile is incomplete
    if (
        empty($row['name']) || empty($row['phone']) || empty($row['email']) || 
        empty($row['dob']) || empty($row['aadhaar']) || empty($row['address']) || 
        empty($row['license_no'])
    ) {
        // Redirect to profile page if incomplete
        echo "<script>alert('Please complete your profile before booking!');</script>";
        echo "<script>window.location.href = 'profile.html?error=Please complete your profile before booking!';</script>";
        exit();
    } else {
        $_SESSION['profile_complete'] = true;
    }
} else {
    echo "<script>alert('User not found!');</script>";
    echo "<script>window.location.href = 'login.html';</script>";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento - Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
      }
    body {
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
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
      position: sticky;
      top: 0;
      width: 100%;
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

    .booking-container {
      display: flex;
      flex-wrap: wrap;
      margin: 40px 20px;
      padding: 20px;
      background-color: #222;
      width: 95%;
      max-width: 1200px;
      border-radius: 8px;
      box-shadow: 0 8px 16px rgba(255, 39, 39, 0.5);
    }

    .car-details, .form-container {
      flex: 1;
      padding: 10px;
      min-width: 300px;
    }

    .car-details img {
      width: 100%;
      border-radius: 8px;
      margin-top: 20px;
    }

    .form-container h2 {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: #ff3b3b;
    }

    .booking-form label {
      display: block;
      margin-top: 15px;
      font-size: 1rem;
    }

    .booking-form input[type="text"], 
    .booking-form input[type="email"],
    .booking-form input[type="date"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: none;
    }

    .total-price {
      font-size: 1.2rem;
      margin-top: 15px;
      color: #ff3b3b;
    }

    .submit-btn {
      display: inline-block;
      width: 100%;
      padding: 15px;
      text-align: center;
      background-color: #ff2727;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      cursor: pointer;
      margin-top: 20px;
    }
    .submit-btn:hover {
      background-color: #ff1e00;
    }

    .footer {
      width: 100%;
      background-color: #222;
      color: #d3d3d3;
      padding: 40px 20px;
      text-align: center;
      border-top: 5px solid #ff2727;
      border-radius: 16px 16px 0 0;
      margin-top: auto;
    }

    .footer-container {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      justify-content: center;
    }

    .footer-section {
      flex: 1;
      padding: 10px;
      min-width: 250px;
    }

    .footer-section h2 {
      font-size: 1.5em;
      margin-bottom: 10px;
      color: #fff;
    }

    .footer-section a {
      color: #fff;
      text-decoration: none;
    }

    .footer-section a:hover {
      text-decoration: underline;
    }

    .social-icons a {
      margin-right: 10px;
    }

    .social-icons img {
      width: 40px;
      height: 40px;
    }

    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        align-items: center;
      }

      .booking-container {
        flex-direction: column;
        align-items: center;
      }

      .car-details, .form-container {
        min-width: unset;
      }

      .footer-container {
        flex-direction: column;
        gap: 20px;
      }
    }

    @media (max-width: 480px) {
      .logo {
        font-size: 28px;
      }

      .form-container h2 {
        font-size: 1.2rem;
      }

      .footer-section h2 {
        font-size: 1.2rem;
      }

      .submit-btn {
        font-size: 1rem;
        padding: 12px;
      }
    }
  </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">Car<span>Rento</span></div>
    </header>

    <div class="booking-container">
        <div class="car-details">
            <?php
            if (isset($_GET['carid'])) {
                $carid = $_GET['carid'];

                // Use a prepared statement for the query
                $stmt = $conn->prepare("SELECT model, price_per_day, image FROM cars WHERE car_id = ?");
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("i", $carid);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $model = $row['model'];
                    $price_per_day = $row['price_per_day'];
                    $image = $row['image'];
                } else {
                    echo 'Car not found!';
                    exit;
                }

                $stmt->close();
            } else {
                echo 'Invalid car ID!';
                exit();
            }
            ?>
            <img src="uploads/cars/<?php echo $image; ?>" alt="<?php echo $model; ?>" class="car-image">
            <strong>Car Model:</strong> <?php echo $model; ?><br>
            <strong>Price per Day:</strong> ₹<?php echo $price_per_day; ?>
        </div>

        <div class="form-container">
            <h2>Fill in your Details</h2>
            <form action="process_booking.php" method="POST" class="booking-form">
                <input type="hidden" name="carid" value="<?php echo $carid; ?>">
                <input type="hidden" name="price_per_day" value="<?php echo $price_per_day; ?>">
                <input type="hidden" name="model" value="<?php echo $model; ?>">

                <label for="name">Name:</label>
                <input type="text" name="name" required>

                <label for="phone">Phone:</label>
                <input type="text" name="phone" required>

                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" required onchange="calculateTotalDays()">

                <div class="total-price">Total Price: ₹<span id="total-price">0</span></div>

                <button type="submit" class="submit-btn">Confirm Booking</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <!-- Footer content -->
    </footer>

    <script>
        function calculateTotalDays() {
            const pricePerDay = <?php echo $price_per_day; ?>;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);

                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays >= 1) {
                    const total = diffDays * pricePerDay;
                    document.getElementById('total-price').innerText = total;
                } else {
                    document.getElementById('total-price').innerText = '0';
                    alert("End Date must be after the Start Date!");
                }
            }
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Close connection here at the very end
?>
