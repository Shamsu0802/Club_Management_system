<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Query to get events that are pending approval
$sql = "SELECT * FROM events WHERE status = 'pending'";
$result = $conn->query($sql);

echo "<h2>Manage Events</h2>";
echo "<table border='1'>
        <tr>
            <th>Event Title</th>
            <th>Description</th>
            <th>Faculty</th>
            <th>Action</th>
        </tr>";

while ($event = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $event['title'] . "</td>
            <td>" . $event['description'] . "</td>
            <td>" . $event['faculty_id'] . "</td>
            <td>
                <a href='approve_event.php?id=" . $event['event_id'] . "'>Approve</a> |
                <a href='reject_event.php?id=" . $event['event_id'] . "'>Reject</a>
            </td>
        </tr>";
}
echo "</table>";
?>
