<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db_student");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];  // The ID of the certificate to delete

    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID is required.']);
        exit;
    }

    // SQL to delete the record
    $sql = "DELETE FROM `tbl_cert` WHERE `id` = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting the record.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query.']);
    }

    $conn->close();
}
?>
