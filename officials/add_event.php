<?php
require_once('vendor/autoload.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$semaphoreApiKey = '2a9137b9523bb085ebc6e33e6f8f5eaa';

// Function to handle file copying
function copyFiles($sourceDir, $destDirs, $fileName) {
    $sourceFile = $sourceDir . DIRECTORY_SEPARATOR . $fileName;

    // Check if the source file exists
    if (!file_exists($sourceFile)) {
        die("Source file does not exist: $sourceFile.");
    }

    foreach ($destDirs as $destDir) {
        // Create destination directory if it doesn't exist
        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0777, true)) {
                die("Failed to create destination directory: $destDir.");
            }
        }

        $destFile = $destDir . DIRECTORY_SEPARATOR . $fileName;

        // Attempt to copy the file
        if (!copy($sourceFile, $destFile)) {
            echo "Failed to copy $sourceFile to $destFile.";
        }
    }
}

// Function to send SMS using Semaphore API
function sendSms($semaphoreApiKey, $contact, $type, $date, $time, $message) {
    $parameters = [
        'apikey' => $semaphoreApiKey,
        'number' => $contact,
        'message' => "Announcement: $type, Date: $date, Time: $time, Description: $message.",
        'sendername' => 'CORAL'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

// Function to save SMS message and time to tbl_sms
function saveSmsToDatabase($conn, $contact, $message, $sendTime) {
    $stmt = $conn->prepare("INSERT INTO tbl_sms (contact, message, send_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $contact, $message, $sendTime);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = date("h:i A", strtotime($_POST['time'])); // Convert to 12-hour format
    $message = $_POST['message'];

    $image_path = null;

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
        $upload_dir = 'uploads/events/';
        $image_name = basename($image['name']);
        $image_path = $upload_dir . $image_name;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($image['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                // Copy file to multiple destinations
                copyFiles(
                    $upload_dir,
                    [
                        'C:\\xampp\\htdocs\\bemscapstone\\residents\\uploads\\events',
                        'C:\\xampp\\htdocs\\bemscapstone\\admin\\uploads\\events'
                    ],
                    $image_name
                );
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

    // Handle database operations
    if ($event_id) {
        if ($image_path) {
            $sql = "UPDATE tbl_info SET type = '$type', date = '$date', time = '$time', message = '$message', image = '$image_path' WHERE id = $event_id";
        } else {
            $sql = "UPDATE tbl_info SET type = '$type', date = '$date', time = '$time', message = '$message' WHERE id = $event_id";
        }
    } else {
        if ($image_path) {
            $sql = "INSERT INTO tbl_info (type, date, time, message, image) VALUES ('$type', '$date', '$time', '$message', '$image_path')";
        } else {
            $sql = "INSERT INTO tbl_info (type, date, time, message) VALUES ('$type', '$date', '$time', '$message')";
        }
    }

    if ($conn->query($sql) === TRUE) {
        // Send SMS notifications to all contacts in tbl_resi
        $sms_message = "New Event: $type on $date at $time. Details: $message";
        $result = $conn->query("SELECT contact FROM tbl_resi");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $contact = $row['contact'];
                $sendTime = date("Y-m-d H:i:s");  // Get current time in Y-m-d H:i:s format
                sendSms($semaphoreApiKey, $contact, $type, $date, $time, $message);

                // Save SMS details to the database
                saveSmsToDatabase($conn, $contact, $sms_message, $sendTime);
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Event saved, notifications sent, and SMS details saved successfully.'
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
