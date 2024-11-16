<?php
session_start();
include 'config.php';

// Check if the user is logged in and is a faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header("Location: index.php");
    exit();
}

// Debugging: Check if event_id is passed correctly in the URL
// Uncomment these lines for debugging if needed
// echo '<pre>';
// var_dump($_GET); // This will show the entire query string array
// echo '</pre>';

// Handle event deletion
$message = ""; // Variable to store feedback message
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Query to fetch event details to ensure it's owned by the faculty member
    $sql = "SELECT * FROM events WHERE event_id = '$event_id' AND faculty_id = '{$_SESSION['user_id']}'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $message = "Event not found or you don't have permission to delete this event.";
    } else {
        // Delete the event from the database
        $delete_sql = "DELETE FROM events WHERE event_id = '$event_id'";
        if ($conn->query($delete_sql)) {
            $message = "Event deleted successfully!";
        } else {
            $message = "Error deleting event: " . $conn->error;
        }
    }
} else {
    $message = "Event ID not specified.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
    <style>
        /* Body styling */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
            color: #fff;
        }

        /* Container for feedback messages */
        .message-container {
            width: 90%;
            max-width: 500px;
            padding: 20px;
            background:#0000ff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Success message styling */
        .success {
            color: #ffffff;
            background-color: #33cc33;
            padding: 10px;
            border: 5px solid #00cc00;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Error message styling */
        .error {
            color: #ffffff;
            background-color: #ff3300;
            padding: 10px;
            border: 5px solid #cc0000;            ;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Back to dashboard link styling */
        .back-link {
            display: inline-block;
            text-decoration: none;
            color: #cc00cc;
            background: #ffff99;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s, transform 0.2s;
            font-weight: bold;
        }

        .back-link:hover {
            background: #ccffff;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="message-container">
        <?php
        // Display feedback message
        if (!empty($message)) {
            if (strpos($message, 'successfully') !== false) {
                echo "<div class='success'>$message</div>";
            } else {
                echo "<div class='error'>$message</div>";
            }
        }
        ?>
        <a href='faculty_dashboard.php' class='back-link'>Back to Dashboard</a>
    </div>
</body>
</html>
