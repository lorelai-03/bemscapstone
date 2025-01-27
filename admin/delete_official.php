<?php
$conn = new mysqli('localhost', 'root', '', 'db_student');
$id = $_POST['id'];
$conn->query("DELETE FROM tbl_off WHERE id=$id");
?>
