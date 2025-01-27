<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];  // The selected name from the dropdown
    $certificateName = $_POST['certificateName'];  // The name of the certificate
    $file = $_FILES['file']; // The uploaded file

    // Define upload directory and allowed file types
    $uploadDir = 'uploads/certificates/';
    $allowedFileTypes = [
        'application/msword', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // MS Word formats
        'application/pdf' // PDF format
    ];
    $maxFileSize = 5 * 1024 * 1024; // Maximum file size (5MB)

    // Define source and destination directories for file copying
    $sourceDir = 'C:\\xampp\\htdocs\\bemscapstone\\admin\\uploads\\certificates';
    $destDir1 = 'C:\\xampp\\htdocs\\bemscapstone\\residents\\uploads\\certificates';

    // Function to handle file copying
    function copyFiles($sourceDir, $destDirs) {
        if (!is_dir($sourceDir)) {
            die("Source directory does not exist.");
        }

        foreach ($destDirs as $destDir) {
            if (!is_dir($destDir)) {
                if (!mkdir($destDir, 0777, true)) {
                    die("Failed to create destination directory: $destDir.");
                }
            }
        }

        $files = scandir($sourceDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $sourceFile = "$sourceDir\\$file";
                if (is_file($sourceFile)) {
                    foreach ($destDirs as $destDir) {
                        $destFile = "$destDir\\$file";
                        if (!copy($sourceFile, $destFile)) {
                            // Optionally handle failure here, e.g., log to a file
                            echo "Failed to copy $sourceFile to $destFile.";
                        }
                    }
                }
            }
        }
    }

    // Check if a file was uploaded
    if ($file['error'] == 0) {
        // Check if the file is of an allowed type
        if (in_array($file['type'], $allowedFileTypes)) {
            // Check file size
            if ($file['size'] <= $maxFileSize) {
                // Create a unique name for the file (to prevent overwriting)
                $fileName = uniqid('certificate_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $filePath = $uploadDir . $fileName;

                // Move the uploaded file to the server's uploads directory
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Call the function to copy files to the destination directories
                    copyFiles($sourceDir, [$destDir1]);

                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "db_student";  // Replace with your actual database name

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Insert the data into the database
                    $sql = "INSERT INTO tbl_certificates (name, certificate_name, file_path) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $name, $certificateName, $filePath); // Bind parameters
                    $stmt->execute();

                    // Close the database connection
                    $stmt->close();
                    $conn->close();

                    // Return a success response
                    echo json_encode(['success' => true, 'message' => 'Certificate request submitted successfully']);
                } else {
                    // Return an error if the file could not be uploaded
                    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
                }
            } else {
                // Return an error if the file is too large
                echo json_encode(['success' => false, 'message' => 'File size exceeds the maximum limit of 5MB']);
            }
        } else {
            // Return an error if the file type is not allowed
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only MS Word and PDF files are allowed']);
        }
    } else {
        // Return an error if no file was uploaded
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    }
} else {
    // Return an error if the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
