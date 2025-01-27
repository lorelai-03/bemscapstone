<?php
require_once('vendor/autoload.php');

$semaphoreApiKey = '2a9137b9523bb085ebc6e33e6f8f5eaa';

// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Function to send SMS using Semaphore
function sendSms($semaphoreApiKey, $contact, $certificateName, $date, $time, $requestMessage) {
    $parameters = [
        'apikey' => $semaphoreApiKey,
        'number' => $contact,
        'message' => "Request Certificate Update: $certificateName, Date: $date, Time: $time, Messages: $requestMessage.",
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

// Function to save SMS message and time to tbl_sms_admin
function saveSmsToDatabase($conn, $contact, $message) {
    $sendTime = date('Y-m-d H:i:s'); // Get the current date and time
    $stmt = $conn->prepare("INSERT INTO tbl_sms (contact, message, send_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $contact, $message, $sendTime);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $certificateName = isset($_POST['certificateName']) ? $_POST['certificateName'] : null;
    $requestMessage = isset($_POST['requestMessage']) ? $_POST['requestMessage'] : null;
    $contact = isset($_POST['contact']) ? $_POST['contact'] : null;

    if ($certificateName && $requestMessage && $contact) {
        $date = date('Y-m-d'); // Current date
        $time = date('h:i A'); // Current time in 12-hour format

        // Create the message
        $message = "Request Certificate Update: $certificateName, Date: $date, Time: $time, Messages: $requestMessage.";

        // Send the SMS with the message
        $response = sendSms($semaphoreApiKey, $contact, $certificateName, $date, $time, $requestMessage);

        // Save SMS to the database
        require_once('db_connection.php'); // Include your DB connection file
        saveSmsToDatabase($conn, $contact, $message); // Assuming $conn is your DB connection

        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Certificate request submitted, SMS sent, and saved to database.',
            'response' => $response // Optional: Include response from the API
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields.'
        ]);
    }
}
?>
