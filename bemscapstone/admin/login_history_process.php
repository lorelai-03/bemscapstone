<?php
session_start();

// Database connection (replace with your actual database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to find the admin account by email
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            // Correct password, set session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            // Record login history
            $admin_id = $_SESSION['admin_id'];
            $sql_login = "INSERT INTO login_history (admin_id, action) VALUES ('$admin_id', 'login')";
            $conn->query($sql_login);

            echo json_encode([
                'success' => true,
                'message' => 'Login successful.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid email or password.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Admin not found.'
        ]);
    }
}

$conn->close();
?>
