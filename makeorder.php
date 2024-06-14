<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "agroconnect_user";
$password = "your_password";
$dbname = "agroconnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging - check received POST data (Remove these lines in production)
echo "Received product ID: " . (isset($_POST['product_id']) ? $_POST['product_id'] : "Not set") . "<br/>";
echo "Received quantity: " . (isset($_POST['quantity']) ? $_POST['quantity'] : "Not set") . "<br/>";

// Validate that user is logged in and product ID and quantity are received
if (!isset($_SESSION['user_email'])) {
    die("Buyer not logged in.");
}

if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    die("No product selected or quantity provided for ordering.");
}

$userEmail = $_SESSION['user_email'];
$productId = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

// Fetch product details
$productQuery = "SELECT product_name, product_description, product_price, farmer_email FROM productsnew WHERE id = ?";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param("i", $productId);
$stmt->execute();
$productResult = $stmt->get_result();
if ($product = $productResult->fetch_assoc()) {
    // Calculate total cost based on quantity and product price
    $totalCost = $quantity * $product['product_price'];

    // Fetch customer name
    $customerQuery = "SELECT name FROM buyer_tablenew WHERE email = ?";
    $stmt = $conn->prepare($customerQuery);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $customerResult = $stmt->get_result();
    if ($customer = $customerResult->fetch_assoc()) {
        // Prepare to insert order into new_orders
        $insertQuery = "INSERT INTO new_orders (product_name, product_description, product_price, farmer_email, customer_name, status, quantity, total_cost) VALUES (?, ?, ?, ?, ?, 'pending', ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssdssdi", $product['product_name'], $product['product_description'], $product['product_price'], $product['farmer_email'], $customer['name'], $quantity, $totalCost);
        
        // Execute the insertion and handle the result
        if ($stmt->execute()) {
            // Product is successfully ordered; remove it from the cart
            if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
            echo "<script>alert('Order has been received. It is now being processed and feedback will be given.'); window.location.href='indexloggedin.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Customer not found.";
    }
} else {
    echo "Product not found.";
}

$stmt->close();
$conn->close();
?>
