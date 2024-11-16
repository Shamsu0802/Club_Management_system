<?php
session_start();
include 'config.php';

// Check if the user is logged in as faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header("Location: index.php");
    exit();
}

$faculty_id = $_SESSION['user_id'];

// Fetch notifications created by this faculty
$sql = "SELECT notification_id, message, created_at FROM notifications WHERE faculty_id = $faculty_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;

            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2193b0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .btn-delete {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .no-notifications {
            text-align: center;
            color: #555;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2193b0;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Notifications</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <a href="delete_notification.php?id=<?php echo $row['notification_id']; ?>" 
                               class="btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-notifications">No notifications to display.</p>
        <?php endif; ?>
        <a href="faculty_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
