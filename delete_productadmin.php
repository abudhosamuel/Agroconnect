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

// Check if the product ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Perform the product deletion
    $sql = "DELETE FROM productsnew WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Product deleted successfully, redirect to the products page
        header("Location: products_admin.php");
        exit();
    } else {
        // Product deletion failed, handle accordingly
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    // Redirect to products page if product ID is not provided
    header("Location: products.php");
    exit();
}
?>
