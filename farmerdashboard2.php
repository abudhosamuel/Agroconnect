<?php
session_start();

// Include the database connection file
include("db_connect.php");

// Identify the current page
$current_page = basename($_SERVER['PHP_SELF']);

// Initialize the product captured message
$product_captured_message = "";

// Check if the user is logged in and is a farmer
if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Farmer") {
    // Redirect to login page or another page
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_price = $_POST["product_price"];

    // Handle file upload
    $upload_dir = "uploads/"; // Directory to store uploaded images
    $uploaded_file = $upload_dir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $uploaded_file);
    $image_path = $uploaded_file;
    
    // Query to insert product information into the database
    $sql = "INSERT INTO productsnew (product_name, product_description, product_price, farmer_email, image_path)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $product_name, $product_description, $product_price, $_SESSION["user_email"], $image_path);

    // Check if the product is successfully inserted
    if ($stmt->execute()) {
        $product_captured_message = "Product captured!";
    } else {
        $product_captured_message = "Failed to capture the product. Please try again.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard2.css">
    <title>Online Farmers Marketplace</title>

    <style>
        /* Add the following styles for the logo */
        .logo a {
            color: white;
            text-decoration: none;
        }

        .logo a:hover {
            color: white; /* You can customize the hover color if needed */
        }

        /* Additional styles for the product captured message */
        .product-captured-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

        .nav-links a.active {
            text-decoration: underline;
        }

        /* Add CSS variables for light and dark mode */
        :root {
            --background-color-light: #ffffff; /* Light mode background color */
            --text-color-light: #000000; /* Light mode text color */
            --background-color-dark: #222222; /* Dark mode background color */
            --text-color-dark: #ffffff; /* Dark mode text color */
        }

        body {
            background-color: var(--background-color-light);
            color: var(--text-color-light);
        }

        .dark-mode {
            background-color: var(--background-color-dark);
            color: var(--text-color-dark);
        }

        /* Styles for the logo */
        .logo a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }

        .logo a img {
            width: 80px;
            height: auto;
        }

        .logo a span {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffffff;
        }

        .logo a:hover {
            color: white;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <a href="index.php">
                <img src="logo1.png" alt="Agro Connect Logo">
                <span>Agro Connect</span>
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="farmerdashboard2.php" class="<?= ($current_page == 'farmerdashboard2.php') ? 'active' : '' ?>">Home</a></li>
            <li><a href="farmermyproducts.php" class="<?= ($current_page == 'farmermyproducts.php') ? 'active' : '' ?>">My Products</a></li>
            <li><a href="farmer_orders.php" class="<?= ($current_page == 'farmer_orders.php') ? 'active' : '' ?>">Orders</a></li>
        </ul>
        <?php
            // Check if the user is logged in
            if (isset($_SESSION["user_email"])) {
                // Display the welcome message with the user's name
                echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                // Display the logout link
                echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
            }
        ?>
    </nav>
</header>
<button onclick="toggleDarkMode()">Toggle Dark Mode</button>

<div class="dashboard-container">
    <h2>Farmer Dashboard</h2>
    <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateProductName()">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" pattern="[A-Za-z\s]+" title="Product name should only contain letters and spaces." required>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" rows="4" required></textarea>

        <label for="product_price">Product Price:</label>
        <input type="number" id="product_price" name="product_price" step="0.01" required>

        <!-- Add the input field for file uploads -->
        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image" accept="image/*" required>

        <button type="submit">Upload Product</button>
    </form>
    <?php
    // Display product captured message if set
    if (!empty($product_captured_message)) {
        echo "<p class='product-captured-message'>$product_captured_message</p>";
    }
    ?>

    <!-- You can display additional information or products uploaded by the farmer here -->
</div>

<footer>
    <p>&copy; 2024 Agro Connect. All rights reserved.</p>
</footer>

<script>
const toggleDarkMode = () => {
    const body = document.body;
    body.classList.toggle('dark-mode');

    // Store user preference in localStorage
    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
}

// Check user preference on page load
const initializeDarkMode = () => {
    const body = document.body;
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        body.classList.add('dark-mode');
    }
}

// Initialize dark mode
initializeDarkMode();

const validateProductName = () => {
    const productName = document.getElementById('product_name').value;
    const pattern = /^[A-Za-z\s]+$/;
    if (!pattern.test(productName)) {
        alert('Product name should only contain letters and spaces.');
        return false;
    }
    return true;
}
</script>

</body>
</html>
