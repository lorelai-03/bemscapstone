<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an event ID is provided
if (isset($_POST['id'])) {
    $event_id = $_POST['id'];

    // Delete the event from the database
    $sql = "DELETE FROM tbl_info WHERE id = $event_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'success' => true,
            'message' => 'Event deleted successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error deleting event: ' . $conn->error
        ]);
    }
}

$conn->close();
?>
