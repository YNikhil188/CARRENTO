<?php
// Include database connection
include('config.php'); // Adjust this to your actual database connection file

// Check if the car ID is set in the URL
if (isset($_GET['id'])) {
    $car_id = intval($_GET['id']);
    // Fetch car data from the database
    $query = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
    
    // Check if car data was found
    if (!$car) {
        echo "Car not found!";
        exit;
    }
} else {
    echo "No car ID provided!";
    exit;
}

// Update the car details in the database upon form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = $_POST['model'];
    $price_per_day = floatval($_POST['price_per_day']);
    $gearbox = $_POST['gearbox'];
    $fuel = $_POST['fuel'];
    $doors = intval($_POST['doors']);
    $air_conditioner = isset($_POST['air_conditioner']) ? 1 : 0;
    $seats = intval($_POST['seats']);
    
    $update_query = "UPDATE cars SET model = ?, price_per_day = ?, gearbox = ?, fuel = ?, doors = ?, air_conditioner = ?, seats = ? WHERE car_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sdssiiis", $model, $price_per_day, $gearbox, $fuel, $doors, $air_conditioner, $seats, $car_id);
    
    if ($update_stmt->execute()) {
        echo "<script>
            alert('Car edited successfully');
            window.location.href='managecars.html';
        </script>";
    } else {
        $error_message = "Failed to update car details: " . $update_stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CarRento - Edit Car</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff2727;
            --background-color: #000000;
            --text-color: #ffffff;
            --input-bg: #1a1a1a;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 15px;
            line-height: 1.6;
        }

        .edit-car-container {
            background-color: #1a1a1a;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(255, 39, 39, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 700px;
            margin: auto;
            border: 2px solid var(--primary-color);
        }

        .edit-car-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .edit-car-header h2 {
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .edit-car-header h2 i {
            margin-right: 15px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .form-control, 
        .form-select {
            background-color: var(--input-bg);
            color: var(--text-color);
            border-color: var(--primary-color);
            padding: 12px;
            border-radius: 8px;
        }

        .form-control:focus, 
        .form-select:focus {
            background-color: #2a2a2a;
            color: var(--text-color);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 39, 39, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff4747;
            border-color: #ff4747;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(255, 39, 39, 0.3);
        }

        .form-check-input {
            background-color: var(--input-bg);
            border-color: var(--primary-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .edit-car-container {
                padding: 20px;
                margin: 10px;
            }

            .edit-car-header h2 {
                font-size: 1.5rem;
            }

            .form-control, 
            .form-select {
                padding: 10px;
            }

            .btn-primary {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 5px;
            }

            .edit-car-container {
                padding: 15px;
            }

            .row > .col-md-6 {
                margin-bottom: 15px;
            }

            .edit-car-header h2 {
                font-size: 1.3rem;
            }

            .edit-car-header h2 i {
                margin-right: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="edit-car-container">
            <div class="edit-car-header">
                <h2>
                    <i class="fas fa-car-alt"></i>
                    Edit Car
                </h2>
            </div>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="model" class="form-label">Car Model</label>
                        <input type="text" class="form-control" id="model" name="model" 
                               value="<?php echo htmlspecialchars($car['model']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price_per_day" class="form-label">Price Per Day ($)</label>
                        <input type="number" class="form-control" id="price_per_day" 
                               name="price_per_day" step="0.01" 
                               value="<?php echo htmlspecialchars($car['price_per_day']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gearbox" class="form-label">Gearbox Type</label>
                        <select class="form-select" id="gearbox" name="gearbox" required>
                            <option value="Automatic" <?php echo ($car['gearbox'] == 'Automatic') ? 'selected' : ''; ?>>Automatic</option>
                            <option value="Manual" <?php echo ($car['gearbox'] == 'Manual') ? 'selected' : ''; ?>>Manual</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fuel" class="form-label">Fuel Type</label>
                        <select class="form-select" id="fuel" name="fuel" required>
                            <option value="Petrol" <?php echo ($car['fuel'] == 'Petrol') ? 'selected' : ''; ?>>Petrol</option>
                            <option value="Diesel" <?php echo ($car['fuel'] == 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                            <option value="Electric" <?php echo ($car['fuel'] == 'Electric') ? 'selected' : ''; ?>>Electric</option>
                            <option value="Hybrid" <?php echo ($car['fuel'] == 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="doors" class="form-label">Number of Doors</label>
                        <select class="form-select" id="doors" name="doors" required>
                            <option value="2" <?php echo ($car['doors'] == 2) ? 'selected' : ''; ?>>2 Doors</option>
                            <option value="4" <?php echo ($car['doors'] == 4) ? 'selected' : ''; ?>>4 Doors</option>
                            <option value="5" <?php echo ($car['doors'] == 5) ? 'selected' : ''; ?>>5 Doors</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="seats" class="form-label">Number of Seats</label>
                        <select class="form-select" id="seats" name="seats" required>
                            <option value="2" <?php echo ($car['seats'] == 2) ? 'selected' : ''; ?>>2 Seats</option>
                            <option value="4" <?php echo ($car['seats'] == 4) ? 'selected' : ''; ?>>4 Seats</option>
                            <option value="5" <?php echo ($car['seats'] == 5) ? 'selected' : ''; ?>>5 Seats</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="air_conditioner" class="form-label">Air Conditioner</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="air_conditioner" 
                                   name="air_conditioner" 
                                   <?php echo ($car['air_conditioner'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="air_conditioner">
                                Available
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>
                        Update Car Details
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>