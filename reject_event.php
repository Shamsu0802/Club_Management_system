<!-- reject_event.php -->
<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$event_id = $_GET['id'];

// Variables to hold messages
$message = '';
$messageType = '';

// Reject the event
$sql = "UPDATE events SET status='rejected' WHERE event_id=$event_id";
if ($conn->query($sql) === TRUE) {
    $message = "Event rejected successfully.";
    $messageType = 'error';
} else {
    $message = "Error rejecting event: " . $conn->error;
    $messageType = 'error';
}

// Redirect to approve_events.php after 2 seconds
header("Refresh: 2; URL=approve_events.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject Event</title>
    <style>
        /* General styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #2b5876, #4e4376);
            font-family: Arial, sans-serif;
            color: #fff;
        }

        /* Message container styling */
        .message-container {
            width: 90%;
            max-width: 500px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            animation: fadeIn 1s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .error {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
        }

        /* Animation for fade-in effect */
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

        /* Glow effect */
        .message-container {
            box-shadow: 0 0 15px rgba(255, 75, 43, 0.8);
        }

        /* Spinning icon animation */
        .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Success/error text */
        .text {
            font-size: 1.2rem;
            font-weight: bold;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <!-- Message Display -->
    <div class="message-container <?php echo $messageType; ?>">
        <div class="icon">❌</div>
        <div class="text"><?php echo $message; ?></div>
    </div>

</body>
</html>
