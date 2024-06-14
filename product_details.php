<?php
session_start();

// Check if the user is logged in
    $isLoggedIn = isset($_SESSION["user_email"]);

// Replace the following with your actual database connection details
$servername = "localhost";
$username = "agroconnect_user";
$password = "your_password";
$dbname = "agroconnect_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the product details based on the id from the URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    $query = "SELECT * FROM productsnew WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Display the product details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="product_details.css"> <!-- Create a CSS file for styling product details -->
    <title><?php echo $product['product_name']; ?> Details</title>

    <style>
        /* Add the following styles for the logo */
        .logo a {
            color: white;
            text-decoration: none;
        }

        .logo a:hover {
            color: white; /* You can customize the hover color if needed */
        }

        /* Add a class to hide the pop-up initially */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .dot-container {
            text-align: center;
            margin-top: 20px; /* Adjust the margin as needed */
        }

        .dot {
            height: 15px;
            width: 15px;
            margin: 0 5px; /* Adjust the margin as needed */
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
            cursor: pointer;
        }

        .dot.active {
            background-color: #717171;
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

<header>
        <nav>
            <div class="logo"><a href="index.php">Agro Connect</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="indexloggedin.php">Products</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contactus.php">Contact us</a></li>

                
            </ul>
            
            <?php
            // Display additional user information if logged in
            if ($isLoggedIn) {
                echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
            }
            ?>
        </nav>
    </header>

    <section class="product-details-section">
        <h2><?php echo $product['product_name']; ?> Details</h2>

        <div class="product-details">
    <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['product_name']; ?>" />
    <p><?php echo $product['product_description']; ?></p>
    <p>Price: <?php echo $product['product_price']; ?></p>
    <a href='addtocart.php?id=<?php echo $product['id']; ?>' class='add-to-cart-btn'>Add to Cart</a>
    <!-- Include other relevant details as needed -->
</div>

    </section>

    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

</body>
</html>
<?php
    } else {
        // Handle the case where the product was not found
        echo "Product not found!";
    }
} else {
    // Handle the case where no id is provided
    echo "Invalid product ID!";
}

// Close the database connection
mysqli_close($conn);
?>
