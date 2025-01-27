<?php
// Direct database connection (instead of including a separate file)
$host = 'localhost';  // Database host
$user = 'root';       // Database username
$pass = '';           // Database password
$dbname = 'db_student';  // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form data is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize the input data
    $firstn = mysqli_real_escape_string($conn, $_POST['firstn']);
    $lastn = mysqli_real_escape_string($conn, $_POST['lastn']);
    $middlei = mysqli_real_escape_string($conn, $_POST['middlei']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $purok = mysqli_real_escape_string($conn, $_POST['purok']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Set the default approval status to 'pending'
    $approval_status = 'pending';

    // Validate if passwords match
    if ($password !== $confirm_password) {
        echo 'Password mismatch. Please try again.';
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if an image is uploaded
    if (isset($_FILES['imagePath']) && $_FILES['imagePath']['error'] == 0) {
        $imagePath = 'uploads/' . basename($_FILES['imagePath']['name']);
        // Move the uploaded image to the 'uploads' directory
        move_uploaded_file($_FILES['imagePath']['tmp_name'], $imagePath);
    } else {
        // If no image is uploaded, set a default image or handle accordingly
        $imagePath = 'uploads/default.png';  // Example default image
    }

    // Prepare the SQL query to insert the resident data
    $sql = "INSERT INTO tbl_resi (firstn, lastn, middlei, gender, contact, purok, imagePath, username, password, approval_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters and execute the query
        $stmt->bind_param('ssssssssss', $firstn, $lastn, $middlei, $gender, $contact, $purok, $imagePath, $username, $hashed_password, $approval_status);

        if ($stmt->execute()) {
            echo 'success';  // Return success message
        } else {
            echo 'Failed to add resident. Please try again.';
        }

        $stmt->close();
    } else {
        echo 'Failed to prepare SQL statement.';
    }

    // Close the database connection
    $conn->close();
}
?>
