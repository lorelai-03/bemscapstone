<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Resident Login - BEMS</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.ico">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <!-- SweetAlert2 JS (only include this once) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- jQuery -->
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
                                        <h4 class="text-dark mb-4">Welcome Brgy. Resident!</h4>
                                    </div>
                                    <form id="loginForm" class="user">
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="text" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Username..." name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <a class="small" href="forgot_password.php">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary d-block btn-user w-100" type="submit">Login</button>
                                        
                                        <a class="btn btn-primary d-block btn-user w-100" href="../index.php" style="margin-top: 10px;">Back to Homepage</a>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="#" style="text-decoration: none; color: #fff">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="#" style="text-decoration: none; color: #fff">Create an Account!</a>
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

  <script>
    $(document).ready(function() {
        // Handle form submission via AJAX
        $('#loginForm').submit(function(e) {
            e.preventDefault();  // Prevent the default form submission

            var username = $('#exampleInputEmail').val();  // Using 'username' instead of 'email'
            var password = $('#exampleInputPassword').val();

            // Send AJAX request
            $.ajax({
                url: 'resident_login.php',  // The PHP file that will handle the login
                method: 'POST',
                data: {
                    username: username,  // Send 'username' instead of 'email'
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // If login is successful, show a success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: 'Welcome, ' + response.username,  // Use 'username' in response
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = 'dashboard.php';  // Redirect to the resident dashboard
                        });
                    } else {
                        // If login fails, show an error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'Please try again later.'
                    });
                }
            });
        });
    });
</script>


    <!-- SweetAlert2 CSS (only include this once) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</body>

</html>
