<!-- approve_event.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$event_id = $_GET['id'];

// Approve the event
$sql = "UPDATE events SET status='approved' WHERE event_id=$event_id";
$success = false;
$message = "";

if ($conn->query($sql) === TRUE) {
    $message = "Event approved successfully!";
    $success = true;
} else {
    $message = "Error approving event: " . $conn->error;
}
header("Refresh: 2; URL=approve_events.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Event</title>
    <style>
        /* Background Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Message Container Styling */
        .message-container {
            width: 90%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
            animation: fadeInUp 0.5s ease;
            backdrop-filter: blur(10px);
        }

        .message {
            font-size: 1.2rem;
            font-weight: bold;
            padding: 15px;
            border-radius: 10px;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .success {
            background: linear-gradient(135deg, #28a745, #4caf50);
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.7);
        }

        .error {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
        }

        /* Keyframe Animation */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Spinner */
        .spinner {
            margin-top: 20px;
            width: 30px;
            height: 30px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #ffffff;
            border-radius: 50%;
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

    </style>
</head>
<body>
    <div class="message-container">
        <?php if ($success): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php else: ?>
            <div class="message error"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="spinner"></div>
        <p style="color: #ffffff; margin-top: 10px;">Redirecting back...</p>
    </div>
</body>
</html>
