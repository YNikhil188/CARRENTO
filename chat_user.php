<?php
include('config.php');

// Ensure the user is logged in
if (!isset($_SESSION['id']) || $_SESSION['usertype'] != 2) {
    die("Access denied. Please log in as a user.");
}
$userId = intval($_SESSION['id']);

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $sqlInsert = "INSERT INTO message (sender, receiver, message, user_id) 
                      VALUES ('$userId', 'admin', '$message', '$userId')";
        $conn->query($sqlInsert);
    }
    header("Location: chat_user.php");
    exit();
}

// Fetch all messages between the user and the admin
$sqlMessages = "SELECT sender, message, timestamp 
                FROM message 
                WHERE user_id = $userId 
                ORDER BY timestamp ASC";
$resultMessages = $conn->query($sqlMessages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #000, #ff2727);
            color: white;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            position: relative;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
            max-width: 1200px;
            width: 100%;
            justify-content: space-between;
        }

        .logo {
            font-family: 'italianno', sans-serif;
            font-size: 36px;
            color: #ff1e00;
            font-weight: bold;
            border: 2px solid white;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .logo span {
            font-family: 'italianno', sans-serif;
            font-size: 36px;
            color: #fff;
            font-weight: bold;
        }

        h1 {
            margin: 0;
            font-size: 1.8em;
            font-weight: bold;
        }

        .subtitle {
            margin: 0;
            font-size: 0.9em;
            color: #d0e4ff;
            font-style: italic;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            font-size: 1em;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-weight: bold;
            gap: 5px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background-color: #00ff00;
            border-radius: 50%;
            display: inline-block;
        }

        .status-indicator:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }
        .chat-box {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f1f1f1;
            max-width: 100%;
            word-wrap: break-word;
            display: inline-block;
            clear: both;
        }
        .message strong {
            font-weight: bold;
        }
        .message small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #aaa;
        }
        /* Align User's messages (sent) to the right */
        .message.sent {
            background-color: #0056d2;
            color: white;
            text-align: right;
            margin-left: auto;  /* Align right */
            max-width: 70%;
        }
        /* Align Admin's messages (received) to the left */
        .message.received {
            background-color: #e9e9e9;
            color: black;
            text-align: left;
            margin-right: auto;  /* Align left */
            max-width: 70%;
        }
        .input-container {
            display: flex;
            padding: 15px;
            background-color: #000;
            border-top: 1px solid #000;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
        textarea {
            flex: 1;
            resize: none;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            font-size: 1em;
            background-color: #f9f9f9;
            outline: none;
            transition: border 0.3s;
        }
        textarea:focus {
            border-color: #0056d2;
        }
        .send-button {
            margin-left: 10px;
            padding: 10px 20px;
            background-color: #ff2727;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s, transform 0.2s;
        }
        .send-button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">Car<span>Rento</span></div>
            <div>
                <h1>Chat with Admin</h1>
                <p class="subtitle">Ask anything related to your car rental needs</p>
            </div>
            <div class="status-indicator">
                <span class="status-dot"></span> Online
            </div>
        </div>
    </div>
    </div>
    <div class="chat-box">
        <?php if ($resultMessages->num_rows > 0): ?>
            <?php while ($row = $resultMessages->fetch_assoc()): ?>
                <div class="message <?php echo $row['sender'] == $userId ? 'sent' : 'received'; ?>">
                    <strong><?php echo htmlspecialchars($row['sender'] == $userId ? 'You' : 'Admin'); ?>:</strong>
                    <?php echo htmlspecialchars($row['message']); ?>
                    <small><?php echo $row['timestamp']; ?></small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #aaa;">No messages yet.</p>
        <?php endif; ?>
    </div>

    <div class="input-container">
        <form method="POST" style="display: flex; width: 100%;">
            <textarea name="message" rows="2" placeholder="Type your message here..." required></textarea>
            <button type="submit" class="send-button">Send</button>
        </form>
    </div>
</body>
</html>
