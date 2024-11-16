<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('pic1.webp') no-repeat center center/cover;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .message {
            font-size: 1.2em;
            color: #333;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff6f61;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-btn:hover {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    session_start();
    include 'config.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
        header("Location: index.php");
        exit();
    }

    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='message'>User deleted successfully.</p>";
    } else {
        echo "<p class='message'>Error deleting user: " . $conn->error . "</p>";
    }
    ?>
    <a href="manage_users.php" class="back-btn">Back to User Management</a>
</div>

</body>
</html>
