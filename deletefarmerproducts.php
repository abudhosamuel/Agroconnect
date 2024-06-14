<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Farmer") {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $product_id = $_GET["id"];

    // Prepare a DELETE statement
    $sql = "DELETE FROM productsnew WHERE id = ? AND farmer_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $product_id, $_SESSION["user_email"]);

    // Execute the statement
    if ($stmt->execute()) {
        // Product deleted successfully, you can redirect or display a success message
        header("Location: farmermyproducts.php");
        exit();
    } else {
        // Handle the case where the product couldn't be deleted
        echo "Failed to delete the product. Please try again.";
    }

    $stmt->close();
} else {
    // Handle invalid request, redirect to farmermyproducts.php or display an error message
    header("Location: farmermyproducts.php");
    exit();
}
?>
