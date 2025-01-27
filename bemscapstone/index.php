<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="shortcut icon" href="assets/images/cnb.png">
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 JS (only include this once) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


    
      


    <link rel="stylesheet" href="css/line-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Home - BEMS</title>
       <link rel="icon" type="image/x-icon" href="img/favicon.ico">
</head>


<body data-bs-spy="scroll" data-bs-target=".navbar">

    <!--navbar-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white" data-aos="fade-down">
        <div class="container">
            <a href="index.php" class="logo text-center logo-light">
                <span class="logo-lg">
                     <img src="/BEMs/assets/images/nem.png" alt="" height="60px">
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="#home">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#services">Services</a>
    </li>
    
    
	<li class="nav-item">
                        <a class="nav-link" href="#blog">Register</a>
                    </li>
	
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#login" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Login
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	<li><a class="dropdown-item" href="admin/index.php">Admin</a></li>
        <li><a class="dropdown-item" href="residents/index.php">Resident</a></li>
        <li><a class="dropdown-item" href="officials/index.php">Brgy Officials</a></li>
        
        <li><a class="dropdown-item" href="admin/index.php">Brgy Secretary</a></li>
        
    </ul>
</li>

   
                </ul>
            </div>
        </div>
    </nav>

    <!--hero-->
    <section id="home" class="bg-cover hero-section" style="background-image: url(img/kk.jpg);">
        <div class="overlay"></div>
        <div class="container text-white text-center">
            <div class="row">
                <div class="col-12">
				
				<style>
				h1 {
					color:white;
				}
				</style>
                    <h1 class="display-4" data-aos="zoom-in">BARANGAY CORAL NI BACAL<br>
                        EVENT MANAGEMENT SYSTEM</h1>
                    
            </div>
        </div>
    </section>

   <!-- START SERVICES -->
<section class="py-5" id="services">
    <div class="container">
        <div class="row py-4">
            <div class="col-lg-12">
                <div class="text-center">
				<style>
				h3{
				padding-top:90px;
				}
				
				.icon-container {
    margin-bottom: 15px;
}

.icon-circle {
    display: inline-block;
    width: 60px;
    height: 60px;
    background-color: white; /* Light background */
    border-radius: 50%;
    line-height: 60px; /* Center the icon vertically */
    text-align: center; /* Center the icon horizontally */
}


				</style>
				
                    <h3>We offer you these services.</h3>
                </div>
            </div>
        </div>
	 <div class="text-center p-2 p-sm-3" id="dashboardDiv">
        <div class="row">
            <div class="col-lg-4 col-md-6">
    <div class="text-center p-2 p-sm-3">
	
	

        <!-- Icon in a rounded circle -->
        <div class="icon-container" onclick="showWarning()">
            <span class="icon-circle">
			<img src="https://img.icons8.com/?size=100&id=ucctWFiiXcr1&format=png&color=000000">
                <i class="uil uil-chart-pie text-primary font-24"></i>
            </span>
        </div>
        <h4 class="mt-3" onclick="showWarning()">Dashboard</h4>
        <p class="text-muted mt-2 mb-0" onclick="showWarning()">
            A dashboard is a visual display of all of your data. Its primary intention is to provide information at-a-glance, such as KPIs.
        </p>
    </div>
</div>
<script>
function showWarning() {
    alert("Please register to use this service");
}
</script>





            <!-- Request Certificates -->
            <div class="col-lg-4 col-md-6" onclick="showWarning()">
                <div class="text-center p-2 p-sm-3">
                    <!-- Icon in a rounded circle -->
                    <div class="avatar-sm m-auto">
                        <span class="icon-circle">
			<img src="https://img.icons8.com/?size=100&id=42844&format=png&color=000000">
                <i class="uil uil-chart-pie text-primary font-24"></i>
            </span>
						
                            <i class="uil uil-file-plus-alt text-primary font-24"></i>
                        </span>
                    </div>
                    <h4 class="mt-3" onclick="showWarning()">Profiling</h4>
                    <p class="text-muted mt-2 mb-0" onclick="showWarning()">
                        Enables you to request a type of certificate.
                    </p>
                </div>
            </div>

            <!-- Events -->
            <div class="col-lg-4 col-md-6" onclick="showWarning()">
                <div class="text-center p-2 p-sm-3">
                    <!-- Icon in a rounded circle -->
                    <span class="icon-circle">
			<img src="https://img.icons8.com/?size=100&id=HmClKvnYtDm9&format=png&color=000000">
                <i class="uil uil-chart-pie text-primary font-24"></i>
            </span>
                    <h4 class="mt-3">Events</h4>
                    <p class="text-muted mt-2 mb-0">
                        A written record of events.
                    </p>
                </div>
            </div>
			
            <!-- Profile -->
            <div class="col-lg-4 col-md-6" onclick="showWarning()">
                <div class="text-center p-2 p-sm-3">
                    <!-- Icon in a rounded circle -->
                    <span class="icon-circle">
			<img src="https://img.icons8.com/?size=100&id=txmnrJwlctOz&format=png&color=000000">
                <i class="uil uil-chart-pie text-primary font-24"></i>
            </span>
                   
                    <h4 class="mt-3">Profile</h4>
                    <p class="text-muted mt-2 mb-0">
                        You can manage your account.
                    </p>
                </div>
            </div>

          
    <!-- END SERVICES -->
   </div>
</div>

<!-- Blog Section with Centered Card Form -->
<section id="blog" class="bg-light py-5">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card shadow-lg rounded-lg" style="width: 100%; max-width: 600px;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4" style="font-family: 'Arial', sans-serif; color: #333;">User Registration Form</h3>
                <form id="registrationForm" enctype="multipart/form-data">
                    <!-- First Name -->
                    <div class="form-group mb-3">
                        <label for="firstn" class="font-weight-bold">First Name</label>
                        <input type="text" class="form-control" id="firstn" name="firstn" required style="color: black; border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Last Name -->
                    <div class="form-group mb-3">
                        <label for="lastn" class="font-weight-bold">Last Name</label>
                        <input type="text" class="form-control" id="lastn" name="lastn" required style="color: black; border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Middle Initial -->
                    <div class="form-group mb-3">
                        <label for="middlei" class="font-weight-bold">Middle Initial</label>
                        <input type="text" class="form-control" id="middlei" name="middlei" style="color: black; border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Gender -->
                    <div class="form-group mb-3">
                        <label for="gender" class="font-weight-bold">Gender</label>
                        <select class="form-control" id="gender" name="gender" required style="color: black; border-radius: 8px; border: 2px solid black;">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <!-- Contact Number -->
                    <div class="form-group mb-3">
                        <label for="contact" class="font-weight-bold">Contact Number</label>
                        <input type="number" class="form-control" id="contact" name="contact" required style="color: black; border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Purok Dropdown -->
                    <div class="form-group mb-3">
                        <label for="purok" class="font-weight-bold">Purok</label>
                        <select class="form-control" id="purok" name="purok" style="color: black; border-radius: 8px; border: 2px solid black;">
                            <option value="">Select Purok</option>
                            <option value="Purok 1">Purok 1</option>
                            <option value="Purok 2">Purok 2</option>
                            <option value="Purok 3">Purok 3</option>
                            <option value="Purok 4">Purok 4</option>
                        </select>
                    </div>
                    <!-- Profile Image -->
                    <div class="form-group mb-3">
                        <label for="image" class="font-weight-bold">Profile Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" style="border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Username -->
                    <div class="form-group mb-3">
                        <label for="username" class="font-weight-bold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required style="color: black; border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required style="color: black; border-radius: 8px; border: 2px solid black;">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block py-2" style="border-radius: 8px; background-color: #007bff;">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>


<style>
    /* General styling */
    .card {
        background-color: #ffffff;
border-radius: 8px; border: 2px solid black;"
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .card-body {
        padding: 30px;
    }

    h3 {
        font-size: 24px;
        font-weight: 600;
    }

    .form-group label {
        font-weight: 500;
    }

    .form-control-file {
        border-radius: 8px;
    }

    .container {
        padding: 0 15px;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
    
   
<script>
$(document).ready(function () {
    $("#registrationForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitButton = $(this).find("button[type=submit]");

        // Disable the submit button to prevent double submission
        submitButton.prop("disabled", true);

        $.ajax({
            url: 'submit_form.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Ensure the response is treated as JSON
            success: function (response) {
                console.log("Response from server:", response);  // Log the response

                if (response.status === 'success') {
                    // Show a success message with Swal.fire
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Clear the form, reset URL, and reload the page
                        $("#registrationForm")[0].reset();
                        window.history.replaceState({}, document.title, window.location.pathname);
                        location.reload();
                    });
                } else {
                    // Show an error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during submission!',
                    confirmButtonText: 'OK'
                });
            },
            complete: function () {
                // Re-enable the submit button after the request is complete
                submitButton.prop("disabled", false);
            }
        });
    });
});

</script>

<!-- Add these in the <head> or before closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 CSS (only include this once) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/app.js"></script>
</body>

</html>