<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    // Display a success message
    echo "<div class='success-message'>Notification sent: " . htmlspecialchars($message) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notification</title>
    <style>
        /* Body styling */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        
            font-family: 'Arial', sans-serif;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            padding: 20px;
            margin: 0;
            color: #333;
        }

        /* Heading styling */
        h2 {
            color: #fff;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px #444;
        }

        /* Form styling */
        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Textarea styling */
        textarea {
            width: 100%;
            height: 120px;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 2px solid #ff6f61;
            font-size: 16px;
            outline: none;
            resize: none;
            transition: border 0.3s;
        }

        textarea:focus {
            border: 2px solid #ffde7d;
        }

        /* Button styling */
        button {
            width: 100%;
            padding: 12px 20px;
            background-color: #ff6f61;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #ffde7d;
            transform: scale(1.05);
        }

        /* Success message styling */
        .success-message {
            background-color: #4caf50;
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <h2>Send Notification to Users</h2>
    <form method="POST">
        <textarea name="message" placeholder="Enter your notification message" required></textarea>
        <button type="submit">Send Notification</button>
    </form>
</body>
</html>
