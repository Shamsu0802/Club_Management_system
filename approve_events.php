<!-- approve_events.php -->
<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch pending events
$sql = "SELECT * FROM events WHERE status='pending' ORDER BY date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;

        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #2a6da8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #2a6da8;
            color: #ffffff;
        }
        .btn {
            padding: 8px 8px;
            text-decoration: none;
            color: #ffffff;
            border-radius: 5px;
            font-size: 10px;
            font-weight:bold;
            margin-right: 15px;
        }
        .btn-approve {
            background-color: #4CAF50;
        }
        .btn-reject {
            background-color: #f44336;
        }
        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Pending Event Approvals</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td>
                        <a href="approve_event.php?id=<?php echo $row['event_id']; ?>" class="btn btn-approve">Approve</a>
                        <a href="reject_event.php?id=<?php echo $row['event_id']; ?>" class="btn btn-reject">Reject</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: #555;">No pending events.</p>
    <?php endif; ?>
</div>
</body>
</html>
