


<?php
session_start();

// Check if the admin is logged in by checking session variables
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_email'])) {
    // Admin is logged in, you can now use the session data
     $adminEmail = $_SESSION['admin_email']; 
} else {
    // Admin is not logged in, redirect to login page
    header("Location: index.php");  // Replace with your login page
    exit();
}
?>


 <?php
    // Include the database connection
    include("connections.php");

    // Fetch the count of requested certificates
    $query_count = "SELECT COUNT(*) AS certificate_count FROM tbl_cert";
    $result = mysqli_query($connections, $query_count);
    $row = mysqli_fetch_assoc($result);
    $certificate_count = $row['certificate_count'];

    // Fetch the count of requested certificates
    $query_count = "SELECT COUNT(*) AS Events_count FROM tbl_info";
    $result = mysqli_query($connections, $query_count);
    $row = mysqli_fetch_assoc($result);
    $Events_count = $row['Events_count'];

        // Fetch the count of requested certificates
    $query_count = "SELECT COUNT(*) AS residents_count FROM tbl_resi";
    $result = mysqli_query($connections, $query_count);
    $row = mysqli_fetch_assoc($result);
    $residents_count = $row['residents_count'];

            // Fetch the count of requested certificates
    $query_count = "SELECT COUNT(*) AS officials_count FROM tbl_off";
    $result = mysqli_query($connections, $query_count);
    $row = mysqli_fetch_assoc($result);
    $officials_count = $row['officials_count'];
    ?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Officials - BEMS</title>
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
                    <li class="nav-item"><a class="nav-link" href="brgy_cert.php"><i class="fas fa-clipboard"></i><span>Barangay Certificates</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="brgy_officials.php"><i class="fas fa-user"></i><span>Barangay Officials</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="brgy_residents.php"><i class="fas fa-users"></i><span>Barangay Residents</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php"><i class="fas fa-table"></i><span>Create Events</span></a></li>
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Welcome, <?php echo htmlspecialchars($adminEmail); ?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="login_history.php"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Login History</a><div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                       <!-- Add Barangay Officials Button -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOfficialModal">Add Barangay Official</button>

    <!-- Search Filter -->
    <div class="mt-3">
        <input type="text" id="searchFilter" class="form-control" placeholder="Search Barangay Officials" onkeyup="filterTable()">
    </div>

    <!-- Table of Barangay Officials -->
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

// Fetch data from tbl_offi
$sql = "SELECT id, name, middle, last, status, gender, position, image FROM tbl_off";

// Execute the query and check for errors
$result = $conn->query($sql);

// Check if query failed
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<table class="table table-striped table-bordered mt-3" id="officialsTable">
    <thead class="table-primary">
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th>Gender</th>
            <th>Position</th>
            <th>Image</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = htmlspecialchars($row['name']);
                $middle = htmlspecialchars($row['middle']);
                $last = htmlspecialchars($row['last']);
                $status = htmlspecialchars($row['status']);
                $gender = htmlspecialchars($row['gender']);
                $position = htmlspecialchars($row['position']);
                $image = htmlspecialchars($row['image']);

                $badgeClass = ($status == 'active') ? 'badge bg-success' : 'badge bg-danger';
                $statusLabel = ($status == 'active') ? 'Active' : 'Not Active';

                echo "<tr>
                        <td>$name</td>
                        <td>$middle</td>
                        <td>$last</td>
                        <td class='text-center'><span class='badge $badgeClass'>$statusLabel</span></td>
                        <td>$gender</td>
                        <td>$position</td>
                        <td class='text-center'><img src='$image' alt='Official Image' style='width: 50px; height: 50px; border-radius: 50%'></td>
                        <td class='text-center'>
                            <button class='btn btn-sm btn-primary editBtn' data-id='$id'>Edit</button>
                            <button class='btn btn-sm btn-danger deleteBtn' data-id='$id'>Delete</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>



<?php
$conn->close();
?>


</div>

<div class="modal fade" id="editOfficialModal" tabindex="-1" aria-labelledby="editOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOfficialModalLabel">Edit Barangay Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOfficialForm" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMiddle" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddle" name="middle">
                    </div>
                    <div class="mb-3">
                        <label for="editLast" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLast" name="last" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="active">Active</option>
                            <option value="not_active">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editGender" class="form-label">Gender</label>
                        <select class="form-select" id="editGender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editPosition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="editPosition" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Official</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addOfficialModal" tabindex="-1" aria-labelledby="addOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOfficialModalLabel">Add Barangay Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to add Barangay Official -->
                <form id="addOfficialForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="middle" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle" name="middle">
                    </div>
                    <div class="mb-3">
                        <label for="last" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last" name="last" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="not_active">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Official</button>
                </form>
            </div>
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

<!-- jQuery AJAX Script with SweetAlert -->
<script>
$(document).ready(function () {
    $('#addOfficialForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Validate password and confirm password
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Passwords do not match!',
                confirmButtonText: 'OK'
            });
            return; // Stop form submission
        }

        // Create FormData object
        const formData = new FormData(this);

        // AJAX request
        $.ajax({
            url: 'add_official.php', // PHP script to handle the form data
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response === 'success') {
                    // Show success alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: 'Barangay official has been added successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#addOfficialModal').modal('hide'); // Hide the modal
                        $('#addOfficialForm')[0].reset(); // Reset the form fields
                        location.reload(); // Reload the page to update the table
                    });
                } else {
                    // Show error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to add barangay official. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});

</script>

<script type="text/javascript">
    $(document).ready(function () {
    // Edit button click
    $('.editBtn').on('click', function () {
        var id = $(this).data('id');

        $.ajax({
            url: 'get_official.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                $('#editId').val(response.id);
                $('#editName').val(response.name);
                $('#editMiddle').val(response.middle);
                $('#editLast').val(response.last);
                $('#editStatus').val(response.status);
                $('#editGender').val(response.gender);
                $('#editPosition').val(response.position);
                $('#editOfficialModal').modal('show');
            }
        });
    });

    // Update Official
    $('#editOfficialForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'update_official.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire('Updated!', 'Official updated successfully.', 'success').then(() => location.reload());
            }
        });
    });

    // Delete button click
    $('.deleteBtn').on('click', function () {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('delete_official.php', { id: id }, function (response) {
                    Swal.fire('Deleted!', 'Official has been deleted.', 'success').then(() => location.reload());
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