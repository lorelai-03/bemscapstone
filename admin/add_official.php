<?php
// Direct database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_student';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $middle = mysqli_real_escape_string($conn, $_POST['middle']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Handle image upload
    $imagePath = 'uploads/default.png'; // Default image path
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = 'uploads/';
        $imagePath = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Insert data into database
    $sql = "INSERT INTO tbl_off (name, middle, last, status, gender, position, contact, username, password, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssssssssss', $name, $middle, $last, $status, $gender, $position, $contact, $username, $hashedPassword, $imagePath);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt->close();
    } else {
        echo 'error';
    }

    $conn->close();
}
?>
