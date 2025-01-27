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

// Get certificate ID from POST
$id = $_POST['id'];

// Fetch the certificate data
$sql = "SELECT `id`, `rname`, `ctype`, `purpose` FROM `tbl_cert` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Record not found']);
}

$stmt->close();
$conn->close();
?>
