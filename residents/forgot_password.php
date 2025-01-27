<?php
require_once('vendor/autoload.php'); // Load Semaphore SDK
require_once('db_connection.php');  // Replace with your database connection file

$message = ''; // Variable to store message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $semaphoreApiKey = '2a9137b9523bb085ebc6e33e6f8f5eaa'; // Your Semaphore API KEY

    // Check if the contact and username match in the database
    $stmt = $conn->prepare("SELECT id FROM tbl_resi WHERE contact = ? AND username = ?");
    $stmt->bind_param("ss", $contact, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a new password
        $newPassword = bin2hex(random_bytes(4)); // 8-character random password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmtUpdate = $conn->prepare("UPDATE tbl_resi SET password = ? WHERE contact = ? AND username = ?");
        $stmtUpdate->bind_param("sss", $hashedPassword, $contact, $username);
        $stmtUpdate->execute();

        // Send the new password via Semaphore
        $parameters = [
            'apikey' => $semaphoreApiKey,
            'number' => $contact,
            'message' => "Your new password is: $newPassword. Please change it after login.",
            'sendername' => 'CORAL'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        $message = "success";  // Set message for success
    } else {
        $message = "invalid";  // Set message for invalid contact or username
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Forgot Password - BEMS</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.ico">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/logo/cnb.jpg&quot;); max-width: 100%; width: 30px;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Forgot Your Password?</h4>
                                    </div>
                                    <form method="POST" action="forgot_password.php">
                                        <div class="mb-3">
                                            <input class="form-control" type="text" name="username" placeholder="Enter Username" required>
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control" type="text" name="contact" placeholder="Enter Registered Number" required>
                                        </div>
                                        <button class="btn btn-primary d-block w-100" type="submit">Submit</button>
                                    </form>
                                    <div class="text-center mt-3">
                                        <a class="small" href="index.php">Back to Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>

    <!-- Show SweetAlert based on result -->
    <?php if ($message == 'success'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Password Sent',
                text: 'The new password has been sent to your registered number.',
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>
    <?php elseif ($message == 'invalid'): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Username or Contact',
                text: 'The contact number or username is incorrect.',
            });
        </script>
    <?php endif; ?>
</body>

</html>
