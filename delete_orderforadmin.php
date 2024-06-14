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

// Check if order ID is provided
if (!isset($_GET['id'])) {
    echo "Order ID not provided.";
    exit;
}

// Retrieve order ID from the URL
$order_id = $_GET['id'];

// Delete the order from the database
$delete_sql = "DELETE FROM new_orders WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $order_id);
$delete_stmt->execute();

// Redirect to the orders_admin.php page after deleting the order
header("Location: orders_admin.php");
exit;
?>
