<?php
include("connections.php");

$events = [];
$query = mysqli_query($connections, "SELECT * FROM tbl_info");

while ($row = mysqli_fetch_assoc($query)) {
    $startDateTime = $row['date'] . 'T' . $row['time']; // Combine date and time
    $events[] = [
        'title' => $row['type'],
        'start' => $startDateTime, // Use combined date and time
        'description' => $row['message']
    ];
}

echo json_encode($events);
?>
