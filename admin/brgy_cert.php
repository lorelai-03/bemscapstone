


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
    <title>Certificates - BEMS</title>
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


<?php
// Database connection (replace with your actual connection code)
require_once('db_connection.php');

// Query to count the number of requests
$query = "SELECT COUNT(*) AS request_count FROM tbl_cert WHERE status = 'pending'"; // Assuming 'pending' indicates a new request
$result = $conn->query($query);
$row = $result->fetch_assoc();
$requestCount = $row['request_count'];

// Query to get the request data
$query = "SELECT id, rname, ctype, purpose, daterequest FROM tbl_cert WHERE status = 'pending'";
$result = $conn->query($query);
$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

// Reset the count to 0 after fetching the dropdown (if required)
if ($requestCount > 0) {
    // Update status to 'viewed' or another status if needed
    $updateQuery = "UPDATE tbl_cert SET status = 'viewed' WHERE status = 'pending'";
    $conn->query($updateQuery);
}

$conn->close();
?>

<li class="nav-item dropdown no-arrow mx-1">
    <div class="nav-item dropdown no-arrow">
        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
            <!-- Display dynamic request count -->
            <span class="badge bg-danger badge-counter"><?php echo $requestCount > 0 ? $requestCount : '0'; ?></span>
            <i class="fas fa-bell fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
            <h6 class="dropdown-header">Alerts Center</h6>
            <?php if ($requestCount > 0): ?>
                <!-- Loop through the requests and display them -->
                <?php foreach ($requests as $request): ?>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="me-3">
                            <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                        </div>
                        <div>
                            <span class="small text-gray-500"><?php echo $request['daterequest']; ?></span>
                            <p><?php echo $request['rname']; ?> requested a <?php echo $request['ctype']; ?> <?php echo $request['purpose']; ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="dropdown-item text-center text-gray-500">No new requests</p>
            <?php endif; ?>
            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        </div>
    </div>
</li>

                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Welcome, <?php echo htmlspecialchars($adminEmail); ?></span><img class="border rounded-circle img-profile" src="https://www.w3schools.com/howto/img_avatar.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="login_history.php"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Login History</a><a class="dropdown-item" href="sms_logs.php"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;SMS Logs</a><div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
        <!-- Button for Request Certificate -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" id="sendCertificatebtn">Send Updates Via SMS</button>
        </div>

<!-- Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="certificateModalLabel">Request Certificate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Dropdown for selecting name -->
        <div class="mb-3">
            <label for="nameSelect" class="form-label">Select Name</label>
            <select class="form-select" id="nameSelect">
                <option selected>Select Name</option>
                <!-- Options will be populated by JavaScript -->
            </select>
        </div>

        <div class="mb-3">
            <label for="certificateName" class="form-label">Contact</label>
            <input type="number" class="form-control" id="contact" name="contact" placeholder="" readonly>
        </div>

        <!-- Text input for certificate name -->
        <div class="mb-3">
            <label for="certificateName" class="form-label">Certificate Name</label>
            <input type="text" class="form-control" id="certificateName" name="certificateName" placeholder="Enter Certificate Name">
        </div>

          <!-- Request Message -->
        <div class="mb-3">
          <label for="requestMessage" class="form-label">Request Message</label>
          <textarea class="form-control" id="requestMessage" name="requestMessage" rows="4" placeholder="Enter your message here"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitCertificate">Submit</button>
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
        <!-- Filter Input -->
        <div class="mt-3">
            <input type="text" id="filterInput" class="form-control" placeholder="Filter search...">
        </div>
        <div class="tab-content" id="myTabContent" style="max-height: 300px; overflow-y: auto;">
            <!-- Pending Tab Content -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">

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

// Fetch data from tbl_cert excluding records with ctype = "account approval"
$sql = "SELECT `id`, `rname`, `ctype`, `purpose`, `status`, `daterequest` FROM `tbl_cert` WHERE `ctype` != 'account approval.'";
$result = $conn->query($sql);
?>


<div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
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
            // Check if there are records in the result set
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    // Extract row data
                    $id = $row['id'];  // Get the ID of the current row
                    $name = htmlspecialchars($row['rname']);
                    $type = htmlspecialchars($row['ctype']);
                    $purpose = htmlspecialchars($row['purpose']);
                    $status = htmlspecialchars($row['status']);
                    $dateRequested = htmlspecialchars($row['daterequest']);

                    // Determine display status and apply styling
$displayStatus = ($status === 'Declined' || $status === 'viewed') ? 'Pending' : $status;
$statusBadge = ($displayStatus === 'Pending') ? 'bg-warning' : 
                ($status === 'Accepted' ? 'bg-success' : '');

                    // Only display the row if status is not "Accepted"
                    if ($status === 'Accepted') {
                        continue; // Skip rows with "Accepted" status
                    }

                    echo "<tr>
                            <td>$name</td>
                            <td>$type</td>
                            <td>$dateRequested</td>
                            <td>$purpose</td>
                            <td class='text-center'>
                                <span class='badge $statusBadge'>$displayStatus</span>
                            </td>
                            <td class='text-center'>
                                 <button class='btn btn-sm btn-success accept-btn' data-id='$id'>Accept</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
            }
            ?>
    </tbody>
</table>

                </div>
            </div>

            <!-- Approved Tab Content -->
            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">

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

// Fetch data from tbl_cert where status is Accepted
$sql = "SELECT `id`, `rname`, `ctype`, `purpose`, `status`, `dateapprove` FROM `tbl_cert` WHERE `status` = 'Accepted'";
$result = $conn->query($sql);
?>

<div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
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
            // Check if there are records in the result set
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    // Extract row data
                    $id = $row['id'];
                    $name = htmlspecialchars($row['rname']);
                    $type = htmlspecialchars($row['ctype']);
                    $purpose = htmlspecialchars($row['purpose']);
                    $status = htmlspecialchars($row['status']);
                    $dateApproved = htmlspecialchars($row['dateapprove']);

                    // Display "Approved" only if the status is "Accepted"
                     $displayStatus = ($status === 'Accepted') ? 'Approved (For Pick-Up)' : '';

                    // Only display the row if status is "Accepted"
                    if ($status !== 'Accepted') {
                        continue; // Skip rows not marked as "Accepted"
                    }

                    // Add row ID for deletion reference
                    echo "<tr id='row$id'>
                            <td>$name</td>
                            <td>$type</td>
                            <td>$dateApproved</td>
                            <td>$purpose</td>
                            <td class='text-center'><span class='badge bg-success'>$displayStatus</span></td>
                            <td class='text-center'>
                                 <button class='btn btn-sm btn-danger delete-btn' data-id='$id'>Delete</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No approved records found</td></tr>";
            }
            ?>
    </tbody>
</table>

                </div>
            </div>
        </div>

    </div>


<!-- HTML for the overlay -->
<div id="eventDetailsOverlay">
    <div id="overlayContent">
        <!-- Event details will be populated here -->
    </div>
    <button onclick="closeOverlay()">Close</button>
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
        // Filter search functionality
        document.getElementById('filterInput').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            const activeTab = document.querySelector('.tab-pane.active');
            const table = activeTab.querySelector('table tbody');

            Array.from(table.getElementsByTagName('tr')).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });


    </script>

<script>
$(document).ready(function() {
    // Click event for the Accept button
    $('.accept-btn').on('click', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');

        // Confirm the action using SweetAlert
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to accept this request?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, accept it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update status
                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response === 'success') {
                            // Success message
                            Swal.fire(
                                'Accepted!',
                                'The request has been accepted.',
                                'success'
                            ).then(() => {
                                // Reload the page after clicking OK
                                location.reload();
                            });
                        } else {
                            // Error message
                            Swal.fire(
                                'Failed!',
                                'Failed to update status. Please try again.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        // Network or server error
                        Swal.fire(
                            'Error!',
                            'An error occurred while updating status.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

<script>
    // Attach event listener to delete buttons
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id'); // Get the record ID

            // SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send the request to delete the record using AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'delete_record.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = xhr.responseText;
                            if (response === 'success') {
                                // Get the row element by ID and check if it exists
                                var row = document.getElementById('row' + id);
                                if (row) {
                                    // Remove the row from the table if it exists
                                    row.remove();

                                    // Show success alert after deletion
                                    Swal.fire(
                                        'Deleted!',
                                        'Your record has been deleted.',
                                        'success'
                                    );
                                }
                            } else {
                                // Show error alert if deletion failed
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the record.',
                                    'error'
                                );
                            }
                        }
                    };
                    xhr.send('id=' + id); // Send the id to the server
                }
            });
        });
    });
</script>

<script>
// JavaScript to handle button click and fetch data
document.getElementById('sendCertificatebtn').addEventListener('click', function() {
    // Show modal
    var myModal = new bootstrap.Modal(document.getElementById('certificateModal'));
    myModal.show();

    // Fetch names from tbl_resi and populate dropdown
    fetchNames();
});

</script>

    <!-- SweetAlert2 CSS (only include this once) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script>
  let selectedContact = null;

  // Fetch names from the server and populate the dropdown
  function fetchNames() {
    fetch('fetch_names.php')  // Your PHP script to fetch names
      .then(response => response.json())
      .then(data => {
        const nameSelect = document.getElementById('nameSelect');
        nameSelect.innerHTML = '<option selected>Select Name</option>'; // Reset options
        data.forEach(item => {
          const option = document.createElement('option');
          option.value = item.full_name;  // Using full name from the response
          option.dataset.contact = item.contact; // Store contact in data attribute
          option.textContent = item.full_name;  // Display the full name
          nameSelect.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching names:', error));
  }

  // Fetch the selected contact based on name selection
  document.getElementById('nameSelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    selectedContact = selectedOption ? selectedOption.dataset.contact : null;
    document.getElementById('contact').value = selectedContact;  // Set the contact value
  });

  // Submit form and send SMS
  document.getElementById('submitCertificate').addEventListener('click', function () {
    const name = document.getElementById('nameSelect').value;
    const certificateName = document.getElementById('certificateName').value;
    const requestMessage = document.getElementById('requestMessage').value;

    // Validation for empty fields
    if (name === 'Select Name') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Please select a name.',
      });
      return;
    }

    if (!certificateName || !requestMessage) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Please fill out all fields.',
      });
      return;
    }

    if (!selectedContact) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Please select a valid name with contact.',
      });
      return;
    }

    // Show loading state with SweetAlert
    Swal.fire({
      title: 'Submitting...',
      text: 'Please wait while we process your request.',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Send data via AJAX to the server
    fetch('send_certificate_request.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        name: name,
        certificateName: certificateName,
        requestMessage: requestMessage,
        contact: selectedContact,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message,
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: data.message,
          });
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'An error occurred while sending the request.',
        });
      });
  });

  // Call fetchNames to populate the dropdown when the page loads
  document.addEventListener('DOMContentLoaded', function () {
    fetchNames();
  });
</script>


</body>

</html>