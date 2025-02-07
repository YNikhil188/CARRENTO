<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento - Car Selection</title>
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
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Header Styles */
        /* Common styles */
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

        .nav-links{
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

        /* Search Section */
        .search-section {
            text-align: center;
            padding: 30px;
            margin-top: 100px;
        }

        .search-section input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-section button {
            padding: 10px 20px;
            background-color: #ff1e00;
            border: none;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
        }

        /* Card Grid */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            gap: 30px;
            padding: 20px;
        }

        /* Updated Card Style */
        .card {
            background-color: #fff;
            color: #333;
            width: 440px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 1, 1, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0 10px;
        }

        .card h3 {
            margin: 10px 0;
            color: #333;
            font-size: 18px;
            font-weight: bold;
        }

        .card p {
            color: #ff1e00;
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }

        .card a {
            display: block;
            width: 100%;
        }

        .card button {
            background-color: #ff1e00;
            color: #fff;
            padding: 10px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            width: 100%;
        }


        .features {
            display: flex;
            justify-content: center;
            gap: 50px;
            color: #555;
            margin: 10px 0;
        }

        .features span {
            font-size: 14px;
        }

        /* Updated View Details Button */
        .card button {
            background-color: #ff1e00;
            color: #fff;
            padding: 10px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .card button:hover {
            background-color: #ff2727;
            color: #fff;
        }


        /* Footer Styles */
        .footer {
            background-color: #222;
            color: #d3d3d3;
            padding: 40px 20px;
            text-align: center;
            width: 100%;
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

            .search-section input {
                width: 200px;
            }

            .card {
                width: 90%;
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
            <a href="cars.html" class="nav-btn active">Cars</a>
            <a href="Blog.html" class="nav-btn">Blog</a>
            <a href="aboutus.html" class="nav-btn">About us</a>
            <a href="contact.php" class="nav-btn">Contact us</a>
        </nav>
    </header>
    <!-- Search Section -->
    <div class="search-section">
        <h1>Select a vehicle group</h1>
        <br>
        <br>
        <input type="text" placeholder="Car" id="searchInput">
        <button onclick="searchCars()">Search</button>
    </div>
    <!-- Car Cards -->
    <div class="card-container" id="carList">
        <?php

       // Check connection
       if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
       }
            // Query to select all images from the table
            $query = "
                SELECT 
                    c.*, 
                    CASE 
                        WHEN EXISTS (SELECT 1 FROM bookings b WHERE b.car_id = c.car_id) THEN 1
                        ELSE 0
                    END AS is_booked
                FROM cars c
            ";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Retrieve car details
                    $image = $row['image'];
                    $model = $row['model'];
                    $price = $row['price_per_day'];
                    $gearbox = $row['gearbox'];
                    $fuel = $row['fuel'];
                    $id = $row['car_id'];
                    $is_booked = $row['is_booked']; // Booking status from the query
                    echo '
                        <div class="card">
                            <img src="uploads/cars/' . $image . '" alt="' . $model . '">
                            <div class="card-header">
                                <h3>' . $model . '</h3>
                                <p>₹' . $price . ' per day</p>
                            </div>
                            <div class="features">
                                <span>🚗 ' . $gearbox . '</span>
                                <span>⛽ ' . $fuel . '</span>
                                <span>❄ Air Conditioner</span>
                            </div>';
                    // Display based on booking status
                    if ($is_booked) {
                        echo '<p style="color: red; font-weight: bold;">Booked</p>';
                    } else {
                        echo '<a href="cardetails.php?carid=' . $id . '"><button>View Details</button></a>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<p>No cars found.</p>';
            }
        $conn->close();
        ?>
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
    <!-- JavaScript for Search Functionality -->
    <script>
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('nav-links');
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
        function searchCars() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cars = document.querySelectorAll('.card');
            cars.forEach(car => {
                const title = car.querySelector('h3').textContent.toLowerCase();
                if (title.includes(input)) {
                    car.style.display = 'block';
                } else {
                    car.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>