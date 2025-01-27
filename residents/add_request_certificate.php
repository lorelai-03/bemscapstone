<?php
// Start the session
session_start();

// Check if the resident is logged in
if (!isset($_SESSION['resident_id'])) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit();
}

// Access the session variables
$resident_id = $_SESSION['resident_id'];
$resident_username = $_SESSION['resident_username'];  // Retrieve the resident's username from session
?>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed");
}

// Function to save SMS message and time to tbl_sms_resi with resident_id
function saveSmsToDatabase($conn, $contact, $message, $sendTime, $resident_id) {
    $stmt = $conn->prepare("INSERT INTO tbl_sms_resi (contact, message, send_time, resident_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $contact, $message, $sendTime, $resident_id);  // Added resident_id as the fourth parameter
    $stmt->execute();
    $stmt->close();
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rname = $conn->real_escape_string($_POST['rname']);
    $ctype = $conn->real_escape_string($_POST['ctype']);
    $purpose = $conn->real_escape_string($_POST['purpose']);

    // Insert data into tbl_cert with resident_id
    $sql = "INSERT INTO tbl_cert (rname, ctype, purpose, status, daterequest, resident_id) 
            VALUES ('$rname', '$ctype', '$purpose', 'Pending', CURRENT_TIMESTAMP, '$resident_id')";
    
    if ($conn->query($sql)) {
        // Send SMS after successfully inserting the certificate request
        $title = "Certificate Request";  // Customize this as needed
        $date = date("Y-m-d");  // Today's date
        $description = "A new certificate request has been submitted by $rname for the purpose of $purpose.";

        // Semaphore API key
        $semaphoreApiKey = '2a9137b9523bb085ebc6e33e6f8f5eaa'; // Your Semaphore API KEY

        // Prepare cURL request
        $ch = curl_init();
        $parameters = array(
            'apikey' => $semaphoreApiKey,
            'number' => '09480177039',  // The contact number to send the SMS
            'message' => "Information: $title, Date: $date, Description: $description.",
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
            echo "sms_error"; // Indicating SMS sending failure
        } else {
            // Save the SMS data to the database
            $sendTime = date('Y-m-d H:i:s'); // Get the current timestamp
            $contact = '09663367020';  // The contact number for the SMS recipient
            saveSmsToDatabase($conn, $contact, "Information: $title, Date: $date, Description: $description.", $sendTime, $resident_id);
            echo 'success'; // Success in both DB and SMS
        }

        // Close curl session
        curl_close($ch);
    } else {
        echo 'db_error'; // Database insertion failed
    }
}

$conn->close();
?>
