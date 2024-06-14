<?php
session_start();

// Include the database connection file
include("db_connect.php");

// Check if the user is logged in
if (!isset($_SESSION["user_email"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Check if the admin has approved a user's registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    // Assume $userId contains the ID of the user whose registration is being approved
    $userId = $_POST['user_id']; // This value should be obtained from your form or process

    // Perform the approval process (update user status, etc.)
    // ...

    // Insert notification for the user
    $userEmail = getUserEmailById($userId); // Function to get user email by ID
    $message = "Registration approved by admin";
    $insertSql = "INSERT INTO notifications (user_email, message) VALUES ('$userEmail', '$message')";
    mysqli_query($conn, $insertSql);

    // Redirect back to admin panel or wherever appropriate
    header("Location: newusers.php");
    exit();
}

// Fetch notifications for the current user from the database
$userEmail = $_SESSION["user_email"];
$sql = "SELECT * FROM notifications WHERE user_email = '$userEmail'";
$result = mysqli_query($conn, $sql);

// Check if notifications are found
if (mysqli_num_rows($result) > 0) {
    // Display the notifications
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='notification'>" . $row["message"] . "</div>";
    }
} else {
    // If no notifications are found, display a message
    echo "<div class='no-notifications'>No new notifications</div>";
}

// Function to get user email by ID (replace with your actual implementation)
function getUserEmailById($userId) {
    // Your implementation to fetch user email from database based on user ID
    // Return the user's email
    return "user@example.com"; // Placeholder example
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="notifications.css">
    <title>Notifications</title>
</head>
<body>

</body>
</html>
