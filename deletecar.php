<?php
// Include database connection
include('config.php'); // Adjust this path as necessary

// Check if the car ID is provided in the URL
if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // Prepare the SQL delete statement
    $query = "DELETE FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();

    // Check if the car was successfully deleted
    if ($stmt->affected_rows > 0) {
      $response["success"] = true;
    } else {
      $response["fail"] = false;
    }
} else {
    echo "<script>
            alert('No car ID provided.');
            window.location.href = 'managecars.html';
          </script>";
}
echo json_encode($response);
?>
