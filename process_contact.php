<?php

// Include your database connection file
include 'db_connect.php'; // Replace 'db_connection.php' with the actual filename

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate form data (you can add more validation as needed)
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Simple validation, you can enhance this based on your requirements
    if (empty($name) || empty($email) || empty($message)) {
        // Handle validation error (redirect back to the form, display an error message, etc.)
        header("Location: contactus.php?error=empty_fields");
        exit();
    }

    // Assuming you have a 'contactus' table in your database with columns 'name', 'email', and 'message'
    $sql = "INSERT INTO contactus (name, email, message) VALUES (?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect back to the contact form with a success message
    header("Location: contactus.php?success=true");
    exit();
} else {
    // If the form is not submitted directly, redirect back to the contact form
    header("Location: contactus.php");
    exit();
}
?>
