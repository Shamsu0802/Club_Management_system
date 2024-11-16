<?php
include('config.php'); // Include database connection file

$successMessage = ''; // Variable to store the success message

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $checkQuery = "SELECT * FROM users WHERE username='$username'";    
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If the username already exists, show an error
        echo "<div class='alert error'>Username already exists. Please choose another.</div>";
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new student into the database
        $insertQuery = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', 'student')";
        if (mysqli_query($conn, $insertQuery)) {
            $successMessage = "Registration successful! Please <a href='index.php'>login</a> now.";
        } else {
            echo "<div class='alert error'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('pic1.webp'); /* Add your background image here */
            background-size: cover;
            color: #333;
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .alert.success {
            background-color: #00bcd4; /* Aqua blue for success */
            color: white;
        }

        .alert.error {
            background-color: #f44336; /* Red for error */
            color: white;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php if ($successMessage != ''): ?>
        <div class="alert success"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Enter username" required><br><br>
            <input type="password" name="password" placeholder="Enter password" required><br><br>
            <input type="submit" name="register" value="Register">
        </form>
    </div>

</body>
</html>
