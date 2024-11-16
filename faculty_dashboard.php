<?php
session_start();
include 'config.php';

// Check if the user is logged in and is faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header("Location: index.php");
    exit();
}

echo "<h2>Welcome, Faculty</h2>";

// Functionality: Post a New Event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $faculty_id = $_SESSION['user_id'];

    // Using prepared statements to insert event data securely
    $stmt = $conn->prepare("INSERT INTO events (title, description, date, faculty_id, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sssi", $title, $description, $date, $faculty_id);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Event posted successfully!</div>";
    } else {
        echo "<div class='error-message'>Error posting event: " . $conn->error . "</div>";
    }
    $stmt->close();
}

// Functionality: View All Events
$result = $conn->query("SELECT * FROM events WHERE faculty_id = " . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Faculty Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #4a90e2, #9013fe);
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        
    }

    h2 {
        color: #ffeb3b;
    }

    .event-container {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        width: 80%;
        max-width: 600px;
        text-align: left;
    }

    .event-container h4 {
        color: #ffeb3b;
        margin-bottom: 5px;
    }

    .event-container p {
        margin: 5px 0;
    }

    .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .button-container a, .button-container button {
        padding: 10px 20px;
        margin: 5px;
        border: none;
        color: #fff;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .button-container a:hover {
        background-color: #e74c3c;
    }

    .edit-button {
        background-color: #28a745;
    }

    .delete-button {
        background-color: #d9534f;
    }

    .success-message {
        color: #4caf50;
        text-align: center;
    }

    .error-message {
        color: #f44336;
        text-align: center;
    }

    form {
        background: rgba(255, 255, 255, 0.2);
        padding: 20px;
        border-radius: 10px;
        width: 100%;
        max-width: 500px;
        text-align: center;
    }

    input[type="text"],
    textarea,
    input[type="date"] {
        width: 90%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button[type="submit"] {
        background-color: #ff5733;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #c0392b;
    }

    .notification-button {
        background-color: #3498db;
    }

    .notification-button:hover {
        background-color: #2980b9;
    }
</style>
</head>
<body>

<h2>Your Events</h2>

<?php
if ($result->num_rows > 0) {
    while ($event = $result->fetch_assoc()) {
        echo "<div class='event-container'>
                <h4>" . htmlspecialchars($event['title']) . "</h4>
                <p>" . htmlspecialchars($event['description']) . "</p>
                <p><strong>Date:</strong> " . htmlspecialchars($event['date']) . "</p>
                <p><strong>Status:</strong> " . htmlspecialchars($event['status']) . "</p>
                <div class='button-container'>
                    <a href='edit_event.php?event_id=" . $event['event_id'] . "' class='edit-button'>Edit</a>
                    <a href='delete_event.php?event_id=" . $event['event_id'] . "' class='delete-button'>Delete</a>
                </div>
              </div>";
    }
} else {
    echo "<p>No events found. Create a new one below!</p>";
}
?>

<h3>Create a New Event</h3>
<form method="POST" action="faculty_dashboard.php">
    <input type="text" name="title" placeholder="Event Title" required><br>
    <textarea name="description" placeholder="Event Description" required></textarea><br>
    <input type="date" name="date" required><br>
    <div class="button-container">
        <button type="submit" name="create_event">Post Event</button>
    </div>
</form>

<!-- Centered Notification Link -->
<div class="button-container">
    <a href='send_notification.php' class='notification-button'>Send Notification</a>
</div>

<!-- Logout Link -->
<div class="button-container">
    <a href='logout.php' class='notification-button'>Logout</a>
</div>

</body>
</html>
