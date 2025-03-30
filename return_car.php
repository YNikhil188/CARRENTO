<?php
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<div class='error-message'>Please log in to return the car.</div>";
    exit;
}

// Get booking_id from the URL
if (!isset($_GET['booking_id'])) {
    echo "<div class='error-message'>No booking ID specified.</div>";
    exit;
}

$booking_id = $_GET['booking_id'];

// Fetch booking details using prepared statements
$query = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ? AND email = ?");
$query->bind_param("ss", $booking_id, $_SESSION['email']);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    echo "<div class='error-message'>Booking not found.</div>";
    exit;
}

$booking = $result->fetch_assoc();

// Process the return if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $return_date = $_POST['return_date'] ?? '';
    $return_location = $_POST['return_location'] ?? '';
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';

    // Validate input fields
    if (empty($return_date) || empty($return_location)) {
        echo "<div class='error-message'>Please fill all required fields.</div>";
    } else {
        // Update the booking with return details
        $update_query = $conn->prepare("UPDATE bookings SET returned_date = ?, return_location = ?, latitude = ?, longitude = ? WHERE booking_id = ?");
        $update_query->bind_param("ssdds", $return_date, $return_location, $latitude, $longitude, $booking_id);

        if ($update_query->execute()) {
            echo "<div class='feedback-message'>Car return details updated successfully!</div>";
        } else {
            echo "<div class='error-message'>Error updating return details. Please try again.</div>";
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Car - CarRento</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
        }

        .container {
            width: 100%;
            max-width: 700px;
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .container:hover {
            box-shadow: 0 20px 50px rgba(255, 78, 95, 0.2);
        }

        h1 {
            text-align: center;
            color: #ff4e5f;
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            margin-bottom: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="date"],
        input[type="text"] {
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            background: #f8f8f8;
            color: #333;
        }

        input[type="date"]:focus,
        input[type="text"]:focus {
            border-color: #ff4e5f;
            box-shadow: 0 0 8px rgba(255, 78, 95, 0.3);
            outline: none;
            background: #fff;
        }

        button {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #ff4e5f, #ff8e53);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background: linear-gradient(135deg, #ff8e53, #ff4e5f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 78, 95, 0.4);
        }

        button:active {
            transform: scale(0.98);
        }

        #shareLocation {
            background: linear-gradient(135deg, #2f80ed, #56ccf2);
        }

        #shareLocation:hover {
            background: linear-gradient(135deg, #56ccf2, #2f80ed);
            box-shadow: 0 5px 15px rgba(47, 128, 237, 0.4);
        }

        .feedback-message {
            text-align: center;
            color: #fff;
            background: linear-gradient(135deg, #28a745, #34c759);
            padding: 1rem;
            border-radius: 8px;
            font-size: 1rem;
            margin-top: 1.5rem;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            animation: fadeIn 0.5s ease;
        }

        .error-message {
            text-align: center;
            color: #fff;
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            padding: 1rem;
            border-radius: 8px;
            font-size: 1rem;
            margin-top: 1.5rem;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #locationStatus {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
            text-align: center;
            transition: color 0.3s ease;
        }

        #locationStatus.success {
            color: #28a745;
        }

        #locationStatus.error {
            color: #dc3545;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                max-width: 600px;
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                max-width: 90%;
                padding: 1.25rem;
            }

            h1 {
                font-size: clamp(1.25rem, 3vw, 2rem);
            }

            input[type="date"],
            input[type="text"] {
                font-size: 0.9rem;
                padding: 0.65rem 0.9rem;
            }

            button {
                font-size: 1rem;
                padding: 0.65rem 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 1rem;
                margin: 10px;
            }

            h1 {
                font-size: clamp(1rem, 2.5vw, 1.75rem);
            }

            form {
                gap: 1rem;
            }

            label {
                font-size: 0.9rem;
            }

            input[type="date"],
            input[type="text"] {
                font-size: 0.85rem;
                padding: 0.6rem 0.8rem;
            }

            button {
                font-size: 0.9rem;
                padding: 0.6rem 1rem;
            }

            .feedback-message,
            .error-message {
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            #locationStatus {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Return Car - Booking ID: <?php echo htmlspecialchars($booking['booking_id']); ?></h1>

        <form method="POST" id="returnForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?booking_id=' . urlencode($booking_id); ?>">
            <div>
                <label for="return_date">Return Date</label>
                <input type="date" id="return_date" name="return_date" required>
            </div>
            <div>
                <label for="return_location">Return Location</label>
                <input type="text" id="return_location" name="return_location" required>
            </div>
            <div>
                <button type="button" id="shareLocation">Share My Location</button>
                <p id="locationStatus"></p>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>
            <button type="submit">Submit Return</button>
        </form>
    </div>

    <script>
        document.getElementById('shareLocation').addEventListener('click', function () {
            const locationStatus = document.getElementById('locationStatus');
            locationStatus.textContent = "Fetching location...";
            locationStatus.className = '';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                        locationStatus.textContent = "Location shared successfully!";
                        locationStatus.classList.add('success');
                    },
                    function (error) {
                        locationStatus.textContent = "Error fetching location: " + error.message;
                        locationStatus.classList.add('error');
                    }
                );
            } else {
                locationStatus.textContent = "Geolocation is not supported by your browser.";
                locationStatus.classList.add('error');
            }
        });

        document.getElementById('returnForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const formContainer = document.querySelector('.container');

            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(responseText => {
                form.style.display = 'none';
                const messageDiv = document.createElement('div');
                if (responseText.includes('Car return details updated successfully!')) {
                    messageDiv.className = 'feedback-message';
                    messageDiv.textContent = 'Car return details updated successfully!';
                } else {
                    messageDiv.className = 'error-message';
                    messageDiv.innerHTML = responseText;
                }
                formContainer.appendChild(messageDiv);
            })
            .catch(error => {
                console.error('Error submitting the form:', error);
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = 'An error occurred while submitting the form. Please try again.';
                formContainer.appendChild(errorMessage);
            });
        });
    </script>
</body>
</html>