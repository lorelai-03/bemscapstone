<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID from the AJAX request
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $currentDate = date("Y-m-d H:i:s"); // Current date and time

    // Fetch the resident_id and contact number from tbl_cert and tbl_resi
    $sql = "SELECT c.resident_id, r.contact 
            FROM tbl_cert c
            JOIN tbl_resi r ON c.resident_id = r.id
            WHERE c.id = $id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Get the resident's data
        $row = $result->fetch_assoc();
        $resident_id = $row['resident_id'];
        $contact = $row['contact'];

        // Update status to "Accepted" and set current date as dateapprove
        $updateSql = "UPDATE `tbl_cert` 
                      SET `status` = 'Accepted', `dateapprove` = '$currentDate' 
                      WHERE `id` = $id";

        if ($conn->query($updateSql) === TRUE) {
            // Send SMS notification
            $title = "Certificate Request Approved";
            $message = "Your certificate request has been approved. Thank you!";
            $date = date("Y-m-d");  // Today's date

            // Semaphore API key
            $semaphoreApiKey = '2a9137b9523bb085ebc6e33e6f8f5eaa'; // Your Semaphore API KEY

            // Prepare cURL request
            $ch = curl_init();
            $parameters = array(
                'apikey' => $semaphoreApiKey,
                'number' => $contact,  // Resident's contact number
                'message' => "$title, Date: $date, Message: $message",
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
                echo 'success'; // Success in both DB update and SMS
            }

            // Close curl session
            curl_close($ch);

        } else {
            echo 'error'; // Database update failed
        }
    } else {
        echo 'no_resident'; // No matching resident found
    }
}

$conn->close();
?>
