<?php include('config.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarRento - Toyota Fortuner Details</title>
  <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    /* Body and Layout */
    body {
      background-color: #000;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    /* Header Styles */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 50px;
        background-color: #000;
        border-bottom: 5px solid #ff2727;
        position: fixed;
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

    .nav-links {
        flex: 1;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .nav-btn {
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        color: #000;
        background-color: #fff;
        font-weight: bold;
        transition: background-color 0.3s, color 0.3s;
    }

    .nav-btn.active,
    .nav-btn.red-btn {
        background-color: #ff1e00;
        color: #fff;
    }

    .nav-btn:hover {
        background-color: #ff1e00;
        color: #fff;
    }

    /* Hamburger menu styles */
    .hamburger {
        display: none;
        flex-direction: column;
        gap: 5px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
        z-index: 1100;
    }

    .hamburger span {
        width: 25px;
        height: 3px;
        background-color: #fff;
        border-radius: 5px;
        transition: all 0.3s;
    }


    /* Car Details Section */
    .container {
      width: 100%;
      max-width: 1440px;
      display: flex;
      justify-content: space-between;
      padding: 20px;
      background-color: #000;
      border-radius: 8px;
      margin-top: 80px;
      margin-bottom: 10px;
    }

    /* Left Section */
    .left-section {
      width: 50%;
    }

    .left-section h1 {
      font-size: 2rem;
      margin-bottom: 10px;
    }

    .price {
      color: #ff3b3b;
      font-size: 1.5rem;
      margin-bottom: 20px;
    }

    .car-image {
      align-items: center;
      width: 700px;
      margin-bottom: 20px;
      border-radius: 8px;
      height: 400px;
    }

    /* Right Section */
    .right-section {
      width: 45%;
    }

    .specifications {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 20px;
    }

    .specifications .spec-item {
      width: 48%;
      padding: 15px;
      background-color: #fff;
      border-radius: 8px;
      text-align: center;
      height: 100px;
    }

    .spec-item h3 {
      font-size: 0.9rem;
      color: #000;
      margin-bottom: 5px;
    }

    .spec-item p {
      color: #000;
      font-size: 1.1rem;
    }

    .rent-button {
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
      margin-bottom: 20px;
    }

    /* Car Equipment */
    .car-equipment {
      margin-top: 20px;
    }

    .car-equipment h2 {
      font-size: 1.2rem;
      margin-bottom: 15px;
    }

    .equipment-list {
      list-style: none;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .equipment-list li {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .equipment-list li:before {
      content: '✔';
      color: #ff3b3b;
      font-size: 1rem;
    }

    /* Footer Section */
    .footer {
      background-color: #222;
      color: #d3d3d3;
      padding: 40px 20px;
      text-align: center;
      width: 100%;
      border-top: 5px solid #ff2727;
      border-radius: 16px 16px 0 0;
      margin-top: auto;
      /* Pushes footer to the bottom */
      border-top: 5px solid #ff2727;
      border-radius: 16px 16px 0 0;
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 40px;
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

    .footer-section h2 span {
      color: #ff1e00;
    }

    .footer-section p {
      font-size: 0.9em;
      line-height: 1.6;
      text-align: justify;
    }

    .footer-section h3 {
      font-size: 1.1em;
      margin: 15px 0;
      color: #ff1e00;
    }

    .footer-section a {
      color: #fff;
      text-decoration: none;
      font-size: 0.9em;
    }

    .footer-section a:hover {
      text-decoration: underline;
    }

    .social-icons {
      margin-top: 20px;
    }

    .social-icons a {
      display: inline-block;
      margin-right: 10px;
    }

    .social-icons img {
      width: 40px;
      height: 40px;
      margin: 30px;
    }

    .contact p {
      margin: 5px 0;
    }

    .contact a {
      color: #ff1e00;
    }

    @media screen and (max-width: 768px) {
        .nav-links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px;
            right: 20px;
            text-align: center;
            width: 90%;
            background-color: #333;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .nav-links.active {
            display: flex;
        }

        .hamburger {
            display: flex;
        }

        .nav-auth {
            display: none;
        }

        .container {
        flex-direction: column;
        align-items: center;
      }

      .left-section,
      .right-section {
        width: 100%;
        text-align: center;
      }

      .left-section img {
        width: 100%;
        max-width: 500px;
        height: auto;
      }

      .specifications {
        flex-direction: column;
      }

      .specifications .spec-item {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
      }
    }
  </style>
</head>

<body>
  <!-- Header Section -->
  <header class="navbar">
        <div class="logo">Car<span>Rento</span></div>
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="nav-links" id="nav-links">
            <a href="home.html" class="nav-btn">HOME</a>
            <a href="cars.php" class="nav-btn">Cars</a>
            <a href="Blog.html" class="nav-btn">Blog</a>
            <a href="aboutus.html" class="nav-btn">About us</a>
            <a href="contact.php" class="nav-btn">Contact us</a>
        </nav>
    </header>
<?php
 
  
  if (isset($_GET['carid'])) {
    $carid = $_GET['carid'];


    // Query to select all images from the table
    $query = "SELECT * FROM cars where car_id ='$carid' ";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // Retrieve the image data
        $id = $row['car_id'];
        $image = $row['image'];
        $model = $row['model'];
        $price = $row['price_per_day'];
        $seats = $row['seats'];
        $gearbox = $row['gearbox'];
        $fuel = $row['fuel'];
        $air_conditioner = $row['air_conditioner'];
        $door = $row['doors'];
       
      }
    } else {
      echo 'No data found...';
    }
  }

$conn->close();
?>

  <!-- Car Details Section -->
  <div class="container">
    <!-- Left Section -->
    <div class="left-section">
      <h1><?php echo $model; ?></h1>
      <div class="price">₹<?php echo $price; ?> / day</div>
      <img src="uploads/cars/<?php echo $image; ?>" alt="Toyota Fortuner" class="car-image">
    </div>

    <!-- Right Section -->
    <div class="right-section">
      <h1>Specification</h1>
      <br>
      <div class="specifications">
        <div class="spec-item">
          <h3>Gear Box</h3>
          <p><?php echo $gearbox; ?></p>
        </div>
        <div class="spec-item">
          <h3>Fuel</h3>
          <p><?php echo $fuel; ?></p>
        </div>
        <div class="spec-item">
          <h3>Doors</h3>
          <p><?php echo $door; ?></p>
        </div>
        <div class="spec-item">
          <h3>Air Conditioner</h3>
          <p>yes</p>
        </div>
        <div class="spec-item">
          <h3>Seats</h3>
          <p><?php echo $seats; ?></p>
        </div>
        <div class="spec-item">
          <h3>Distance</h3>
          <p>500</p>
        </div>
      </div>
      <a href="booking.php?carid=<?php echo $id; ?>"><button class="rent-button">Rent it</button></a>

      <!-- Car Equipment -->
      <div class="car-equipment">
        <h2>Car Equipment</h2>
        <ul class="equipment-list">
          <li>ABS</li>
          <li>Air Conditioner</li>
          <li>Air Bags</li>
          <li>Cruise Control</li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Footer Section -->

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section about">
        <h2>Your adventure begins with</h2>
        <div class="logo">Car<span>Rento</span></div>
        <p>
          "Carrento offers a seamless car rental experience, making it easier than ever to find the perfect vehicle for any occasion. With a user-friendly interface, top-rated customer service, and flexible rental plans, Carrento is designed to meet all your driving needs."
        </p>
        <div class="social-icons">
          <a href="#"><img src="img/facebookicon.png" alt="Facebook"></a>
          <a href="#"><img src="img/instagramicon.png" alt="Instagram"></a>
          <a href="#"><img src="img/twittericon.png" alt="Twitter"></a>
        </div>
      </div>
      <div class="footer-section links">
        <h3><a href="index.html">Home</a></h3>
        <h3><a href="cars.html">Cars</a></h3>
        <h3><a href="feedback.html">Feedback</a></h3>
        <h3><a href="aboutus.html">About Us</a></h3>
        <h3><a href="contactus.html">Contact Us</a></h3>
      </div>
      <div class="footer-section contact">
        <h3>Contact Us</h3>
        <p>Email: yalakanikhil30@gmail.com</p>
        <p>Phone: 305-890-2051</p>
        <p>Address: 7620 NW 25th St Unit 2, Miami, FL 33122</p>
        <p>Website: <a href="http://www.example.com">www.example.com</a></p>
      </div>
    </div>
  </footer>
  <script>
    const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
  </script>
</body>
</html>