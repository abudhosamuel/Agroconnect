<?php
session_start();

// Include the database connection file
include("db_connect.php");

// Check if the user is logged in and is an administrator
if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    // Redirect to login page or another page
    header("Location: login.php");
    exit();
}

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $farmer_id = $_GET['id'];

    // Delete the farmer from the database
    $delete_sql = "DELETE FROM farmer_tablenew WHERE id = $farmer_id";
    $delete_result = mysqli_query($conn, $delete_sql);

    // Check if the deletion was successful
    if ($delete_result) {
        // Redirect to the farmers page or another page
        header("Location: farmersadmin.php");
        exit();
    } else {
        // Handle the deletion error (e.g., display an error message)
        $error_message = "Failed to delete farmer.";
    }
} else {
    // Redirect to the farmers page if the ID is not provided
    header("Location: farmersadmin.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
