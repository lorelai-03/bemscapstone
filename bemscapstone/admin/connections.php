<?php
$connections = mysqli_connect("localhost", "root", "", "db_student");
if (mysqli_connect_errno()) {
	echo "failed to connect to MYSQL: " . mysqli_connect_error();
}
?>
	