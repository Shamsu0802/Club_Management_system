<?php
session_start();
include 'config.php';

// Check if the user is logged in as faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header("Location: index.php");
    exit();
}

$notification_id = $_GET['id'];

// Delete the notification
$sql = "DELETE FROM notifications WHERE notification_id = ?";
$stmt = $conn->prepare($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Notification</title>
    <style>
        /* Body Styling */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
        }

        /* Container for Message */
        .message-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
        }

        /* Success and Error Message Styling */
        .success-message, .error-message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .success-message {
            background-color: #28a745;
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            background-color: #dc3545;
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Redirecting Message */
        .redirect-message {
            font-size: 1rem;
            color: #f1f1f1;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <?php
        if ($stmt) {
            $stmt->bind_param("i", $notification_id);
            if ($stmt->execute()) {
                echo "<div class='success-message'>Notification deleted successfully!</div>";
            } else {
                echo "<div class='error-message'>Error deleting notification: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='error-message'>Error preparing statement: " . $conn->error . "</div>";
        }
        ?>
        <div class="redirect-message">Redirecting you back to manage notifications...</div>
    </div>
    <?php
    header("Refresh: 2; URL=manage_notifications.php");
    $conn->close();
    ?>
</body>
</html>
