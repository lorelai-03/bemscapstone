<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the id is set and is valid
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Delete query
    $sql = "DELETE FROM `tbl_cert` WHERE `id` = $id";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

$conn->close();
?>
