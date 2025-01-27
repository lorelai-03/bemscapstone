


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


    ?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Request Certificates - BEMS</title>
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



                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Welcome, <?php echo htmlspecialchars($resident_username); ?></span><img class="border rounded-circle img-profile" src="https://www.w3schools.com/howto/img_avatar.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="sms_logs.php"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;SMS Logs</a><div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Modal for adding residents -->
<div class="modal fade" id="requestCertificateModal" tabindex="-1" aria-labelledby="requestCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestCertificateModalLabel">Request Certificate Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCertificateForm">
                    <div class="mb-3">
                        <label for="rname" class="form-label">Resident Name</label>
                        <input type="text" class="form-control" id="rname" name="rname" required>
                    </div>
                    <div class="mb-3">
                        <label for="ctype" class="form-label">Certificate Type</label>
                        <select class="form-select" id="ctype" name="ctype" required>
                            <option value="">Select Certificate Type</option>
                            <option value="Barangay Certificate of Residency">Barangay Certificate of Residency</option>
                            <option value="Barangay Clearance">Barangay Clearance</option>
                            <option value="Barangay Indigency">Barangay Indigency</option>
                            <option value="Barangay Permit">Barangay Permit</option>
                            <option value="Barangay Certificate of Service">Barangay Certificate of Service</option>
                            <option value="Barangay Identification">Barangay Identification</option>
                            <option value="Barangay Calamity Certification">Barangay Calamity Certification</option>
                            <option value="Barangay Certificate of Incubency">Barangay Certificate of Incubency</option>
                            <option value="Barangay Certificate of Eligibility">Barangay Certificate of Eligibility</option>
                            <option value="Barangay Certificate of Legalization">Barangay Certificate of Legalization</option>
                            <option value="Barangay Certificate of Tree Planting">Barangay Certificate of Tree Planting</option>
                            <option value="Barangay Certificate of Land Ownership">Barangay Certificate of Land Ownership</option>
                            <option value="Barangay First Job Seekers Letter">Barangay First Job Seekers Letter</option>
                            <option value="Barangay Pig Permit">Barangay Pig Permit</option>
                            <option value="Barangay Solo Parents">Barangay Solo Parents</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="purpose" class="form-label">Purpose</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Request</button>
                </form>
            </div>
        </div>
    </div>
</div>
                <div class="container-fluid" style="overflow: auto; max-height: 80vh;">
<!-- Button for Request Certificate -->
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" id="requestCertificateBtn">Request Certificate</button>
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
<!-- Filter Input -->
<div class="mt-3">
    <input type="text" id="filterInput" class="form-control" placeholder="Filter search...">
</div>
<div class="tab-content" id="myTabContent" style="max-height: 300px; overflow-y: auto;">

    <!-- Pending Tab Content -->
    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered" id="pendingTable">
                <thead class="table-primary">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Date Requested</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db_student");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['resident_id'])) {
    // Redirect if not logged in
    header('Location: login.php');
    exit();
}

$resident_id = $_SESSION['resident_id'];

// Fetch pending certificates for logged-in user
$sqlPending = "SELECT `id`, `rname`, `ctype`, `daterequest`, `Purpose`, `status` 
               FROM `tbl_cert` 
               WHERE `resident_id` = ? AND `status` != 'Accepted'";

if ($stmt = $conn->prepare($sqlPending)) {
    // Bind resident_id
    $stmt->bind_param('i', $resident_id);
    
    // Execute query
    $stmt->execute();
    
    // Get result
    $resultPending = $stmt->get_result();

    if ($resultPending->num_rows > 0) {
        while ($row = $resultPending->fetch_assoc()) {
            $id = $row['id'];
            $name = htmlspecialchars($row['rname']);
            $type = htmlspecialchars($row['ctype']);
            $dateRequested = htmlspecialchars($row['daterequest']);
            $purpose = htmlspecialchars($row['Purpose']);
            $status = htmlspecialchars($row['status']);

            $displayStatus = ($status === 'Declined') ? 'Pending' : $status;
            $statusBadge = ($displayStatus === 'Pending') ? 'bg-warning' : '';

            echo "<tr>
                    <td>$name</td>
                    <td>$type</td>
                    <td>$dateRequested</td>
                    <td>$purpose</td>
                    <td class='text-center'><span class='badge $statusBadge'>$displayStatus</span></td>
                    <td class='text-center'>
                        <button class='btn btn-sm btn-primary edit-btn' data-id='$id' 
                                data-name='$name' data-type='$type' data-purpose='$purpose'>Edit</button>
                        <button class='btn btn-sm btn-danger delete-btn' data-id='$id'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No pending records found</td></tr>";
    }

    $stmt->close();
}
?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Approved Tab Content -->
    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered" id="approvedTable">
                <thead class="table-primary">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Date Approved</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
<?php
// Fetch approved certificates for logged-in user
$sqlApproved = "SELECT `id`, `rname`, `ctype`, `dateapprove`, `purpose`, `status` 
                FROM `tbl_cert` 
                WHERE `resident_id` = ? AND `status` = 'Accepted'";

if ($stmt = $conn->prepare($sqlApproved)) {
    // Bind resident_id
    $stmt->bind_param('i', $resident_id);
    
    // Execute query
    $stmt->execute();
    
    // Get result
    $resultApproved = $stmt->get_result();

    if ($resultApproved->num_rows > 0) {
        while ($row = $resultApproved->fetch_assoc()) {
            $id = $row['id'];
            $name = htmlspecialchars($row['rname']);
            $type = htmlspecialchars($row['ctype']);
            $dateApproved = htmlspecialchars($row['dateapprove']);
            $purpose = htmlspecialchars($row['purpose']);
            $status = htmlspecialchars($row['status']);

            $statusBadge = "<span class='badge bg-success'>Approved (For Pick-Up)</span>";

            echo "<tr id='row$id'>
                    <td>$name</td>
                    <td>$type</td>
                    <td>$dateApproved</td>
                    <td>$purpose</td>
                    <td class='text-center'>$statusBadge</td>
                    <td class='text-center'>
                        <button class='btn btn-sm btn-danger delete-btn' data-id='$id'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No approved records found</td></tr>";
    }

    $stmt->close();
}
?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Certificate Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId" name="id">

                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="rname" required>
                    </div>

                    <!-- Certificate Type Dropdown -->
                    <div class="mb-3">
                        <label for="editType" class="form-label">Certificate Type</label>
                        <select class="form-select" id="editType" name="ctype" required>
                            <option value="">Select Certificate Type</option>
                            <option value="Barangay Certificate of Residency">Barangay Certificate of Residency</option>
                            <option value="Barangay Clearance">Barangay Clearance</option>
                            <option value="Barangay Indigency">Barangay Indigency</option>
                            <option value="Business Permit">Business Permit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editPurpose" class="form-label">Purpose</label>
                        <input type="text" class="form-control" id="editPurpose" name="Purpose" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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

<script>
    $(document).ready(function() {
        // **Filter Search Functionality**
        document.getElementById('filterInput').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            const activeTab = document.querySelector('.tab-pane.active'); // Get the active tab content
            const table = activeTab.querySelector('table tbody'); // Get the table body within the active tab

            Array.from(table.getElementsByTagName('tr')).forEach(row => {
                const text = row.textContent.toLowerCase();
                // Show or hide row based on filter match
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // **Request Certificate Button Click Event**
        document.getElementById('requestCertificateBtn').addEventListener('click', function () {
            $('#requestCertificateModal').modal('show'); // Show the modal
        });

        // **Handle Form Submission**
$('#addCertificateForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Gather form data using FormData for flexible data handling
    const formData = new FormData(this);

    // AJAX request to save the certificate request
    $.ajax({
        url: 'add_request_certificate.php', // PHP script to handle form data
        type: 'POST',
        data: formData,
        processData: false, // Do not process data for FormData
        contentType: false, // Set content type to false for FormData
        success: function(response) {
            if (response.trim() === 'success') {
                // Show SweetAlert for success
                Swal.fire({
                    icon: 'success',
                    title: 'Request Successful!',
                    text: 'The certificate has been successfully requested.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#requestCertificateModal').modal('hide'); // Hide the modal
                    location.reload(); // Reload the page to update data
                });
            } else if (response.trim() === 'sms_error') {
                // Show SweetAlert for SMS failure
                Swal.fire({
                    icon: 'error',
                    title: 'SMS Failed!',
                    text: 'There was an issue sending the SMS notification.',
                    confirmButtonText: 'Try Again'
                });
            } else if (response.trim() === 'db_error') {
                // Show SweetAlert for DB failure
                Swal.fire({
                    icon: 'error',
                    title: 'Request Failed!',
                    text: 'There was an issue processing your request. Please try again.',
                    confirmButtonText: 'Try Again'
                });
            }
        },
        error: function() {
            // Handle any AJAX request errors
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An error occurred while sending your request. Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });
});

    });
</script>



<script type="text/javascript">
$(document).ready(function() {
    // Handle Edit button click
    $(document).on('click', '.edit-btn', function() {
        // Get data from the button's data attributes
        var id = $(this).data('id');
        var name = $(this).data('name');
        var type = $(this).data('type');
        var purpose = $(this).data('purpose');

        // Set values in the modal form
        $('#editId').val(id);
        $('#editName').val(name);
        $('#editPurpose').val(purpose);

        // Set the selected value for the certificate type dropdown
        $('#editType').val(type); // This will match the option based on the type

        // Show the modal
        $('#editModal').modal('show');
    });

    // Handle form submission
    $('#editForm').on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting normally

        // Get form data
        var formData = $(this).serialize(); // Serialize the form data

        // Send an AJAX request to update the data
        $.ajax({
            type: 'POST',
            url: 'update_certificate.php', // The PHP endpoint
            data: formData,
            dataType: 'json', // Expecting JSON response
            success: function(response) {
                console.log("Response: ", response); // Log the response for debugging

                if (response.success) {
                    // Show SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message, // Show the success message returned from PHP
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Only reload the page if the user clicked 'OK' on the Swal
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page after confirmation
                        }
                    });
                } else {
                    // Show SweetAlert for error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message, // Show the error message returned from PHP
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors (network issues, etc.)
                console.error("AJAX Error: " + status + ": " + error); // Log the error for debugging
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while processing your request.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    // Handle Edit button click
    $(document).on('click', '.edit-btn', function() {
        // Get data from the button's data attributes
        var id = $(this).data('id');
        var name = $(this).data('name');
        var type = $(this).data('type');
        var purpose = $(this).data('purpose');

        // Set values in the modal form
        $('#editId').val(id);
        $('#editName').val(name);
        $('#editPurpose').val(purpose);

        // Set the selected value for the certificate type dropdown
        $('#editType').val(type); // This will match the option based on the type

        // Show the modal
        $('#editModal').modal('show');
    });

    // Handle Delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');

        // Ask for confirmation before deleting
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'This will permanently delete the record!',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete the certificate
                $.ajax({
                    type: 'POST',
                    url: 'delete_certificate.php', // PHP file for deletion
                    data: { id: id },
                    dataType: 'json', // Expecting JSON response
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the table or remove the row
                                    location.reload(); // Reload the page
                                }
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors (network issues, etc.)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while processing your request.',
                            confirmButtonText: 'OK'
                        });
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