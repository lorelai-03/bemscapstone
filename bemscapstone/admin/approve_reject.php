<?php
// Direct database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action']; // either 'approve', 'reject', or 'delete'

    // Validate inputs
    if (empty($id) || !in_array($action, ['approve', 'delete'])) {
        echo 'failed';
        exit;
    }

    // Prepare SQL query based on action
    if ($action == 'approve') {
        $sql = "UPDATE tbl_resi SET approval_status = 'approved' WHERE id = ?";
    } elseif ($action == 'delete') {
        // Delete the record from the database
        $sql = "DELETE FROM tbl_resi WHERE id = ?";
    }

    // Prepare and execute the query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'failed';
        }
    } else {
        echo 'failed';
    }
    
    $stmt->close();
    $conn->close();
}
?>
