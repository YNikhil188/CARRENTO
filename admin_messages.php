<?php
session_start();
include('db_connection.php');

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

// Fetch users who have sent messages to the admin
$stmt = $conn->prepare("
    SELECT DISTINCT u.id, u.name 
    FROM messages m
    JOIN users u ON (u.id = m.sender_id OR u.id = m.receiver_id)
    WHERE m.receiver_id = 1 OR m.sender_id = 1
    AND u.id != 1
");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle viewing a conversation
$user_id = $_GET['user_id'] ?? null;
if ($user_id) {
    $stmt = $conn->prepare("
        SELECT sender_id, message, timestamp 
        FROM messages 
        WHERE (sender_id = ? AND receiver_id = 1) 
           OR (sender_id = 1 AND receiver_id = ?)
        ORDER BY timestamp ASC
    ");
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Handle admin reply
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (1, ?, ?)");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_messages.php?user_id=$user_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
</head>
<body>
    <h1>Messages</h1>
    <h2>Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="?user_id=<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if ($user_id && isset($messages)): ?>
        <h2>Conversation with User <?= htmlspecialchars($user_id) ?></h2>
        <div>
            <?php foreach ($messages as $msg): ?>
                <div style="<?= $msg['sender_id'] == 1 ? 'text-align:left;' : 'text-align:right;' ?>">
                    <p><?= htmlspecialchars($msg['message']) ?></p>
                    <small><?= date('Y-m-d H:i:s', strtotime($msg['timestamp'])) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="post">
            <textarea name="message" required placeholder="Type your reply"></textarea>
            <button type="submit">Send</button>
        </form>
    <?php endif; ?>
</body>
</html>
