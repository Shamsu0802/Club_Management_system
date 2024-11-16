<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- CSS included directly here -->
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
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

        /* Container for the entire dashboard */
        .dashboard-container {
            width: 70%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Transparent white background */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }

        /* Header style */
        header {
            margin-bottom: 30px;
        }

        header h2 {
            color: #333;
            font-size: 2em;
        }

        /* Navigation links style */
        nav {
            margin-bottom: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            padding: 10px 20px;
            background-color: #f9f9f9;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #4CAF50;
            color: white;
        }

        /* Footer style */
        footer {
            margin-top: 50px;
            color: #888;
        }

        footer p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h2>Welcome, Admin</h2>
        </header>
        
        <nav>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="approve_events.php">Approve Events</a></li>
                <li><a href="view_report.php">View Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <footer>
            <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
