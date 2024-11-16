<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Query to get all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "<h2>Manage Users</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>";

while ($user = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $user['user_id'] . "</td>
            <td>" . $user['username'] . "</td>
            <td>" . $user['role'] . "</td>
            <td>
                <a href='edit_user.php?id=" . $user['user_id'] . "'>Edit</a> |
                <a href='delete_user.php?id=" . $user['user_id'] . "'>Delete</a>
            </td>
        </tr>";
}
echo "</table>";
?>
