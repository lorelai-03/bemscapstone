<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['resident_id'])) {
    die("Please login to change password.");
}

$resident_id = $_SESSION['resident_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Query to fetch the current password for the resident
    $sql = "SELECT password FROM tbl_resi WHERE id = '$resident_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resident = $result->fetch_assoc();
        $hashed_old_password = $resident['password']; // Retrieve stored hashed password

        // Check if the old password is correct
        if (password_verify($old_password, $hashed_old_password)) {
            // Check if new password and confirm password match
            if ($new_password == $confirm_password) {
                // Hash the new password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_sql = "UPDATE tbl_resi SET password = '$hashed_new_password' WHERE id = '$resident_id'";

                if ($conn->query($update_sql) === TRUE) {
                    echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating password.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'New password and confirm password do not match.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Old password is incorrect.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Resident not found.']);
    }
}

$conn->close();
?>
