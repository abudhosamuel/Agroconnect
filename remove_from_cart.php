<?php
session_start();

// Check if the 'product_id' is passed and the cart session exists
if (isset($_POST['product_id']) && isset($_SESSION['cart'])) {
    $productIdToRemove = intval($_POST['product_id']); // Convert to integer for security

    // Search for the product ID in the cart and remove it
    if (($key = array_search($productIdToRemove, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
?>
