<?php
session_start();
include 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

    <!-- CSS styling included directly here -->
    <style>
        /* General body styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('pic1.webp'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center; /* Light gray background */
            display: flex;
            justify-content: center;  /* Center horizontally */
            align-items: center;      /* Center vertically */
        }

        /* Container for the page */
        .container {
            width: 80%;
            max-width: 800px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            background: linear-gradient(145deg, #e0eafc, #cfdef3); /* Gradient background */
        }

        h2 {
            color: #3f3d56;
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Table styling */
        table {
            width: 100%;
            max-width: 700px;
            margin: 0 auto; /* Center the table horizontally */
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ff6f61; /* Red color for header */
            color: white;
            font-size: 1.2em;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Link styling inside table */
        td a {
            text-decoration: none;
            color: #ffffff;
            background-color: #28a745; /* Green color for action links */
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        td a:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Back button styling */
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #ff6f61;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #e74c3c; /* Darker red on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Users</h2>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['role'] . "</td>";
            echo "<td>
                    <a href='edit_user.php?id=" . $row['user_id'] . "'>Edit</a> | 
                    <a href='delete_user.php?id=" . $row['user_id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }
    ?>

    <a href='admin_dashboard.php' class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
