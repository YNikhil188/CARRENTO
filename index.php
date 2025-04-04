<?php
include('config.php'); // Include database configuration
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #000;
            color: #fff;
        }
         
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
        
        .nav-links,
        .nav-auth {
            display: flex;
            align-items: center;
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
            position: relative; /* Required for tooltip positioning */
        }

        /* Active & Red Button Styles */
        .nav-btn.active,
        .nav-btn.red-btn {
            background-color: #ff1e00;
            color: #fff;
        }

        /* Hover Effect */
        .nav-btn:hover {
            background-color: #ff1e00;
            color: #fff;
        }

        /* Tooltip Styling */
        .nav-btn::before {
            content: attr(data-title);
            position: absolute;
            top: 120%; /* Places the tooltip below the button */
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff; /* White background */
            color: #000; /* Black text */
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 16px; /* Increased title size */
            font-weight: bold;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            z-index: 10;
            border: 1px solid #000; /* Black border for better visibility */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Light shadow */
        }

        /* Show tooltip on hover */
        .nav-btn:hover::before {
            opacity: 1;
            visibility: visible;
        }

        
        /* Hamburger Menu for Small Screens */
        .menu-toggle {
            display: none;
        }
        
        .menu-icon {
            display: none;
            font-size: 28px;
            color: #fff;
            cursor: pointer;
        }
        
        /* Hero Section */
        .hero {
            margin-top: 80px;
            text-align: center;
            padding: 60px 20px;
            margin-bottom: 80px;
        }
        
        .hero h1 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 3em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .hero h1 span {
            font-family: 'Times New Roman', Times, serif;
            color: #ff1e00;
        }
        
        .hero p {
            font-family: 'italianno', sans-serif;
            font-size: 2em;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        
        .hero p span {
            font-family: 'italianno', sans-serif;
            color: #ff1e00;
        }
        
        .cta-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff1e00;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 16px;
        }
        .video-background1 {
            position: absolute;
            top: 20px;
            left: 0; 
            width: 100%;
            height: 50%;
            object-fit: cover;
            z-index: -1;
            border-radius: 20px;
            filter: blur(5px); /* Adjust the blur radius as needed */
        }
        
        /* Fleet Section */
        .fleet {
            text-align: center;
            color: #fff;
            padding: 40px 20px;
            margin-bottom: 450px;
            margin-top: 200px;
        }
        
        .video-background {
            position: absolute;
            top: 400px;
            left: 0; 
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            border-radius: 20px;
        }
        
        /* Car Categories Section */
        .car-categories {
            padding: 40px 20px;
            text-align: center;
            background-color: #111;
            border-radius: 8px;
            margin-bottom: 40px;
        }
        
        .categories {
            display: flex;
            justify-content: center;
            gap: 20px;
            border-bottom: 5px solid #ff2727;
            border-top: 5px solid #ff2727;
        }
        
        .category img {
            width: 100%;
            height: 100%;
            border-radius: 20px;
        }
        
        /* About Us Section */
        .aboutus {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background-color: #333;
        }
        
        .aboutus-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        
        .aboutus img {
            width: 100%;
            height: auto;
            max-width: 400px;
            margin-right: 20px;
            border-radius: 20px;
        }
        
        .about-text {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        
        .about-text h1, .about-text h2 {
            margin: 10px 0;
        }
        
        .learn-more-btn {
            padding: 10px 20px;
            background-color: #ff1e00;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 25px;
            margin-top: 20px;
        }
        
        .learn-more-btn:hover {
            background-color: #e50000;
        }
        
        /* Services Section */
        .services {
            padding: 40px 20px;
            text-align: center;
        }
        
        .benefits {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .benefits img {
            width: 50px;
            height: 50px;
            background-color: #fff;
        }
        
        /* How It Works Section */
        .how-it-works {
            padding: 40px 20px;
            text-align: center;
        }
        
        .how-it-works .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 100%;
            padding: 20px;
            background-color: #000;
            color: #fff;
        }
        
        .how-it-works .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .how-it-works .header h1 {
            font-size: 2em;
            font-weight: bold;
            margin: 0;
        }
        
        .how-it-works .header p {
            font-size: 1.1em;
            color: #fff;
        }
        
        .how-it-works .content {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 20px;
            width: 100%;
        }
        
        .how-it-works .steps {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .how-it-works .step {
            display: flex;
            background-color: #f3f3f3;
            color: #000;
            border-radius: 10px;
            padding: 20px;
            align-items: center;
            text-align: left;
        }
        
        .how-it-works .step-icon {
            font-size: 24px;
            margin-right: 15px;
        }
        
        .how-it-works .step-content h3 {
            margin: 0;
            font-size: 1.2em;
            font-weight: bold;
        }
        
        .how-it-works .step-content p {
            margin: 5px 0 0;
            font-size: 1em;
            color: #333;
        }
        
        .how-it-works .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .how-it-works .car-image {
            width: 100%;
            max-width: 800px;
            border-radius: 10px;
            height: auto;
        }
        
        /* Footer Section */
        .footer {
            max-width: 100%;
            background-color: #222;
            color: #d3d3d3;
            padding: 40px 20px;
            text-align: center;
            border-top: 5px solid #ff2727;
            border-radius: 16px 16px 0 0;
        }
        
        .footer-container {
            max-width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 0%;
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
        
        .footer-section.about h2,
        .footer-section.about p,
        .footer-section.about .social-icons {
            display: block;
            width: 100%;
            margin-bottom: 20px;
            clear: both;
        }
        
        /* Responsive Styles */
        @media all and (max-width: 768px) {
            .nav-links,
            .nav-auth {
                flex-direction: column;
                position: absolute;
                top: 70px;
                right: 0;
                background-color: #333;
                width: 100%;
                height: 0;
                overflow: hidden;
                transition: height 0.3s ease-in-out;
                z-index: 100;
            }
        
            .menu-toggle:checked ~ .nav-links {
                height: auto;
                overflow: visible;
            }
        
            .menu-toggle:checked ~ .nav-auth {
                height: auto;
                overflow: visible;
                margin-top: 265px;
            }
        
            .menu-icon {
                display: block;
            }
        
            .navbar {
                padding: 10px 20px;
            }
        
            .nav-links a,
            .nav-auth a {
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }
        
            .video-background {
                top: 550px;
                height: 60%;
                border-radius: 10px;
            }
        
            .aboutus {
                padding: 20px;
            }
        
            .aboutus-content {
                flex-direction: column;
                text-align: center;
            }
        
            .aboutus img {
                margin-right: 0;
                margin-bottom: 20px;
                max-width: 80%;
            }
        
            .about-text h2 {
                font-size: 1.2rem;
            }
        
            .learn-more-btn {
                padding: 12px 24px;
                font-size: 1rem;
            }
        
            .how-it-works .content {
                flex-direction: column;
                text-align: center;
            }
        
            .how-it-works .steps {
                flex: none;
                width: 100%;
                margin-bottom: 20px;
            }
        
            .how-it-works .step {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 15px;
            }
        
            .how-it-works .step-icon {
                font-size: 30px;
                margin-bottom: 10px;
            }
        
            .how-it-works .step-content h3 {
                font-size: 1.1em;
            }
        
            .how-it-works .car-image {
                max-width: 100%;
                height: auto;
            }
        }
        
        @media all and (max-width: 480px) {
            .video-background {
                top: 500px;
                height: 70%;
                border-radius: 8px;
            }
        
            .car-categories {
                padding: 20px 10px 40px 10px;
            }
        
            .about-text h1 {
                font-size: 1.5rem;
            }
        
            .about-text h2 {
                font-size: 1rem;
            }
        
            .learn-more-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        
            .how-it-works .header h1 {
                font-size: 1.8em;
            }
        
            .how-it-works .header p {
                font-size: 1em;
            }
        
            .how-it-works .step-content h3 {
                font-size: 1em;
            }
        
            .how-it-works .step-content p {
                font-size: 0.9em;
            }
        
            .how-it-works .car-image {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="navbar">
        <div class="logo">Car<span>Rento</span></div>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>
        <nav class="nav-links">
            <a href="index.php" class="nav-btn active">HOME</a>
            <a href="cars.php" class="nav-btn">Cars</a>
            <a href="blog.html" class="nav-btn">Blog</a>
            <a href="aboutus.html" class="nav-btn">About us</a>
            <a href="contact.php" class="nav-btn">Contact us</a>
        </nav>
        <nav class="nav-auth">
            <?php if (isset($_SESSION['email'])): ?>
                <a href="mybookings.php" class="nav-btn" data-title="My Bookings">
                    <i class="fas fa-clipboard-list"></i>
                </a>
                <a href="profile.php" class="nav-btn" data-title="Profile">
                    <i class="fas fa-user"></i>
                </a>
            <?php endif; ?>
            <?php if (!isset($_SESSION['email'])): ?>
                <a href="login.html" class="nav-btn red-btn" data-title="Sign In"><i class="fas fa-sign-in-alt"></i></a>
                <a href="signup.html" class="nav-btn red-btn" data-title="Sign Up"><i class="fas fa-user-plus"></i></a>
            <?php else: ?>
                <a href="logout.php" class="nav-btn red-btn" data-title="Logout"><i class="fas fa-sign-out-alt"></i></a>
            <?php endif; ?>
        </nav>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <h1><span>Rent</span> a Car for <span>Every</span> Adventure</h1>
        <p>Drive the Extraordinary with <span>CarRento...</span></p>
        <button class="cta-btn" onclick="window.location.href='cars.php'">View All Cars</button>
        <video class="video-background1" autoplay loop muted>
            <source src="video/fleet.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>

    <!-- Fleet Section -->
    <section class="fleet">
        <h1>Unlock Your Journey in Unmatched Elegance</h1>
        <video class="video-background" autoplay loop muted>
            <source src="video/fleet3.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>
    
    <!-- Car Categories Section -->
    <section class="car-categories">
        <h1>Our Fleet</h1>
        <div class="categories">
            <div class="category">
                <img src="img/sedan.jpg" alt="Sedan">
                <h1>Sedan Cars</h1>
            </div>
            <div class="category">
                <img src="img/suv.jpg" alt="SUV">
                <h1>SUV Cars</h1>
            </div>
            <div class="category">
                <img src="img/off_road.jpg" alt="Off-Road">
                <h1>Off-Road Cars</h1>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="aboutus">
        <div class="aboutus-content">
            <div class="about-image">
                <img src="img/driver.jpg" alt="Driver">
            </div>
            <div class="about-text">
                <h1>About Us</h1>
                <h2>We are your trusted companions on the road. Join us on the road to extraordinary moments.</h2>
                <p>At Exotic Rentals, we envision a world where every journey is an opportunity for discovery, where the road becomes a canvas for unforgettable memories. Our commitment lies in providing more than just vehicles; we strive to deliver an experience that transcends the ordinary.</p>
                <button class="learn-more-btn" onclick="window.location.href='aboutus.html'">Learn More</button>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services">
        <h3>Our Services & Benefits</h3>
        <br><br>
        <p>To make renting easy and hassle-free, we provide a variety of services and advantages.<br> 
            We have you covered with a variety of vehicles and flexible rental terms.</p>
        <br><br>
        <div class="benefits">
            <div class="benefit">
                <img src="img/qualityicon.png" alt="Quality">
                <br>
                <h4>Quality Choice</h4>
                <br>
                <p>We offer a wide range of high-quality vehicles to choose from, including luxury cars, SUVs, vans, and more.</p>
            </div>
            <div class="benefit">
                <img src="img/priceicon.png" alt="Price">
                <br>
                <h4>Affordable Prices</h4>
                <br>
                <p>Our rental rates are highly competitive and affordable, allowing our customers to enjoy their trips without breaking the bank.</p>
            </div>
            <div class="benefit">
                <img src="img/bookingicon.png" alt="Booking">
                <br>
                <h4>Convenient Booking</h4>
                <br>
                <p>With our easy-to-use online booking system, customers can quickly and conveniently reserve their rental car from anywhere, anytime.</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <div class="header">
                <h1>How it works</h1>
                <br>
                <p>Renting a car has never been easier. Our streamlined process makes it simple for you to <br> book and confirm your vehicle of choice online</p>
                <br>
            </div>
            <div class="content">
                <div class="steps">
                    <div class="step">
                        <div class="step-icon">🔍</div>
                        <div class="step-content">
                            <h3>Browse and select</h3>
                            <p>Choose from our wide range of premium cars, select the pickup and return dates and locations that suit you best.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-icon">📅</div>
                        <div class="step-content">
                            <h3>Book and confirm</h3>
                            <p>Book your desired car with just a few clicks and receive an instant confirmation via email or SMS.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-icon">😊</div>
                        <div class="step-content">
                            <h3>Enjoy your ride</h3>
                            <p>Pick up your car at the designated location and enjoy your premium driving experience with our top-quality service.</p>
                        </div>
                    </div>
                </div>
                <div class="image-container">
                    <img src="img/how-it-works.jpg" alt="Car" class="car-image">
                </div>
            </div>
        </div>
    </section>

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
                <h3><a href="index.php">Home</a></h3>
                <h3><a href="cars.php">Cars</a></h3>
                <h3><a href="blog.html">Blog</a></h3>
                <h3><a href="aboutus.html">About Us</a></h3>
                <h3><a href="contact.php">Contact Us</a></h3>
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
        // Minimal JavaScript for hamburger menu toggle
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            const navAuth = document.querySelector('.nav-auth');

            menuToggle.addEventListener('change', function () {
                if (menuToggle.checked) {
                    navLinks.style.height = 'auto';
                    navAuth.style.height = 'auto';
                } else {
                    navLinks.style.height = '0';
                    navAuth.style.height = '0';
                }
            });
        });
    </script>
</body>
</html>