<?php
session_start();
include 'config.php';

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    /* General Styles */
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        color: #bf80ff;
        background: linear-gradient(120deg, #4e54c8, #8f94fb);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;

        padding: 20px;
        transition: background 0.5s;
    }

    /* Dark Mode */
    body.dark {
        background: linear-gradient(120deg, #232526, #414345);
        color: #e0e0e0;
    }
        /* Welcome Heading Color */
        .header h2 {
        font-size: 2.5rem;
        animation: typewriter 3s steps(40) 1 normal both;
        border-right: 2px solid #fff;
        white-space: nowrap;
        overflow: hidden;
        color: #ffeb3b; /* New color for 'Welcome to Your Dashboard' heading */
    }

    /* Notifications Heading Color */
    .notifications-section h3 {
        color: #ff9800; /* New color for 'Notifications' heading */
    }


    .dashboard {
        width: 100%;
        max-width: 1200px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        grid-template-rows: auto;
    }

    .toggle-mode {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #03a9f4;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        color: #fff;
    }

    /* Typewriter Effect */
    .header h2 {
        font-size: 2.5rem;
        animation: typewriter 3s steps(40) 1 normal both;
        border-right: 2px solid #fff;
        white-space: nowrap;
        overflow: hidden;
    }

    @keyframes typewriter {
        from { width: 0; }
        to { width: 100%; }
    }

    /* Event Flip Card */
    .flip-card {
        width: 100%;
        height: 220px;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.8s;
        transform-style: preserve-3d;
        cursor: pointer;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .flip-card-front {
        background-color: #ffc107;
        color: black;
    }

    .flip-card-back {
        background-color: #28a745;
        color: white;
        transform: rotateY(180deg);
    }

    /* Notifications Section */
    .notifications {
        max-height: 500px;
        overflow-y: auto;
        padding: 20px;
        background: #2c3e50;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
    }

    .notification-card {
        background: #333;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        position: relative;
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
    }

    .notification-card:hover {
        transform: translateY(-5px);
    }

    .notification-badge {
        background: #ff4757;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        margin-right: 15px;
        font-size: 18px;
    }

    .notification-message {
        flex: 1;
    }

    .btn {
        padding: 10px;
        background: #03a9f4;
        border: none;
        color: #fff;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #0288d1;
    }

    /* Event and Notification Containers */
    .events-section {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .notifications-section {
        background: #34495e;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard {
            grid-template-columns: 1fr;
        }

        .toggle-mode {
            top: 10px;
            right: 10px;
        }
    }
</style>
</head>
<body>
    <!-- Dark Mode Toggle -->
    <button id="toggleMode" class="toggle-mode">🌙 Dark Mode</button>

    <div class="dashboard">
        <!-- Events Section -->
        <div class="events-section">
            <div class="header">
                <h2>🎉 Welcome to Your Dashboard</h2>
            </div>
            <h3>📅 Upcoming Events</h3>
            <?php
            $result = $conn->query("SELECT * FROM events WHERE status = 'approved'");
            if ($result->num_rows > 0) {
                while ($event = $result->fetch_assoc()) {
                    echo "
                    <div class='flip-card'>
                        <div class='flip-card-inner'>
                            <div class='flip-card-front'>
                                <h4>{$event['title']}</h4>
                                <p>Date: {$event['date']}</p>
                            </div>
                            <div class='flip-card-back'>
                                <p>{$event['description']}</p>
                                <button class='btn' onclick='registerEvent({$event['event_id']})'>Register</button>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No events found</p>";
            }
            ?>
        </div>

        <!-- Notifications Section -->
        <div class="notifications-section">
            <h3>🔔 Notifications</h3>
            <?php
            $notifications = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
            if ($notifications->num_rows > 0) {
                while ($notification = $notifications->fetch_assoc()) {
                    echo "
                    <div class='notification-card'>
                        <div class='notification-badge'><i class='fas fa-bell'></i></div>
                        <div class='notification-message'>
                            <p>{$notification['message']}</p>
                            <small>Posted on: {$notification['created_at']}</small>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No new notifications</p>";
            }
            ?>
        </div>
    </div>

<script>
    // Dark Mode Toggle
    const toggleBtn = document.getElementById('toggleMode');
    toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark');
        toggleBtn.textContent = document.body.classList.contains('dark') ? '☀️ Light Mode' : '🌙 Dark Mode';
    });

    // Register Event Function
    function registerEvent(eventId) {
        window.location.href = `register_event.php?event_id=${eventId}`;
    }
</script>
</body>
</html>
