<?php
// Start session
session_start();

// Sample response for official login
$response = array('success' => false, 'message' => 'Invalid credentials');

// Check if the form data is available
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Database connection (replace with your actual DB credentials)
        $conn = new mysqli('localhost', 'root', '', 'db_student');
        
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Query to check if the official exists in tbl_off
        $stmt = $conn->prepare('SELECT id, username, password, status FROM tbl_off WHERE username = ?');
        $stmt->bind_param('s', $username);  // Bind username
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $official = $result->fetch_assoc();

            // Check if the account status is not "not_active"
            if ($official['status'] !== 'not_active') {
                // Verify the password using password_verify() with the stored hashed password
                if (password_verify($password, $official['password'])) {
                    // Password is correct, start the session
                    $_SESSION['official_id'] = $official['id'];
                    $_SESSION['official_username'] = $official['username'];  // Store username in session for later use
                    
                    // Set success response
                    $response = array('success' => true, 'username' => $official['username']);
                } else {
                    // Password mismatch
                    $response = array('success' => false, 'message' => 'Incorrect password.');
                }
            } else {
                // If account status is "not_active"
                $response = array('success' => false, 'message' => 'Your account is currently inactive.');
            }
        } else {
            // Official not found
            $response = array('success' => false, 'message' => 'No official found with this username.');
        }

        // Return response as JSON
        echo json_encode($response);
        $stmt->close();
        $conn->close();
    } else {
        // If username or password is not set, show an error message
        $response = array('success' => false, 'message' => 'Please fill in both username and password.');
        echo json_encode($response);
    }
}
?>
