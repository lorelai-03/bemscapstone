<?php
// Start session if needed
session_start();

// Database connection (replace with your actual credentials)
$pdo = new PDO('mysql:host=localhost;dbname=db_student', 'root', '');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Input validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters long.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("Email already exists. Please try another one.");
    }

    // Insert the new admin account into the database
    $stmt = $pdo->prepare("INSERT INTO admin (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        // Success message
        $_SESSION['message'] = "Admin registered successfully!";
        header('Location: index.php'); // Redirect to the login page
    } else {
        // Error message
        echo "Error registering the admin. Please try again.";
    }
}
?>
