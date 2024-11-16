<?php
session_start();
include 'config.php';

// Check if the user is logged in and is faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_notification'])) {
    $message = $_POST['message'];
    $faculty_id = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s'); // Current date and time

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO notifications (faculty_id, message, created_at) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iss", $faculty_id, $message, $created_at);
    if ($stmt->execute()) {
        echo "<div class='success-message'>Notification sent successfully!</div>";
    } else {
        echo "<div class='error-message'>Error sending notification: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notification</title>
    <style>
        /* Page Styling */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        /* Form Container */
        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #fff;
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px #000;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #2193b0;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
            resize: none;
        }

        textarea:focus {
            border-color: #6dd5ed;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2193b0;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background: #6dd5ed;
            transform: scale(1.05);
        }

        /* Success and Error Message Styling */
        .success-message, .error-message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            font-weight: bold;
            color: #fff;
        }

        .success-message {
            background-color: #28a745;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            background-color: #dc3545;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Send a Notification</h2>
    <form method="POST" action="send_notification.php">
        <textarea name="message" placeholder="Notification Message" required></textarea><br>
        <button type="submit" name="send_notification">Send Notification</button>
    </form>
    <a href="manage_notifications.php">Manage Notifications</a>

    <a href='faculty_dashboard.php'>Back to Dashboard</a>
</body>
</html>
