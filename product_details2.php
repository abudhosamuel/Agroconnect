<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        /* Add your CSS styling here */
        body {
            font-family: 'Arial', sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .product-details {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }
        .product-image {
            width: 300px;
            height: 300px;
            margin-right: 20px;
        }
        .product-info {
            flex-grow: 1;
        }
        .add-to-cart-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-to-cart-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Database connection details
        $servername = "localhost";
                $username = "agroconnect_user";
                $password = "your_password";
                $dbname = "agroconnect_db";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // SQL to fetch product details
        $sql = "SELECT * FROM productsnew WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-details'>";
                echo "<img class='product-image' src='{$row['image_path']}' alt='{$row['name']}' />";
                echo "<div class='product-info'>";
                echo "<h2>{$row['name']}</h2>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Price: {$row['price']}</p>";
                echo "<a href='add_to_cart.php?id={$row['id']}' class='add-to-cart-btn'>Add to Cart</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Product not found";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
