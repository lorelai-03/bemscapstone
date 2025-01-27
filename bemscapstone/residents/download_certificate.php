<?php
// Start the session
session_start();

// Ensure the user is logged in (optional, if needed)
if (!isset($_SESSION['resident_id'])) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit();
}

// Check if file_path is passed via GET
if (isset($_GET['file_path'])) {
    $filePath = $_GET['file_path'];

    // Check if the file exists
    if (file_exists($filePath)) {
        // Get file extension and type
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = mime_content_type($filePath);

        // Send the headers to force the file download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Output the file content
        readfile($filePath);
        exit;
    } else {
        // If the file doesn't exist, show an error message
        echo "The file you are trying to download does not exist.";
    }
} else {
    // If file_path is not provided, show an error message
    echo "No file specified for download.";
}
?>
