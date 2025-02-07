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
    exit; // Ensure no further content is loaded after form submission
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Car - CarRento</title>
    <style>
    /* General styles */
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #333;
    }

    .container {
        width: 100%;
        max-width: 600px;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
        box-sizing: border-box;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    h1 {
        text-align: center;
        color: #ff7e5f;
        font-size: 28px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        font-size: 16px;
        margin-bottom: 8px;
        color: #555;
        font-weight: bold;
    }

    input[type="date"],
    input[type="text"] {
        padding: 12px;
        margin-bottom: 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        width: 100%;
        transition: border-color 0.3s;
    }

    input[type="date"]:focus,
    input[type="text"]:focus {
        border-color: #ff7e5f;
        outline: none;
    }

    button {
        padding: 12px;
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
    }

    button:hover {
        background: linear-gradient(135deg, #feb47b, #ff7e5f);
    }

    button:active {
        transform: scale(0.98);
    }

    #shareLocation {
        margin-bottom: 15px;
        background: linear-gradient(135deg, #56ccf2, #2f80ed);
    }

    #shareLocation:hover {
        background: linear-gradient(135deg, #2f80ed, #56ccf2);
    }

    .feedback-message {
        text-align: center;
        color: #28a745;
        margin-top: 20px;
        font-size: 16px;
        background: #e7f8ec;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .error-message {
        text-align: center;
        color: #dc3545;
        margin-top: 20px;
        font-size: 16px;
        background: #f8e7e7;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    #locationStatus {
        font-size: 14px;
        color: #555;
        margin-top: 8px;
        text-align: center;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .container {
            width: 90%;
            padding: 20px;
        }

        h1 {
            font-size: 22px;
        }

        input[type="date"],
        input[type="text"] {
            font-size: 14px;
        }

        button {
            font-size: 16px;
            padding: 10px;
        }
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Return Car - Booking ID: <?php echo htmlspecialchars($booking['booking_id']); ?></h1>

        <form method="POST" id="returnForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?booking_id=' . urlencode($booking_id); ?>">
            <div>
                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" name="return_date" required>
            </div>
            <div>
                <label for="return_location">Return Location:</label>
                <input type="text" id="return_location" name="return_location" required>
            </div>
            <div>
                <button type="button" id="shareLocation">Share My Location</button>
                <p id="locationStatus" style="color: gray; font-size: 14px;"></p>
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

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                        locationStatus.textContent = "Location shared successfully!";
                    },
                    function (error) {
                        locationStatus.textContent = "Error fetching location. Please try again.";
                    }
                );
            } else {
                locationStatus.textContent = "Geolocation is not supported by your browser.";
            }
        });

        document.getElementById('returnForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const form = event.target;
            const formData = new FormData(form);
            const formContainer = document.querySelector('.container');

            // Perform the AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(responseText => {
                // Hide the form and display the success message
                if (responseText.includes('Car return details updated successfully!')) {
                    form.style.display = 'none';
                    const successMessage = document.createElement('div');
                    successMessage.className = 'feedback-message';
                    successMessage.textContent = 'Car return details updated successfully!';
                    formContainer.appendChild(successMessage);
                } else {
                    // Show error message if any
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message';
                    errorMessage.innerHTML = responseText; // Display server response as HTML
                    formContainer.appendChild(errorMessage);
                }
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
