<?php
session_start();
include('db_connection.php');

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];
$admin_id = 2; // Assuming admin's user ID is 1

// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $admin_id, $message);
    $stmt->execute();
    $stmt->close();
}

// Fetch messages between the user and the admin
$stmt = $conn->prepare("
    SELECT sender_id, message, timestamp 
    FROM messages 
    WHERE (sender_id = ? AND receiver_id = ?) 
       OR (sender_id = ? AND receiver_id = ?)
    ORDER BY timestamp ASC
");
$stmt->bind_param("iiii", $user_id, $admin_id, $admin_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Messages</title>
</head>
<body>
    <h1>Messages with Admin</h1>
    <div>
        <?php foreach ($messages as $msg): ?>
            <div style="<?= $msg['sender_id'] == $admin_id ? 'text-align:left;' : 'text-align:right;' ?>">
                <p><?= htmlspecialchars($msg['message']) ?></p>
                <small><?= date('Y-m-d H:i:s', strtotime($msg['timestamp'])) ?></small>
            </div>
        <?php endforeach; ?>
    </div>
    <form method="post">
        <textarea name="message" required placeholder="Type your message"></textarea>
        <button type="submit">Send</button>
    </form>
</body>
</html>
