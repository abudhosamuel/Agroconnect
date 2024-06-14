<?php
$servername = "localhost";
$username = "agroconnect_user"; // Replace with your actual MySQL username
$password = "your_password";   // Replace with your actual MySQL password
$dbname = "agroconnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>