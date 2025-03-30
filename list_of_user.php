<?php
// Include the config file for database connection
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['usertype'])) {
    die("Access denied. Please log in first.");
}

// Restrict access to admin only (usertype = 1)
if ($_SESSION['usertype'] != 1) {
    die("Access denied. Only admins can view this page.");
}

// Fetch users with usertype = 2
$sql_users = "SELECT id, name FROM users WHERE usertype = 2";
$result_users = $conn->query($sql_users);

// Fetch employees with usertype = 3
$sql_employees = "SELECT id, name FROM users WHERE usertype = 3";
$result_employees = $conn->query($sql_employees);

if (!$result_users || !$result_employees) {
    die("Query failed: " . $conn->error); // Display SQL error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Users and Employees</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom , #ff2727, #000);
            color: #333;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00796b;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.15);
            background-color: #ffffff;
            border-radius: 20px;
            margin-left: 0px;
            margin-right: 0px;
        }

        .section {
            margin-bottom: 50px;
        }

        .user-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .user-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(135deg, #ffffff, #f0f4f7);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s, box-shadow 0.4s;
            position: relative;
            overflow: hidden;
        }

        .user-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .user-card img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 5px solid #00796b;
            transition: transform 0.4s;
        }

        .user-card:hover img {
            transform: scale(1.3);
        }

        .user-card h3 {
            font-size: 1.6rem;
            margin: 12px 0;
            color: #444;
            font-weight: 600;
            text-transform: capitalize;
            text-align: center;
        }

        .user-card a {
            text-decoration: none;
            background: linear-gradient(to right, #00796b, #004d40);
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1.1rem;
            margin-top: 20px;
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.1);
        }

        .user-card a:hover {
            background: linear-gradient(to right, #004d40, #00251a);
            transform: scale(1.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .notification-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #ff5722;
            color: #fff;
            padding: 8px 12px;
            border-radius: 50%;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .notification-badge.employee {
            background: #ffb300;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Message Users and Employees</h1>

        <!-- Users Section -->
        <div class="section">
            <h2>Users</h2>
            <div class="user-grid">
                <?php
                if ($result_users->num_rows > 0) {
                    while ($row = $result_users->fetch_assoc()) {
                        $name = htmlspecialchars($row['name']);
                        $id = $row['id'];
                        echo '<div class="user-card">';
                        echo '<span class="notification-badge">💬</span>';
                        echo '<img src="https://via.placeholder.com/110" alt="User Avatar">';
                        echo '<h3>' . $name . '</h3>';
                        echo '<a href="chat_admin.php?user=' . urlencode($id) . '">Message User</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No users found.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Employees Section -->
        <div class="section">
            <h2>Employees</h2>
            <div class="user-grid">
                <?php
                if ($result_employees->num_rows > 0) {
                    while ($row = $result_employees->fetch_assoc()) {
                        $name = htmlspecialchars($row['name']);
                        $id = $row['id'];
                        echo '<div class="user-card">';
                        echo '<span class="notification-badge employee">💼</span>';
                        echo '<img src="https://via.placeholder.com/110" alt="Employee Avatar">';
                        echo '<h3>' . $name . '</h3>';
                        echo '<a href="chat_admin.php?user=' . urlencode($id) . '">Message Employee</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No employees found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
