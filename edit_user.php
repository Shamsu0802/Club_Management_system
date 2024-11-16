<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('pic1.webp') no-repeat center center/cover;
            font-family: Arial, sans-serif;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #ff6f61;
            text-decoration: none;
        }
        .back-link:hover {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit User</h2>
        <form method="POST" action="edit_user.php">
            <?php
            session_start();
            include 'config.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user_id = $_POST['user_id'];
                $username = $_POST['username'];
                $role = $_POST['role'];
                $sql = "UPDATE users SET username='$username', role='$role' WHERE user_id=$user_id";

                if ($conn->query($sql) === TRUE) {
                    echo "<p class='message'>User updated successfully.</p>";
                } else {
                    echo "<p class='message'>Error updating user: " . $conn->error . "</p>";
                }
                echo "<a href='manage_users.php' class='back-link'>Back to User Management</a>";
                exit();
            }

            $user_id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE user_id=$user_id";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();
            ?>

            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
            <label>Role:</label>
            <select name="role">
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="faculty" <?php if ($user['role'] == 'faculty') echo 'selected'; ?>>Faculty</option>
                <option value="student" <?php if ($user['role'] == 'student') echo 'selected'; ?>>Student</option>
            </select>
            <button type="submit">Update User</button>
        </form>
        <a href="manage_users.php" class="back-link">Back to User Management</a>
    </div>
</body>
</html>
