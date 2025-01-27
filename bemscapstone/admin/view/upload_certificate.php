<?php
// Define upload directory
$targetDir = "uploads/";

// Ensure the uploads folder exists
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the certificate name and file are set
    $certificateName = isset($_POST['certificate_name']) ? $_POST['certificate_name'] : '';
    if (isset($_FILES['certificate_file'])) {
        $uploadedFile = $_FILES['certificate_file']['name'];
        $fileType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));

        // Ensure the uploaded file is a .docx file
        if ($fileType !== 'docx') {
            die("Only .docx files are allowed.");
        }

        // Generate a unique file name and save the file to the server
        $filePath = $targetDir . time() . "_" . basename($uploadedFile);

        // Move the uploaded file to the server's target directory
        if (move_uploaded_file($_FILES['certificate_file']['tmp_name'], $filePath)) {
            // Insert data into the database
            $conn = new mysqli('localhost', 'root', '', 'db_student');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL query to insert the certificate record
            $stmt = $conn->prepare("INSERT INTO certificates (certificate_name, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $certificateName, $filePath);
            $stmt->execute();

            // Close the connection
            $stmt->close();
            $conn->close();

            // Redirect back to the upload page after successful upload
            header("Location: view_cert.php");
            exit();
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>
