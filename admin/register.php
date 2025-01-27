<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url('assets/img/logo/cnb.png'); max-width: 100%; width: 30px;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Admin Registration</h4>
                                    </div>
                                    <form action="registerf.php" method="POST">
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="email" name="email" placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="password" name="password" placeholder="Password" required>
                                        </div>
                                        <button class="btn btn-primary d-block btn-user w-100" type="submit">Register</button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="login.html" style="text-decoration: none;">Already have an account? Login here!</a>
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
</body>
</html>
