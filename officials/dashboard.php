


<?php
// Start the session
session_start();

// Check if the resident is logged in
if (!isset($_SESSION['official_id'])) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit();
}

// Access the session variables
$official_id = $_SESSION['official_id'];
$official_username = $_SESSION['official_username'];  // Retrieve the resident's username from session
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
                    <li class="nav-item"><a class="nav-link" href="officials_announcement.php"><i class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">Add New Event</button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            


                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Welcome, <?php echo htmlspecialchars($official_username); ?></span><img class="border rounded-circle img-profile" src="https://www.w3schools.com/howto/img_avatar.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="sms_logs.php"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;SMS Logs</a><div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

<div class="container-fluid" style="overflow: auto; max-height: 70vh;">
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span> Total Residents</span></div>
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
                    </div>

                <div class="container-fluid">


         
  <div id="calendar"></div>

      <!-- Search Filter -->
    <div class="mt-3">
        <input type="text" id="searchFilter" class="form-control" placeholder="Search Barangay Events" onkeyup="filterTable()">
    </div>
<?php

$servername = "localhost";
$username = "root";
$password = "";
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
                                       $time = $event['time'];
$formattedTime = date('h:i A', strtotime($time)); // Converts time to 12-hour format with AM/PM
echo "<td>" . htmlspecialchars($formattedTime) . "</td>";
                    echo "<td>" . htmlspecialchars($event['message']) . "</td>";
                    echo "<td class='text-center'>
                            <button class='btn btn-primary btn-sm edit-btn' data-id='".$event['id']."' data-type='".$event['type']."' data-date='".$event['date']."' data-time='".$event['time']."' data-message='".$event['message']."' data-toggle='modal' data-target='#eventModal'>Edit</button>
                            <button class='btn btn-danger btn-sm delete-btn' data-id='".$event['id']."'>Delete</button>
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



<!-- Modal for Adding or Editing Event -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add/Edit Event</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eventForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="type" class="form-label">Event Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Event Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Event Description</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Event Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <input type="hidden" name="event_id" id="event_id">
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- HTML for the event details overlay -->
<div id="eventDetailsOverlay" style="display: none;">
    <div id="overlayContent">
        <!-- Event details will be populated here dynamically -->
        <button id="closeButton" onclick="closeOverlay()">✕</button>
    </div>
</div>


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

<!-- Modal Structure -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">Add New Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form to Add Event -->
        <form id="eventForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="type" class="form-label">Event Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Event Time</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Event Description</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Event Image (JPEG Only)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Event</button>
        </form>
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

    <!-- SweetAlert2 CSS (only include this once) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</body>

</html>