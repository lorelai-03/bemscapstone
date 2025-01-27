
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
                <div class="container-fluid" style="overflow: auto; max-height: 60vh;">
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Total Residents</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $residents_count; ?></span></div>
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
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Total Certificates</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span><?php echo $certificate_count?></span></div>
                                                </div>
                                                <div class="col">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Brgy. Officials</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $officials_count?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

         
  <div id="calendar"></div>
  <br>

  <div class="announcement-form-wrapper">
  <div class="announcement-form-header">
    <h5>Announcement Form</h5>
  </div>
  <div class="announcement-form-body">
    <form id="announcementForm">
      <!-- Purok Select -->
      <div class="form-group">
        <label for="purok">Purok</label>
        <select id="purok" name="purok" class="form-control" >
          <option value="" disabled selected>Select Purok</option>
          <option value="Purok 1">Purok 1</option>
          <option value="Purok 2">Purok 2</option>
          <option value="Purok 3">Purok 3</option>
          <option value="Purok 4">Purok 4</option>
          <option value="Purok 5">Purok 5</option>
          <option value="Purok 6">Purok 6</option>
          <option value="Purok 7">Purok 7</option>
        </select>
      </div>

      <!-- Title Input -->
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" required placeholder="Enter the title of the announcement">
      </div>

      <!-- Date Input -->
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date" required>
      </div>

      <!-- Description Textarea -->
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control summernote" id="description" name="description" rows="4" placeholder="Enter announcement details" required></textarea>
      </div>

      <!-- Submit Button -->
      <div class="form-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>

<style type="text/css">
    /* Wrapper for the form */
.announcement-form-wrapper {
  max-width: 1200px;
  width: 100%;
  margin: 30px auto;
  padding: 20px;
  background-color: #ffffff;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

/* Header section */
.announcement-form-header {
  border-bottom: 2px solid #f0f0f0;
  margin-bottom: 15px;
  padding-bottom: 10px;
}

.announcement-form-header h5 {
  font-size: 18px;
  color: #333;
  margin: 0;
}

/* Form Body */
.announcement-form-body {
  font-size: 14px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  font-weight: 600;
  font-size: 14px;
  color: #333;
}

.form-group .form-control {
  width: 100%;
  padding: 10px;
  font-size: 14px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.form-group .form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
}

/* Footer (Submit Button) */
.form-footer {
  text-align: right;
}

.form-footer .btn {
  font-size: 14px;
  padding: 10px 20px;
  background-color: #007bff;
  border-color: #007bff;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.form-footer .btn:hover {
  background-color: #0056b3;
  border-color: #004085;
}

</style>
<style type="text/css">
    /* Overlay styling */
/* Overlay styling */
#eventDetailsOverlay {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}


/* Modal content styling */
#overlayContent {
    background-color: #f9f9f9;
    width: 90%;
    max-width: 600px; /* Limit max width for larger screens */
    padding: 30px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    text-align: left; /* Align text to the left */
    position: relative;
    animation: fadeIn 0.4s ease-in-out;
}

/* Close button styling */
#closeButton {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    color: #555;
    font-size: 24px;
    cursor: pointer;
}

#closeButton:hover {
    color: #ff3b3b;
}

/* Event details header styling */
#overlayContent h3 {
    margin-top: 0;
    font-size: 24px;
    font-weight: 600;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Event details text styling */
#overlayContent p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}

#overlayContent p strong {
    color: #333;
}
:root {
    --primary-color: #007bff; /* Set your primary color */
}
/* Fade-in animation for smooth appearance */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

</style>


<!-- HTML for the event details overlay -->
<div id="eventDetailsOverlay" style="display: none;">
    <div id="overlayContent">
        <!-- Event details will be populated here dynamically -->
        <button id="closeButton" onclick="closeOverlay()">✕</button>
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
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    // Initialize FullCalendar
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch('fetch-events.php')
                .then(response => response.json())
                .then(events => {
                    successCallback(events); // Pass events directly
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        },
        eventContent: function (arg) {
            // Customize the event display to show only the title (eventType) on the calendar
            let titleEl = document.createElement('div');
            titleEl.textContent = arg.event.title; // Display only the title

            // Set the background color for the event title
            titleEl.style.backgroundColor = 'var(--primary-color)'; // You can use any color or CSS variable

            // Optional: Adjust text color to contrast with the background
            titleEl.style.color = 'white'; // Set text color to white for visibility

            // Ensure that the title is clickable
            titleEl.style.cursor = 'pointer'; // Make the title clickable

            // Attach a click event to trigger the FullCalendar's eventClick handler
            titleEl.addEventListener('click', function () {
                // Manually trigger the eventClick callback
                arg.view.calendar.trigger('eventClick', arg.event);
            });

            return { domNodes: [titleEl] }; // Return the custom content
        },
        eventClick: function (info) {
            // Show the event details overlay when an event is clicked
            showEventDetailsOverlay(info.event);
        },
    });

    // Render the calendar
    calendar.render();

    // Ensure the overlay is hidden initially
    document.getElementById('eventDetailsOverlay').style.display = 'none';

    // Check if there are event details passed from PHP (manual event addition)
    const eventType = document.getElementById('eventTypeData')?.value;
    const eventDate = document.getElementById('eventDateData')?.value;
    const eventTime = document.getElementById('eventTimeData')?.value;
    const eventMessage = document.getElementById('eventMessageData')?.value;

    if (eventType && eventDate && eventTime && eventMessage) {
        // Combine the date and time for event start
        const eventStartDateTime = new Date(`${eventDate}T${eventTime}`).toISOString();

        // Add event dynamically
        calendar.addEvent({
            title: eventType,
            start: eventStartDateTime,
            description: eventMessage,
            allDay: false,
        });

        // Focus calendar on the new event
        calendar.gotoDate(eventStartDateTime);
    }
});

// Function to add a new event to the calendar via fetch
function addEventToCalendar() {
    const type = document.getElementById('eventType').value;
    const date = document.getElementById('eventDate').value;
    const time = document.getElementById('eventTime').value;
    const message = document.getElementById('eventMessage').value;

    // Combine date and time before sending to the server
    const eventDateTime = `${date}T${time}`;

    fetch('add-event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `type=${encodeURIComponent(type)}&datetime=${encodeURIComponent(eventDateTime)}&message=${encodeURIComponent(message)}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Event added successfully!');
                location.reload(); // Reload to update the calendar
            } else {
                alert('Failed to add event!');
            }
        })
        .catch(error => {
            console.error('Error adding event:', error);
        });

    return false; // Prevent form submission
}

// Function to show event details in an overlay
function showEventDetailsOverlay(event) {
    const overlay = document.getElementById('eventDetailsOverlay');
    const overlayContent = document.getElementById('overlayContent');

    // Populate overlay with event details
    overlayContent.innerHTML = `
        <button id="closeButton" onclick="closeOverlay()">✕</button>
        <h3>${event.title}</h3>
        <p><strong>Date:</strong> ${event.start.toISOString().slice(0, 10)}</p>
        <p><strong>Time:</strong> ${new Date(event.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
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

    <!-- SweetAlert2 CSS (only include this once) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</body>

</html>