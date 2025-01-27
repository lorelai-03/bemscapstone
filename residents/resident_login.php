<?php
// Start session
session_start();

// Sample response for resident login
$response = array('success' => false, 'message' => 'Invalid credentials');

// Check if the form data is available
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Sample database connection (replace with your actual DB credentials)
        $conn = new mysqli('localhost', 'root', '', 'db_student');
        
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Sample query to check if the resident exists (replace with your actual query)
        $stmt = $conn->prepare('SELECT id, username, password, approval_status FROM tbl_resi WHERE username = ?');
        $stmt->bind_param('s', $username);  // Binding username
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $resident = $result->fetch_assoc();

            // Check if the account status is approved
            if ($resident['approval_status'] === 'approved') {
                // Verify the password using password_verify() with the stored hashed password
                if (password_verify($password, $resident['password'])) {
                    // Password is correct, start the session
                    $_SESSION['resident_id'] = $resident['id'];
                    $_SESSION['resident_username'] = $resident['username'];  // Store username in session for later use
                    
                    // Set success response
                    $response = array('success' => true, 'username' => $resident['username']);
                } else {
                    // Password mismatch
                    $response = array('success' => false, 'message' => 'Incorrect password.');
                }
            } else {
                // If account status is not approved
                $response = array('success' => false, 'message' => 'Your account has not yet been accepted.');
            }
        } else {
            // Resident not found
            $response = array('success' => false, 'message' => 'No resident found with this username.');
        }

        // Return response as JSON
        echo json_encode($response);
        $conn->close();
    } else {
        // If username or password is not set, show an error message
        $response = array('success' => false, 'message' => 'Please fill in both username and password.');
        echo json_encode($response);
    }
}
?>
