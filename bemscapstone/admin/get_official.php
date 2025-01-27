<?php
$conn = new mysqli('localhost', 'root', '', 'db_student');
$id = $_POST['id'];
$result = $conn->query("SELECT * FROM tbl_off WHERE id = $id");
echo json_encode($result->fetch_assoc());
?>
