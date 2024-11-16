<?php
$servername = "localhost";
$username = "root"; // Default MySQL username in XAMPP
$password = "";     // Default MySQL password is empty in XAMPP
$dbname = "datascience_club"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
