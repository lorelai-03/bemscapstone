<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define directories for file copying
$sourceDir = 'C:\\xampp\\htdocs\\bemscapstone\\officials\\uploads\\events';  // Updated source directory
$destDir1 = 'C:\\xampp\\htdocs\\bemscapstone\\residents\\uploads\\events';
$destDir2 = 'C:\\xampp\\htdocs\\bemscapstone\\admin\\uploads\\events';  // Updated destination directory

// Function to handle file copying
function copyFiles($sourceDir, $destDirs, $fileName) {
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

    $sourceFile = "$sourceDir\\$fileName";  // Full path to the source file
    foreach ($destDirs as $destDir) {
        $destFile = "$destDir\\$fileName";
        if (!copy($sourceFile, $destFile)) {
            echo "Failed to copy $sourceFile to $destFile.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];
    
    // Initialize $image_path to null for now
    $image_path = null;

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // Image upload logic
        $image = $_FILES['image'];
        $upload_dir = 'uploads/events/'; // Directory where images will be stored (relative)
        $image_name = basename($image['name']);
        $image_path = $upload_dir . $image_name;

        // Check image type (only allow certain types like .jpg, .jpeg, .png)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($image['tmp_name']);
        
        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded image to the target directory
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                // Call function to copy the image to other directories
                copyFiles('C:\\xampp\\htdocs\\bemscapstone\\officials\\uploads\\events', 
                          ['C:\\xampp\\htdocs\\bemscapstone\\residents\\uploads\\events', 
                           'C:\\xampp\\htdocs\\bemscapstone\\admin\\uploads\\events'], 
                          $image_name);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error uploading image.'
                ]);
                exit();
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid image type. Only JPG, PNG, and GIF are allowed.'
            ]);
            exit();
        }
    }

    // Update or Insert Event
    if ($event_id) {
        // Update existing event
        if ($image_path) {
            $sql = "UPDATE tbl_info SET type = '$type', date = '$date', time = '$time', message = '$message', image = '$image_path' WHERE id = $event_id";
        } else {
            $sql = "UPDATE tbl_info SET type = '$type', date = '$date', time = '$time', message = '$message' WHERE id = $event_id";
        }
    } else {
        // Insert new event
        if ($image_path) {
            $sql = "INSERT INTO tbl_info (type, date, time, message, image) VALUES ('$type', '$date', '$time', '$message', '$image_path')";
        } else {
            $sql = "INSERT INTO tbl_info (type, date, time, message) VALUES ('$type', '$date', '$time', '$message')";
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'success' => true,
            'message' => 'Event saved successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error saving event: ' . $conn->error
        ]);
    }
}

$conn->close();
?>
