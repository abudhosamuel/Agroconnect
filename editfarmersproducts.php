<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Farmer") {
    header("Location: login.php");
    exit();
}

// Fetch product details for the specified ID
if (isset($_GET["id"])) {
    $stmt = $conn->prepare("SELECT * FROM productsnew WHERE id = ? AND farmer_email = ?");
    $stmt->bind_param("is", $_GET["id"], $_SESSION["user_email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Check if the product exists
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        header("Location: farmermyproducts.php");
        exit();
    }
} else {
    header("Location: farmermyproducts.php");
    exit();
}

// Handle form submission to update the product in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_product_name = $_POST["product_name"];
    $new_product_description = $_POST["product_description"];
    $new_product_price = $_POST["product_price"];

    // Retrieve existing product details including image_path
    $stmt = $conn->prepare("SELECT image_path FROM productsnew WHERE id = ? AND farmer_email = ?");
    $stmt->bind_param("is", $_GET["id"], $_SESSION["user_email"]);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($existing_image_path);
        $stmt->fetch();
        $stmt->close();

        // Check if a new image file is uploaded
        if ($_FILES["product_image"]["error"] == UPLOAD_ERR_OK) {
            // Remove the existing image file
            if ($existing_image_path && file_exists($existing_image_path)) {
                unlink($existing_image_path);
            }

            // Move the uploaded file to the server
            $new_image_path = "uploads/" . basename($_FILES["product_image"]["name"]);
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $new_image_path)) {
                // Update the database with the new values, including the new image_path
                $update_stmt = $conn->prepare("UPDATE productsnew SET product_name = ?, product_description = ?, product_price = ?, image_path = ? WHERE id = ? AND farmer_email = ?");
                $update_stmt->bind_param("ssdsis", $new_product_name, $new_product_description, $new_product_price, $new_image_path, $_GET["id"], $_SESSION["user_email"]);

                if ($update_stmt->execute()) {
                    header("Location: farmermyproducts.php");
                    exit();
                } else {
                    echo "Error updating the product: " . $update_stmt->error;
                }

                $update_stmt->close();
            } else {
                echo "Failed to move the uploaded file. Please try again.";
            }
        } else {
            // Update the database without changing the image_path
            $update_stmt = $conn->prepare("UPDATE productsnew SET product_name = ?, product_description = ?, product_price = ? WHERE id = ? AND farmer_email = ?");
            $update_stmt->bind_param("ssdis", $new_product_name, $new_product_description, $new_product_price, $_GET["id"], $_SESSION["user_email"]);

            if ($update_stmt->execute()) {
                header("Location: farmermyproducts.php");
                exit();
            } else {
                echo "Error updating the product: " . $update_stmt->error;
            }

            $update_stmt->close();
        }
    } else {
        header("Location: farmermyproducts.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmermyproducts.css">
    <title>Edit Product - Agro Connect</title>
</head>
<body>

<header>
    <nav>
        <div class="logo"><a href="index.php">Agro Connect</a></div>
        <ul class="nav-links">
            <li><a href="farmerdashboard2.php">Home</a></li>
            <li><a href="farmermyproducts.php">My Products</a></li>
        </ul>
        <?php
            if (isset($_SESSION["user_email"])) {
                echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
            }
        ?>
    </nav>
</header>

<div class="dashboard-container">
    <h2>Edit Product</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" rows="4" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>

        <label for="product_price">Product Price:</label>
        <input type="number" id="product_price" name="product_price" step="0.01" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>

        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image">

        <button type="submit">Save Changes</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 Agro Connect. All rights reserved.</p>
</footer>

</body>
</html>
