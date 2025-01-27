


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
    // Include the database connection
    include("connections.php");

    // Fetch the count of requested certificates
    $query_count = "SELECT COUNT(*) AS Events_count FROM tbl_info";
    $result = mysqli_query($connections, $query_count);
    $row = mysqli_fetch_assoc($result);
    $Events_count = $row['Events_count'];

    // Fetch the count of requested certificates
    $query_count = "SELECT COUNT(*) AS reqCert_count FROM tbl_cert";
    $result = mysqli_query($connections, $query_count);
    $row = mysqli_fetch_assoc($result);
    $reqCert_count = $row['reqCert_count'];
    ?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - BEMS</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.ico">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <!-- SweetAlert2 JS (only include this once) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
           <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <style>
    /* Overlay styling */
#eventDetailsOverlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 9999; /* Ensures it appears above other elements */
}

/* Content inside the overlay */
#overlayContent {
    background: white;
    margin: 10% auto;
    padding: 20px;
    width: 50%;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
}

/* Close button styling */
#eventDetailsOverlay button {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #ff5f5f;
    border: none;
    color: white;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 4px;
}

#eventDetailsOverlay button:hover {
    background-color: #ff3b3b;
}

    
    h6 {
    text-align: center;   /* Center the text horizontally */
    padding-top: 30px;        /* Adjust the padding as needed */
    font-size: 30px;   /* Adjust font size if necessary */
    font-weight: bold;    /* Makes the text bold */
    margin: 0;            /* Remove default margins */
}
body, html {
    overflow: hidden;
    margin: 0;
    padding: 0;
    height: 100%;
}

    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>BEMS</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="brgy_req_cert.php"><i class="fas fa-clipboard"></i><span>Requested Certificates</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="received_cert.php"><i class="fas fa-clipboard"></i><span>Received Certificates</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php"><i class="fas fa-table"></i><span>Barangay Events</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>


                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Welcome, <?php echo htmlspecialchars($resident_username); ?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                                <div class="container-fluid" style="overflow: auto; max-height: 100vh;">
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Requested Certificates</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $reqCert_count; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Total Events</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $Events_count; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="container-fluid" style="overflow: auto; max-height: 80vh;">

    <!-- Search Filter -->
    <div class="mt-3">
        <input type="text" id="searchFilter" class="form-control" placeholder="Search Barangay Events" onkeyup="filterTable()">
    </div>

<?php

$servername = "localhost";
$username = "root";
$password = "";  // Replace with your MySQL password
$dbname = "db_student";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events from tbl_info
$sql = "SELECT * FROM tbl_info";
$result = $conn->query($sql);

$conn->close();
?>

<div class="table-responsive mt-3">
    <table class="table table-striped table-bordered mt-3" id="officialsTable">
        <thead class="table-primary">
            <tr>
                <th>Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if any event data was returned
            if ($result->num_rows > 0) {
                while($event = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($event['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($event['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($event['time']) . "</td>";
                    echo "<td>" . htmlspecialchars($event['message']) . "</td>";
                    echo "<td class='text-center'>
                        <button class='btn btn-sm btn-info view-btn' data-id='" . $event['id'] . "' 
                                data-type='" . htmlspecialchars($event['type']) . "' 
                                data-date='" . htmlspecialchars($event['date']) . "' 
                                data-time='" . htmlspecialchars($event['time']) . "' 
                                data-message='" . htmlspecialchars($event['message']) . "' 
                                data-image='" . htmlspecialchars($event['image']) . "'>View</button>
                    </td>"; 
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

  </div>

  <!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Type:</strong> <span id="viewType"></span></p>
                <p><strong>Date:</strong> <span id="viewDate"></span></p>
                <p><strong>Time:</strong> <span id="viewTime"></span></p>
                <p><strong>Description:</strong> <span id="viewMessage"></span></p>
                <p><strong>Image:</strong></p>
                <img id="viewImage" src="" alt="Event Image" class="img-fluid d-block mx-auto" style="max-width: 100%; height: auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © BEMs 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="script.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>

<script>
    // Function to filter the table based on the search input
    function filterTable() {
        var filter = document.getElementById("searchFilter").value.toUpperCase();
        var table = document.getElementById("officialsTable");
        var tr = table.getElementsByTagName("tr");

        // Loop through the table rows and hide those that don't match the filter
        for (var i = 1; i < tr.length; i++) {
            var td = tr[i].getElementsByTagName("td");
            var match = false;

            // Check if any column contains the filter text
            for (var j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                }
            }

            // Show or hide the row based on the match
            if (match) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>


<script type="text/javascript">
    $(document).ready(function() {
        // Handle View button click
        $(document).on('click', '.view-btn', function() {
            // Get data from the button's data attributes
            var id = $(this).data('id');
            var type = $(this).data('type');
            var date = $(this).data('date');
            var time = $(this).data('time');
            var message = $(this).data('message');
            var image = $(this).data('image'); // Assuming image URL or path

            // Set values in the modal
            $('#viewType').text(type);
            $('#viewDate').text(date);
            $('#viewTime').text(time);
            $('#viewMessage').text(message);

            // Set image in the modal
            if (image) {
                $('#viewImage').attr('src', image); // Assuming image URL or path is valid
            } else {
                $('#viewImage').attr('src', 'path/to/default/image.jpg'); // Placeholder if no image
            }

            // Show the modal
            $('#viewModal').modal('show');
        });
    });
</script>
    <!-- SweetAlert2 CSS (only include this once) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</body>

</html>