<?php
include('config.php');

$id = $_SESSION['id'];
// Capture data from the POST request
$data = [
    'payment_id' => $_POST['razorpay_payment_id'],
    'amount' => $_POST['total_price'],
    'product_id' => $_POST['carid']
];

// Define the SQL query to insert data into the fees_table
$sql = "INSERT INTO payment (userid, transaction_id, total_price, product_id) VALUES (?, ?, ?, ?)";

// Prepare the statement
if ($stmt = $conn->prepare($sql)) {
    // Bind the parameters and execute the query
    $stmt->bind_param("ssss", $id, $data['payment_id'], $data['amount'], $data['product_id']);

    if ($stmt->execute()) {
        // Respond with success
        $response = ['msg' => 'Payment successfully credited', 'status' => true];
        echo json_encode($response);
    } else {
        // Respond with error if query execution fails
        $response = ['msg' => 'Error: Unable to insert data into the database', 'status' => false];
        echo json_encode($response);
    }

    // Close the statement
    $stmt->close();
} else {
    // Respond with error if statement preparation fails
    $response = ['msg' => 'Error: ' . $conn->error, 'status' => false];
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
