<?php
include 'config.php';

// Fetch all notifications
$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>Notifications</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>Faculty ID:</strong> " . $row['faculty_id'] . "<br><strong>Message:</strong> " . $row['message'] . "<br><small>" . $row['created_at'] . "</small></p>";
    }
} else {
    echo "No notifications available.";
}
?>
