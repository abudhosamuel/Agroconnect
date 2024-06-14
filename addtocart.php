<?php
session_start();

// Check if the cart exists in the session, if not, create one
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the product ID is set in the GET request
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Convert the ID to an integer for security

    // Check if the product is already in the cart
    if (!in_array($product_id, $_SESSION['cart'])) {
        // Add product to the cart
        $_SESSION['cart'][] = $product_id;
    }

    // Redirect to a page to show the cart or back to the product list
    header('Location: cart.php'); // Replace 'cart.php' with the actual cart page
    exit;
}

// If no product ID is found or the user directly accesses this page, redirect them
header('Location: indexloggedin.php'); // Replace 'index.php' with your main product listing page
exit;
?>
