


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
    <title>Residents - BEMS</title>
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
                    <!-- Add Residents Button -->
<!-- Button aligned to the right -->
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" id="addResidentsBtn">Add Residents</button>
</div>

<!-- Modal for adding residents -->
<div class="modal fade" id="addResidentsModal" tabindex="-1" aria-labelledby="addResidentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResidentsModalLabel">Add Resident</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addResidentForm">
                    <div class="mb-3">
                        <label for="firstn" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstn" name="firstn" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastn" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastn" name="lastn" required>
                    </div>
                    <div class="mb-3">
                        <label for="middlei" class="form-label">Middle Initial</label>
                        <input type="text" class="form-control" id="middlei" name="middlei">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="purok" class="form-label">Purok</label>
                        <select class="form-control" id="purok" name="purok">
                            <option value="">Select Purok</option>
                            <option value="Purok 1">Purok 1</option>
                            <option value="Purok 2">Purok 2</option>
                            <option value="Purok 3">Purok 3</option>
                            <option value="Purok 4">Purok 4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="imagePath" class="form-label">ID Image</label>
                        <input type="file" class="form-control" id="imagePath" name="imagePath" accept="image/*" required>
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
                    <button type="submit" class="btn btn-primary">Save Resident</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Tab Navigation -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">Pending</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">Approved</button>
    </li>
</ul>

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

// Fetch data for Pending residents
$pendingSql = "SELECT * FROM tbl_resi WHERE approval_status = 'pending'";
$pendingResult = $conn->query($pendingSql);

// Check if the query was successful
if (!$pendingResult) {
    die("Error fetching pending residents: " . $conn->error);
}

// Fetch data for Approved residents
$approvedSql = "SELECT * FROM tbl_resi WHERE approval_status = 'approved'";
$approvedResult = $conn->query($approvedSql);

// Check if the query was successful
if (!$approvedResult) {
    die("Error fetching approved residents: " . $conn->error);
}
?>

<!-- Tab Pane -->
<div class="tab-content" id="myTabContent">
    <!-- Pending Residents Tab -->
    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
        <div class="table-responsive">
        <table class="table table-striped table-bordered mt-3" id="pendingTable">
            <thead class="table-primary">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Initial</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Purok</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($pendingResult->num_rows > 0) {
                    while ($row = $pendingResult->fetch_assoc()) {
                        // Conditional badge display for approval status
                        $approvalBadge = '';
                        if ($row['approval_status'] == 'pending') {
                            $approvalBadge = "<span class='badge bg-warning'>Pending</span>";
                        } elseif ($row['approval_status'] == 'approved') {
                            $approvalBadge = "<span class='badge bg-success'>Approved</span>";
                        }
                        echo "<tr>
                                <td>{$row['firstn']}</td>
                                <td>{$row['lastn']}</td>
                                <td>{$row['middlei']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['purok']}</td>
                                <td class='text-center'><a href='#' class='view-image' data-image='{$row['imagePath']}'><img src='{$row['imagePath']}' alt='Resident Image' class='img-thumbnail' style='width: 50px; height: 50px; border-radius: 50%'></td>
                                <td class='text-center'>{$approvalBadge}</td>
                                <td>
                            <button class='btn btn-sm btn-success approve-btn' data-id='{$row['id']}'>Approve</button>
                            <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['id']}'>Reject</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No pending records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Approved Residents Tab -->
    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
        <div class="table-responsive">
        <table class="table table-striped table-bordered mt-3" id="approvedTable">
            <thead class="table-primary">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Initial</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Purok</th>
                    <th>Image</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($approvedResult->num_rows > 0) {
                    while ($row = $approvedResult->fetch_assoc()) {
                        // Conditional badge display for approval status
                        $approvalBadge = '';
                        if ($row['approval_status'] == 'pending') {
                            $approvalBadge = "<span class='badge bg-warning'>Pending</span>";
                        } elseif ($row['approval_status'] == 'approved') {
                            $approvalBadge = "<span class='badge bg-success'>Approved</span>";
                        }
                        echo "<tr>
                                <td>{$row['firstn']}</td>
                                <td>{$row['lastn']}</td>
                                <td>{$row['middlei']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['purok']}</td>
                                <td class='text-center'><a href='#' class='view-image' data-image='{$row['imagePath']}'><img src='{$row['imagePath']}' alt='Resident Image' class='img-thumbnail' style='width: 50px; height: 50px; border-radius: 50%'></td>
                                <td class='text-center'>{$approvalBadge}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No approved records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$conn->close();
?>



<!-- Search Filter -->
<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search residents">
</div>

<!-- Modal Structure -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Identification Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Resident Image" class="img-fluid">
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

<script type="text/javascript">
    $(document).on('click', '.view-image', function (e) {
    e.preventDefault();
    const imagePath = $(this).data('image');
    $('#modalImage').attr('src', imagePath);
    $('#imageModal').modal('show');
});

</script>

<script>
$(document).ready(function() {
    // Show the modal when the "Add Residents" button is clicked
    $('#addResidentsBtn').on('click', function() {
        $('#addResidentsModal').modal('show');
    });

    // Handle the form submission
    $('#addResidentForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Gather form data
        var formData = new FormData(this);

        // Send the form data to the PHP handler
        $.ajax({
            url: 'add_resident.php', // PHP script to handle the form submission
            type: 'POST',
            data: formData,
            processData: false, // Required for file uploads
            contentType: false, // Required for file uploads
            success: function(response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Resident Added!',
                        text: 'The resident has been successfully added.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#addResidentsModal').modal('hide'); // Hide the modal
                        location.reload(); // Reload the page to reflect the changes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Failed to add the resident.',
                        confirmButtonText: 'Try Again'
                    });
                }
            }
        });
    });
});


// Add search filter functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    var searchValue = this.value.toLowerCase();
    
    // Filter pending residents
    filterTable('pendingTable', searchValue);
    
    // Filter approved residents
    filterTable('approvedTable', searchValue);
});

// Function to filter table based on search input
function filterTable(tableId, searchValue) {
    var table = document.getElementById(tableId);
    var rows = table.getElementsByTagName('tr');
    
    for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName('td');
        var rowText = '';
        
        // Concatenate all text content in the row cells
        for (var j = 0; j < cells.length; j++) {
            rowText += cells[j].textContent.toLowerCase();
        }
        
        // Check if the row matches the search value
        if (rowText.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}
</script>

<script>
    $(document).ready(function() {
        // Handle Approve button click
        $('.approve-btn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'approve_reject.php', // PHP script to handle approve
                type: 'POST',
                data: { id: id, action: 'approve' },
                success: function(response) {
                    if(response == 'success') {
                        $('#row-' + id).find('td:eq(7)').html("<span class='badge bg-success'>Approved</span>");
                        $('#row-' + id).find('.approve-btn').prop('disabled', true); // Disable the Approve button
                        $('#row-' + id).find('.delete-btn').prop('disabled', true);  // Disable the Delete button
                        
                        // SweetAlert for success
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: 'The resident has been approved successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();  // Reload the page after approval
                        });
                    } else {
                        // SweetAlert for failure
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Failed to approve the resident.',
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
            });
        });

        // Handle Delete button click (equivalent to Reject)
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'approve_reject.php', // PHP script to handle delete
                        type: 'POST',
                        data: { id: id, action: 'delete' },
                        success: function(response) {
                            if(response == 'success') {
                                // SweetAlert for success
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'The residents has been rejected successfully.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();  // Reload the page after deletion
                                });

                                // Remove the row from the table
                                $('#row-' + id).remove();
                            } else {
                                // SweetAlert for failure
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Failed to delete the record.',
                                    confirmButtonText: 'Try Again'
                                });
                            }
                        }
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