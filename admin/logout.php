<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    // Update the login_history to add the logout time
    $sql_logout = "UPDATE login_history SET logout_time = CURRENT_TIMESTAMP WHERE admin_id = '$admin_id' AND logout_time IS NULL";
    $conn->query($sql_logout);

    // End session
    session_unset();
    session_destroy();

    // Redirect to index.php after logout
    header("Location: index.php");
    exit();
}

$conn->close();
?>
