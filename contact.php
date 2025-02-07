<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarRento - Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #000;
            color: #fff;
            display: flex;
            flex-direction: column;
            /* Changed to column for footer and header positioning */
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

        /* Responsive styles */
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
        }

        /* Contact Us Section */
        .contact-us {
            background-color: #000;
            padding: 60px 20px;
            color: #fff;
            text-align: center;
            margin-top: 80px;
            /* To prevent content from hiding under the fixed navbar */
        }

        .contact-us-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-us h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .contact-us p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            flex-wrap: wrap;
            /* Make it responsive */
        }

        .contact-card,
        .map-container {
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
            margin: 10px;
            /* Add margin for spacing */
            flex: 1;
            min-width: 300px;
            /* Ensure a minimum width */
        }

        .contact-card h2,
        .map-container h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #ff2727;
        }

        .contact-card a {
            color: skyblue;
            font-size: 1em;
            margin-bottom: 10px;
        }

        .map-container iframe {
            width: 100%;
            height: 300px;
            border: 0;
            border-radius: 8px;
            /* Added rounded corners */
        }

        .contact-form {
            background-color: #222;
            padding: 30px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .contact-form h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #ff1e00;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            font-size: 1em;
        }

        .contact-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #ff1e00;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #ff2727;
        }

        /* Footer */
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

        .footer-section.about h2,
        .footer-section.about p,
        .footer-section.about .social-icons {
            display: block;
            width: 100%;
            margin-bottom: 20px;
            /* Adjust spacing as needed */
            clear: both;
            /* Ensure no floating conflicts */
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
                /* Stack vertically on small screens */
            }
        }

        /* Chatbot Styles */
        /* Main container */
        #chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1001;
        }

        /* Toggle button */
        #chat-toggle-button {
            background: linear-gradient(135deg, #222, #ff2727);
            background-color: #ff2727;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            font-size: 1.5em;
            cursor: pointer;
            transform: scale(0.7); /* Start small */
            transition: transform 0.3s ease, background 0.3s ease;
        }

        #chat-toggle-button.popup-active {
            opacity: 1; /* Become visible */
            transform: scale(1); /* Grow to normal size */
        }

        #chat-toggle-button:hover {
            transform: scale(1.1);
            background: linear-gradient(135deg, #222, #000);
        }

        /* Chat window */
        .chatbot-window {
            display: none;
            /* Hidden by default */
            position: fixed;
            bottom: 80px;
            /* Adjusted for toggle button */
            right: 20px;
            background: linear-gradient(135deg, #222, #ff2727);
            color: #fff;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            flex-direction: column;
            padding: 15px;
        }

        /* Chat header */
        .chatbot-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chatbot-header h2 {
            font-size: 1.2em;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .chatbot-header button {
            background-color: #ff1744;
            border: none;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .chatbot-header button:hover {
            background-color: #ff616f;
        }

        /* Chat messages */
        .chatbot-messages {
            height: 250px;
            overflow-y: auto;
            margin: 15px 0;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 8px;
        }

        /* Input area */
        #chat-input {
            display: flex;
            gap: 10px;
        }

        #user-input {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: none;
            font-size: 1em;
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            color: black;
            background-color: #fff;
            text-align: right;
            /* Align text inside user input to the right */
        }


        .send-button {
            padding: 10px 20px;
            background-color: #00796b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .send-button:hover {
            background-color: #004d40;
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
            <a href="contact.php" class="nav-btn active">Contact us</a>
        </nav>
    </header>

    <!-- Contact Us Section -->
    <section class="contact-us">
        <div class="contact-us-container">
            <h1>Get in Touch with Us</h1>
            <p>If you have any questions, feel free to reach out to us using the form below or through our contact information.</p>

            <div class="contact-info">
                <div class="contact-card">
                    <h2>Contact Information</h2>
                    <p>Email: <a href="mailto:contact@carrento.com">contact@carrento.com</a></p>
                    <p>Phone: <a href="tel:+91 8225423546">+1234567890</a></p>
                    <p>Address: 123 Main Street, City, Country</p>
                    <a href="chat_user.php" class="nav-btn">Message with Admin</a>
                    </div>
                <div class="map-container">
                    <h2>Our Location</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7423.0102914213285!2d80.0192240808812!3d13.029227671959275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52605c8001b0b3%3A0x17397b086e047e7c!2sSaveetha%20Engineering%20College!5e0!3m2!1sen!2sin!4v1731302702882!5m2!1sen!2sin" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <form class="contact-form" action="contactus.php" method="POST"> <!-- Change action to your form handling script -->
                <h2>Contact Form</h2>
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
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
                <h3><a href="index.html">Home</a></h3>
                <h3><a href="login.html">Cars</a></h3>
                <h3><a href="login.html">Feedback</a></h3>
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

    <!-- Chatbot Section -->
<div id="chatbot-container">
    <!-- Chatbot Toggle Button -->
    <button id="chat-toggle-button" class="chat-toggle-btn">💬</button>

    <!-- Chatbot Window -->
    <div class="chatbot-window" style="display: none;">
        <!-- Chat Header -->
        <div class="chatbot-header">
            <h2>Let's Chat!</h2>
            <button id="close-chatbot" class="close-btn">X</button>
        </div>

        <!-- Chat Messages -->
        <div class="chatbot-messages" id="chat-box">
            <!-- Dynamic messages will be appended here -->
        </div>

        <!-- Chat Input -->
        <form id="dataForm" class="chatbot-form">
            <input type="hidden" id="name" name="name" value="Nikhil" />
            <input type="text" id="user-input" name="content" placeholder="Type your message..." />
            <button type="submit" class="send-button">Send</button>
        </form>
    </div>
</div>

<!-- Chatbot Script -->
<script>
    $(document).ready(function () {
        // Toggle chatbot window visibility
        const toggleButton = $("#chat-toggle-button");
        const chatbotWindow = $(".chatbot-window");
        const closeButton = $("#close-chatbot");

        toggleButton.click(() => {
            chatbotWindow.toggle();
        });

        closeButton.click(() => {
            chatbotWindow.hide();
        });

        // Handle form submission
        $("#dataForm").on("submit", function (event) {
            event.preventDefault(); // Prevent form refresh

            const formData = {
                name: $("#name").val(),
                content: $("#user-input").val(),
            };

            if (!formData.content.trim()) return; // Skip empty messages

            const chatBox = $("#chat-box");

            // Display user message
            const userMessage = $(
                `<div class="message user-message">${formData.name}: ${formData.content}</div>`
            );
            chatBox.append(userMessage);
            $("#user-input").val(""); // Clear input field
            chatBox.scrollTop(chatBox[0].scrollHeight); // Scroll to bottom

            // Show loading message
            const loadingMessage = $(
                '<div class="message bot-message">Bot: Loading...</div>'
            );
            chatBox.append(loadingMessage);

            // Send AJAX request
            $.ajax({
                url: "send_to_python.php", // Replace with your server endpoint
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    // Replace loading with bot response
                    loadingMessage.text(`Bot: ${response.reply || "Sorry, I didn't understand that."}`);
                },
                error: function () {
                    loadingMessage.text("Bot: An error occurred. Please try again.");
                },
            });
        });
    });
</script>
</body>
</html>