<?php
// Include the database connection file
include("db_connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product details from the form
    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_price = $_POST["product_price"];

    // Update the product in the database
    $sql = "UPDATE productsnew SET
            product_name = '$product_name',
            product_description = '$product_description',
            product_price = '$product_price'
            WHERE id = $product_id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Product update successful, redirect to admin_products.php
        header("Location: products_admin.php");
        exit();
    } else {
        // Product update failed, handle accordingly
        $error_message = "Product update failed. Error: " . mysqli_error($conn);
    }
} else {
    // Retrieve the product ID from the URL
    $product_id = $_GET["id"];

    // Fetch product details from the database
    $sql = "SELECT * FROM productsnew WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    // Fetch product as an associative array
    $product = mysqli_fetch_assoc($result);

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmersadmin.css">
    <title>Edit Product</title>
</head>
<body>

    <header>
        <nav>
            <div class="logo"><a href="index.php">Agro Connect</a></div>
            <ul class="nav-links">
                <li><a href="admin_home.php">Home</a></li>
                <li><a href="admin_farmers.php">Farmers</a></li>
                <li><a href="admin_buyers.php">Buyers</a></li>
                <li><a href="admin_products.php">Products</a></li>
            </ul>
            <?php
                // Check if the user is logged in
                session_start();
                if (isset($_SESSION["user_email"])) {
                    // Display the welcome message with the user's name
                    echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                    // Display the logout link
                    echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
                }
            ?>
        </nav>
    </header>

    <div class="dashboard-container">
        <h2>Edit Product</h2>

        <?php
        // Display error message if there is any
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <form method="post" action="">
            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">

            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?= $product['product_name']; ?>" required>

            <label for="product_description">Product Description:</label>
            <textarea id="product_description" name="product_description" required><?= $product['product_description']; ?></textarea>

            <label for="product_price">Product Price:</label>
            <input type="text" id="product_price" name="product_price" value="<?= $product['product_price']; ?>" required>

            <button type="submit">Update Product</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

</body>
</html>
