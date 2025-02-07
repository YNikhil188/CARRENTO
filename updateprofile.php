<?php
include('config.php');

$user_id = $_SESSION['id'] ?? null;
if ($user_id) {
    // Prepare and sanitize inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $address_type = $conn->real_escape_string($_POST['address-type']);
    $pincode = $conn->real_escape_string($_POST['pincode']);
    $address = $conn->real_escape_string($_POST['address']);
    $aadhaar = $conn->real_escape_string($_POST['aadhaar']);
    $license_no = $conn->real_escape_string($_POST['license_no']);

    // Validate inputs
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        die("Invalid phone number.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }
    if (!preg_match('/^[0-9]{6}$/', $pincode)) {
        die("Invalid pincode.");
    }
    if (empty($address)) {
        die("Address cannot be empty.");
    }
    if (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
        die("Invalid Aadhaar number. It must be a 12-digit number.");
    }

    // File upload handling
    $allowed_file_types = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
    $license = null;
    if (isset($_FILES['license']) && $_FILES['license']['error'] === UPLOAD_ERR_OK) {
        $license_extension = strtolower(pathinfo($_FILES['license']['name'], PATHINFO_EXTENSION));
        if (!in_array($license_extension, $allowed_file_types)) {
            echo "<script>alert('Invalid file format for License. Allowed formats: jpg, jpeg, png, pdf, docx'); window.history.back();</script>";
            exit();
        }
        $license_path = "uploads/license/" . basename($_FILES['license']['name']);
        if (move_uploaded_file($_FILES['license']['tmp_name'], $license_path)) {
            $license = $conn->real_escape_string($license_path);
        }
    }

    $aadhaar_doc = null;
    if (isset($_FILES['aadhaar-doc']) && $_FILES['aadhaar-doc']['error'] === UPLOAD_ERR_OK) {
        $aadhaar_extension = strtolower(pathinfo($_FILES['aadhaar-doc']['name'], PATHINFO_EXTENSION));
        if (!in_array($aadhaar_extension, $allowed_file_types)) {
            echo "<script>alert('Invalid file format for Aadhaar Document. Allowed formats: jpg, jpeg, png, pdf, docx'); window.history.back();</script>";
            exit();
        }
        $aadhaar_doc_path = "uploads/aadhaar/" . basename($_FILES['aadhaar-doc']['name']);
        if (move_uploaded_file($_FILES['aadhaar-doc']['tmp_name'], $aadhaar_doc_path)) {
            $aadhaar_doc = $conn->real_escape_string($aadhaar_doc_path);
        }
    }

    // Build query dynamically
    $sql = "UPDATE users SET 
                name = ?, 
                email = ?, 
                phone = ?, 
                dob = ?, 
                gender = ?, 
                address_type = ?, 
                pincode = ?, 
                address = ?, 
                license_no = ?, 
                aadhaar = ?";
    $types = "sssssssssi";
    $params = [$name, $email, $phone, $dob, $gender, $address_type, $pincode, $address, $license_no, $aadhaar];

    if ($license) {
        $sql .= ", license = ?";
        $types .= "s";
        $params[] = $license;
    }

    if ($aadhaar_doc) {
        $sql .= ", aadhaar_doc = ?";
        $types .= "s";
        $params[] = $aadhaar_doc;
    }

    $sql .= " WHERE id = ?";
    $types .= "i";
    $params[] = $user_id;

    // Prepare and execute query
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("MySQL prepare error: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header("Location: profile.html");
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "User not logged in.";
}

$conn->close();
?>
