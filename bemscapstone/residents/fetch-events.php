<?php
include("connections.php");

$events = [];
$query = mysqli_query($connections, "SELECT * FROM tbl_info");

while ($row = mysqli_fetch_assoc($query)) {
    $events[] = [
        'title' => $row['type'],
        'start' => $row['date'],
        'description' => $row['message']
    ];
}

echo json_encode($events);
?>

