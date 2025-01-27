<?php
$conn = new mysqli('localhost', 'root', '', 'db_student');
$id = $_POST['id'];
$name = $_POST['name'];
$middle = $_POST['middle'];
$last = $_POST['last'];
$status = $_POST['status'];
$gender = $_POST['gender'];
$position = $_POST['position'];
$image = $_FILES['image']['name'] ? 'uploads/' . $_FILES['image']['name'] : $_POST['current_image'];
move_uploaded_file($_FILES['image']['tmp_name'], $image);
$conn->query("UPDATE tbl_off SET name='$name', middle='$middle', last='$last', status='$status', gender='$gender', position='$position', image='$image' WHERE id=$id");
?>
