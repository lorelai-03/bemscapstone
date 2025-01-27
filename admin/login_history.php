


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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login History - BEMS</title>
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
                <div class="container-fluid" style="overflow: auto; max-height: 80vh;">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_student"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch login/logout history
$sql = "SELECT lh.id, a.email, lh.login_time, lh.logout_time, lh.action
        FROM login_history lh
        JOIN admin a ON lh.admin_id = a.id
        ORDER BY lh.login_time DESC";
$result = $conn->query($sql);

$conn->close();
?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-primary"> <!-- This is where the class should be applied -->
            <tr>
                <th>Admin Email</th>
                <th>Login Time</th>
                <th>Logout Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['login_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['logout_time']) . "</td>";
                    echo "<td>" . ucfirst($row['action']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No history found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
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
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    // Initialize FullCalendar
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'fetch-events.php', // Load events from a PHP script

        // Event click handler to show overlay
        eventClick: function(info) {
            showEventDetailsOverlay(info.event);
        }
    });

    // Render the calendar
    calendar.render();

    // Ensure the overlay is hidden initially
    document.getElementById('eventDetailsOverlay').style.display = 'none';

    // Check if there are event details passed from PHP (for adding event manually)
    var eventType = document.getElementById('eventTypeData')?.value;
    var eventDate = document.getElementById('eventDateData')?.value;
    var eventTime = document.getElementById('eventTimeData')?.value;
    var eventMessage = document.getElementById('eventMessageData')?.value;

    if (eventType && eventDate && eventTime && eventMessage) {
        // Parse the date and time into a proper format
        var eventStartDateTime = `${eventDate}T${eventTime}`;

        // Add event to calendar dynamically
        calendar.addEvent({
            title: eventType,
            start: eventStartDateTime,
            description: eventMessage,
            allDay: false
        });

        // Focus the calendar on the newly added event
        calendar.gotoDate(eventStartDateTime);
    }
});

// Function to add a new event to the calendar via fetch
function addEventToCalendar() {
    var type = document.getElementById('eventType').value;
    var date = document.getElementById('eventDate').value;
    var time = document.getElementById('eventTime').value;
    var message = document.getElementById('eventMessage').value;

    fetch('add-event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'type=' + encodeURIComponent(type) +
              '&date=' + encodeURIComponent(date) +
              '&time=' + encodeURIComponent(time) +
              '&message=' + encodeURIComponent(message)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Event added successfully!');
            location.reload(); // Reload the page to reflect changes on the calendar
        } else {
            alert('Failed to add event!');
        }
    });

    return false; // Prevent form submission
}

// Function to show event details in an overlay/modal
function showEventDetailsOverlay(event) {
    const overlay = document.getElementById('eventDetailsOverlay');
    const overlayContent = document.getElementById('overlayContent');

    // Populate overlay content with event details
    overlayContent.innerHTML = `
        <button id="closeButton" onclick="closeOverlay()">✕</button>
        <h3>${event.title}</h3>
        <p><strong>Date:</strong> ${event.start.toISOString().slice(0, 10)}</p>
        <p><strong>Time:</strong> ${event.start.toISOString().slice(11, 16)}</p>
        <p><strong>Details:</strong> ${event.extendedProps.description || 'No additional details available.'}</p>
    `;

    // Show the overlay
    overlay.style.display = 'flex';
}

// Function to hide the overlay
function closeOverlay() {
    document.getElementById('eventDetailsOverlay').style.display = 'none';
}
</script>


    <script>
        // Handle form submission
        $('#announcementForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            $.ajax({
                url: 'save_announcement.php', // URL to your PHP script
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload(); // Reload the page after clicking OK
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while submitting the form.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
 
</script>

<script>
$(document).ready(function() {

    // Handle Edit Button Click
    $('.edit-btn').on('click', function() {
        var eventData = $(this).data();
        
        // Populate the form with event data
        $('#event_id').val(eventData.id);
        $('#type').val(eventData.type);
        $('#date').val(eventData.date);
        $('#time').val(eventData.time);
        $('#message').val(eventData.message);
        
        // Show the modal
        $('#eventModal').modal('show');
    });

    // Handle Delete Button Click
    $('.delete-btn').on('click', function() {
        var eventId = $(this).data('id');

        // Confirm before deleting
        Swal.fire({
            title: 'Are you sure?',
            text: "You will not be able to recover this event!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_event.php',  // PHP script to handle event deletion
                    type: 'POST',
                    data: { id: eventId },
                    success: function(response) {
                        var result = JSON.parse(response);

                        if (result.success) {
                            // Show success message
                            Swal.fire('Deleted!', result.message, 'success').then(() => {
                                location.reload();  // Reload the page after successful delete
                            });
                        } else {
                            Swal.fire('Error', result.message, 'error');
                        }
                    }
                });
            }
        });
    });

    // Submit the form using AJAX (for adding or editing an event)
    $('#eventForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'add_event.php',  // PHP script to handle event submission
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response);

                if (result.success) {
                    Swal.fire({
                        title: 'Success',
                        text: result.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();  // Reload the page after successful submit
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});

</script>

    <!-- SweetAlert2 CSS (only include this once) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</body>

</html>