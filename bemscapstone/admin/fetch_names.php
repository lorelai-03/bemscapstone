<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch first name, middle name, and last name
$sql = "SELECT firstn, middlei, lastn FROM tbl_resi";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Initialize an array to store the names
    $names = [];

    // Fetch each row of data
    while ($row = $result->fetch_assoc()) {
        // Concatenate first name, middle name, and last name
        $fullName = $row['firstn'] . ' ' . $row['middlei'] . ' ' . $row['lastn'];

        // Add the full name to the names array
        $names[] = ['full_name' => $fullName];
    }

    // Return the names as JSON
    echo json_encode($names);
} else {
    // Return an empty array if no records are found
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
