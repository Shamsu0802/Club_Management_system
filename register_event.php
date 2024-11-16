<?php
session_start();
include 'config.php';

// Initialize message variable
$message = "";

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    // Redirect if the user is not a student
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id']; // Event the student wants to register for
    $user_id = $_SESSION['user_id']; // Student's user ID from session

    // Check if the student has already registered for the event
    $check_sql = "SELECT * FROM registrations WHERE user_id = $user_id AND event_id = $event_id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $message = "You have already registered for this event.";
    } else {
        // Insert the registration record into the database
        $sql = "INSERT INTO registrations (event_id, user_id) VALUES ('$event_id', '$user_id')";
        if ($conn->query($sql)) {
            $message = "You have successfully registered for the event!";
        } else {
            $message = "Error registering for the event: " . $conn->error;
        }
    }
}
?>

<!-- Event registration form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Centered Container */
        .registration-container {
            width: 100%;
            max-width: 600px;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            box-sizing: border-box;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        /* Form Field Styling */
        label {
            font-size: 1.2rem;
            color: #2c3e50;
            margin-bottom: 10px;
            display: block;
        }

        select, button {
            width: 100%;
            padding: 15px;
            font-size: 1rem;
            margin: 15px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #00e6e6;
            color: white;
            cursor: pointer;
            font-size: 1.1rem;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Message Styling */
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .success {
            background-color: #ff0066;
            color: white;
        }

        .error {
            background-color: #e74c3c;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .registration-container {
                width: 90%;
                padding: 20px;
            }

            button {
                font-size: 1rem;
                padding: 12px;
            }

            select {
                font-size: 1rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="registration-container">
    <h2>Register for Event</h2>

    <!-- Display message if available -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Event Registration Form -->
    <form method="POST" action="register_event.php">
        <label for="event_id">Select Event:</label>
        <select name="event_id" required class="form-control">
            <option value="">-- Select Event --</option>
            <?php
            // Fetch all events
            $events_result = $conn->query("SELECT * FROM events WHERE status = 'approved'");
            while ($event = $events_result->fetch_assoc()) {
                echo "<option value='" . $event['event_id'] . "'>" . $event['title'] . "</option>";
            }
            ?>
        </select><br>

        <button type="submit">Register for Event</button>
    </form>
</div>

</body>
</html>
