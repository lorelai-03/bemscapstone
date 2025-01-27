<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Define directories for file copying
$sourceDir = 'C:\\xampp\\htdocs\\bemscapstone\\uploads';
$destDirs = [
    'C:\\xampp\\htdocs\\bemscapstone\\admin\\uploads',
    'C:\\xampp\\htdocs\\bemscapstone\\officials\\uploads'
];

// Function to handle file copying
function copyFiles($sourceFile, $destDirs) {
    if (!file_exists($sourceFile)) {
        die("Source file does not exist.");
    }

    foreach ($destDirs as $destDir) {
        // Create destination directory if it does not exist
        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0777, true)) {
                die("Failed to create destination directory: $destDir.");
            }
        }

        // Copy the file
        $destFile = $destDir . '\\' . basename($sourceFile);
        if (!copy($sourceFile, $destFile)) {
            echo "Failed to copy " . basename($sourceFile) . " to $destFile.";
        }
    }
}

// Sanitize inputs
$firstn = htmlspecialchars($_POST['firstn']);
$lastn = htmlspecialchars($_POST['lastn']);
$middlei = htmlspecialchars($_POST['middlei']);
$gender = htmlspecialchars($_POST['gender']);
$contact = htmlspecialchars($_POST['contact']);
$purok = htmlspecialchars($_POST['purok']);
$username = htmlspecialchars($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if the username already exists using prepared statements
$sql_check = "SELECT * FROM tbl_resi WHERE username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username already exists. Please choose a different username.']);
    exit();
}

// Handle image upload
$imagePath = '';
if (!empty($_FILES['image']['name'])) {
    $targetDir = "C:\\xampp\\htdocs\\bemscapstone\\uploads\\";
    $relativePath = "uploads/"; // Relative path to be saved in the database

    // Create the target directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Validate the image file type
    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $validExtensions = ['jpg', 'jpeg', 'png'];

    if (!in_array($imageFileType, $validExtensions)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid image file type. Only JPG, JPEG, PNG are allowed.']);
        exit();
    }

    // Limit image size to 5MB
    if ($_FILES['image']['size'] > 5000000) {
        echo json_encode(['status' => 'error', 'message' => 'Image file is too large. Maximum size is 5MB.']);
        exit();
    }

    // Generate a unique file name to prevent overwriting
    $fileName = time() . '_' . basename($_FILES['image']['name']);
    $fullImagePath = $targetDir . $fileName;
    $imagePath = $relativePath . $fileName; // Save only the relative path

    // Move the uploaded file
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fullImagePath)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit();
    }

    // Copy the uploaded image to the target directories
    copyFiles($fullImagePath, $destDirs);
}

// Insert user into the database using prepared statements
$sql_insert = "INSERT INTO tbl_resi (firstn, lastn, middlei, gender, contact, purok, imagePath, username, password, approval_status) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";

$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sssssssss", $firstn, $lastn, $middlei, $gender, $contact, $purok, $imagePath, $username, $password);

if ($stmt_insert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'New user registered successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt_insert->error]);
}

$conn->close();
?>
