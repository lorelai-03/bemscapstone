<?php
// Database configuration
$host = 'localhost';       // Database host, usually 'localhost'
$username = 'root';        // Database username
$password = '';            // Database password
$dbname = 'db_student';       // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
