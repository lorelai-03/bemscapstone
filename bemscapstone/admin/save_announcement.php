<?php
require_once('vendor/autoload.php'); // Point to the vendor directory for other dependencies if needed

// Database connection
$servername = "localhost"; // Change to your server name
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "db_student"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to clean up the description
function cleanDescription($description) {
    // Remove all HTML tags
    $description = strip_tags($description);
    // Remove <p> tags
    $description = preg_replace('/<p[^>]*>.*?<\/p>/i', '', $description);
    // Remove <br> tags
    $description = preg_replace('/<br\s*\/?>/i', '', $description);
    // Replace multiple spaces with a single space
    $description = preg_replace('/\s+/', ' ', $description);
    // Trim leading and trailing spaces
    $description = trim($description);
    return $description;
}

// Get form data
$title = $_POST['title'];
$date = $_POST['date'];
$description = cleanDescription($_POST['description']); // Clean up the description
$purok = isset($_POST['purok']) ? $_POST['purok'] : ''; // Get purok, default to empty if not provided

// Prepare and bind for announcement insertion
$announcementStmt = $conn->prepare("INSERT INTO announcements (title, date, description, purok) VALUES (?, ?, ?, ?)");
$announcementStmt->bind_param("ssss", $title, $date, $description, $purok);

// Execute the statement for announcement
if ($announcementStmt->execute()) {
    echo "New announcement created successfully.";

    // Determine the SQL query based on whether the purok is provided
    if (empty($purok)) {
        // If purok is empty, send to all contacts
        $sql = "SELECT contact FROM tbl_resi";
        $contactStmt = $conn->prepare($sql); // Use a new statement object
        $contactStmt->execute();
    } else {
        // If purok is provided, send to contacts matching that purok
        $sql = "SELECT contact FROM tbl_resi WHERE purok = ?";
        $contactStmt = $conn->prepare($sql); // Use a new statement object
        $contactStmt->bind_param("s", $purok); // Bind purok if it's not empty
        $contactStmt->execute();
    }

    $result = $contactStmt->get_result();

    if ($result->num_rows > 0) {
        // Semaphore API key
        $semaphoreApiKey = '2a9137b9523bb085ebc6e33e6f8f5eaa'; // Your Semaphore API KEY

        // Loop through each contact and send a message using cURL
        while ($row = $result->fetch_assoc()) {
            $contact = $row['contact'];

            // Prepare cURL request
            $ch = curl_init();
            $parameters = array(
                'apikey' => $semaphoreApiKey,
                'number' => $contact,
                'message' => "Announcement: $title, Date: $date, Description: $description.",
                'sendername' => 'CORAL'
            );

            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute API request and get the response
            $output = curl_exec($ch);

            // Handle API response
            if ($output === false) {
                echo "Error sending message to $contact: " . curl_error($ch) . "<br>";
            } else {
                echo "Message sent to $contact successfully.<br>";
            }

            // Close curl session
            curl_close($ch);
        }
    } else {
        echo "No contacts found in the tbl_resi table.<br>";
    }

    // Close the statement for contact query
    $contactStmt->close();
} else {
    echo "Error: " . $announcementStmt->error;
}

// Close connections
$announcementStmt->close(); // Close the announcement insertion statement
$conn->close();
?>
