<?php
session_start();
include 'config.php';

// Check if the user is logged in and is a faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header("Location: index.php");
    exit();
}

// Variables to hold messages
$message = '';
$messageType = '';

// Fetch the event details to edit
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Query to fetch event details by event ID and faculty ID
    $sql = "SELECT * FROM events WHERE event_id = '$event_id' AND faculty_id = '{$_SESSION['user_id']}'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $message = "Event not found or you don't have permission to edit this event.";
        $messageType = 'error';
    } else {
        $event = $result->fetch_assoc();
    }
} else {
    $message = "Event ID not specified.";
    $messageType = 'error';
}

// Handle form submission to update event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($message)) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Update event in the database
    $update_sql = "UPDATE events SET title='$title', description='$description', date='$date' WHERE event_id = '$event_id'";
    if ($conn->query($update_sql)) {
        $message = "Event updated successfully!";
        $messageType = 'success';
    } else {
        $message = "Error updating event: " . $conn->error;
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Event</title>
<style>
    /* General body styling */
    body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;

        font-family: Arial, sans-serif;
        color: #ffffff;
        margin: 0;
    }

    /* Message styling */
    .message-container {
        width: 90%;
        max-width: 500px;
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
    }

    .success-message {
        background-color: #28a745;
        color: #ffffff;
    }

    .error-message {
        background-color: #dc3545;
        color: #ffffff;
    }

    /* Form container styling */
    .form-container {
        width: 90%;
        max-width: 500px;
        padding: 20px;
        background: rgba(0, 0, 0, 0.8);
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #e94560;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #e0e0e0;
    }

    input[type="text"], input[type="date"], textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 2px solid #e94560;
        border-radius: 8px;
        background-color: #16213e;
        color: #ffffff;
    }

    textarea {
        height: 100px;
        resize: vertical;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #e94560;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #ff4b2b;
        transform: scale(1.05);
    }
</style>
</head>
<body>

<!-- Display success or error message above the form container -->
<?php if (!empty($message)) : ?>
    <div class="message-container <?php echo $messageType == 'success' ? 'success-message' : 'error-message'; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- Form container -->
<div class="form-container">
    <h2>Edit Event</h2>
    <form method="POST" action="edit_event.php?event_id=<?php echo $event_id; ?>">
        <label for="title">Event Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($event['title'] ?? '', ENT_QUOTES); ?>" required>

        <label for="description">Event Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($event['description'] ?? '', ENT_QUOTES); ?></textarea>

        <label for="date">Event Date:</label>
        <input type="date" name="date" value="<?php echo $event['date'] ?? ''; ?>" required>

        <button type="submit">Update Event</button>

    </form>
</div>
<!-- Back to Dashboard Button -->
<div style="display: flex; justify-content: center; margin-top: 20px;">
    <a href="faculty_dashboard.php">
        <button type="button" style="
            padding: 10px;
            background: linear-gradient(45deg, #0fd850, #00f9ff);
            color: #8b00ff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight:bold;
            cursor: pointer;

            width: 150px;
            transition: background-color 0.3s, transform 0.2s;
        ">Back to Dashboard</button>
    </a>
</div>


</body>
</html>
