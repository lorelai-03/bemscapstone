<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db_student");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['rname'];
    $type = $_POST['ctype'];
    $purpose = $_POST['Purpose'];

    // Check for empty fields
    if (empty($id) || empty($name) || empty($type) || empty($purpose)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // SQL query to update the certificate record
    $sql = "UPDATE `tbl_cert` 
            SET `rname` = ?, `ctype` = ?, `Purpose` = ? 
            WHERE `id` = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $name, $type, $purpose, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating the record.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query.']);
    }

    $conn->close();
}
?>
