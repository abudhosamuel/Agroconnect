<?php
session_start();
$isLoggedIn = isset($_SESSION["user_email"]);
// Define the current page
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title>Your Cart</title>

    <style>
        /* Add the following styles for the logo */
    .logo a {
        color: white;
        text-decoration: none;
        display: flex; /* Use flexbox to align image and text side by side */
        align-items: center; /* Center items vertically */
        gap: 10px; /* Creates a small space between the image and the text */
    }

    .logo a img {
        width: 80px; /* Adjust the width as needed */
        height: auto; /* Maintain aspect ratio */
    }

    .logo a span {
        font-size: 1.5em; /* Adjust the font size as needed */
        font-weight: bold; /* Makes the text bold */
        color: #ffffff; /* Adjust the text color as needed, white is used here for contrast */
    }

    .logo a:hover {
        color: white; /* Maintains the text color on hover */
    }

    /* Add the following styles for the logo */
    nav {
        display: flex; /* Use flexbox for the navbar */
        justify-content: space-between; /* This will move the links to the right */
        align-items: center; /* This will keep everything vertically aligned */
    }

    .nav-links {
        display: flex; /* Use flexbox for the navigation links */
        justify-content: flex-end; /* Aligns links to the end (right side) */
        list-style-type: none; /* Removes bullet points from the list */
        gap: 16px; /* Adds space between each link */
    }

    .nav-links li {
        padding: 0; /* Resets padding if needed */
    }

    .nav-links a {
        text-decoration: none; /* Removes underline from links */
        color: white; /* Sets color to white, adjust as needed */
        padding: 0.5em; /* Adds padding around the links for better clickability */
    }

    .nav-links a:hover {
        text-decoration: underline; /* Adds underline on hover for visual feedback */
    }

    .nav-links a.active {
    text-decoration: underline;
}

    /* Additional styles for responsiveness if necessary */
    @media (max-width: 768px) {
        .nav-links {
            flex-direction: column; /* Stack links vertically on smaller screens */
            align-items: flex-end; /* Aligns links to the end (right side) */
        }
    }



        /* Add your CSS styling here */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }

        .cart-image {
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }

        .cart-info {
            flex-grow: 1;
            padding-left: 20px;
        }

       
        .cart-buttons {
    display: flex;
    flex-direction: row;
    align-items: flex-end; /* Align items to the end (bottom) of the container */
    justify-content: flex-start; /* Aligns items to the start of the main axis */
    gap: 10px; /* Adds space between the two buttons */
}

.cart-button {
    padding: 10px;
    margin-bottom: 5px; /* Ensure consistent bottom margin */
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: auto;
    min-width: 100px;
    box-sizing: border-box;
    text-align: center;
    font-size: 0.9em;
}

.cart-button.remove {
    background-color: #f44336;
}

/* Remove top margin to ensure buttons align at the bottom */
.cart-buttons form {
    margin-top: 0; /* Remove top margin from forms */
}

.quantity {
    display: flex;
    align-items: center;
    margin-bottom: auto; /* Pushes everything below to the bottom */
}

.quantity input {
    width: 50px;
    text-align: center;
    margin: 0 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.quantity button {
    padding: 5px 10px;
    border: none;
    background-color: #4CAF50;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

.quantity button:hover {
    background-color: #45a049;
}

.total-price {
    margin-top: 10px;
    font-weight: bold;
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

    </style>
</head>
<body>


<header>
    <nav>
    <div class="logo">
    <a href="index.php">
        <img src="logo1.png" alt="Agro Connect Logo">
        <span>AgroConnect</span>
    </a>
</div>
        </div>
        <ul class="nav-links">
                <li><a href="index.php" class="<?php echo ($currentPage == 'index') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="indexloggedin.php" class="<?php echo ($currentPage == 'indexloggedin') ? 'active' : ''; ?>">Products</a></li>
                <li><a href="aboutus.php" class="<?php echo ($currentPage == 'aboutus') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="contactus.php" class="<?php echo ($currentPage == 'contactus') ? 'active' : ''; ?>">Contact us</a></li>
                <li><a href="cart.php" class="<?php echo ($currentPage == 'cart') ? 'active' : ''; ?>">View cart</a></li>
                <li><a href="buyer_orders.php" class="<?php echo ($currentPage == 'buyer_orders') ? 'active' : ''; ?>">My orders</a></li>
            </ul>

        <?php
        if ($isLoggedIn) {
            echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
            echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
        }
        ?>
    </nav>
</header>
<button onclick="toggleDarkMode()">Toggle Dark Mode</button>

<div class="container">
    <h1>Your Shopping Cart</h1>
    <?php
    $servername = "localhost";
    $username = "agroconnect_user";
    $password = "your_password";
    $dbname = "agroconnect_db";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    } else {
        foreach ($_SESSION['cart'] as $id) {
            $sql = "SELECT * FROM productsnew WHERE id = $id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                   // Inside the loop that displays cart items
echo "<div class='cart-item'>";
echo "<img class='cart-image' src='{$row['image_path']}' alt='{$row['product_name']}' />";
echo "<div class='cart-info'>";
echo "<h3>{$row['product_name']}</h3>";
echo "<p>{$row['product_description']}</p>";
echo "<p>Price: {$row['product_price']}</p>";
echo "</div>";

// Updated form with quantity input included
echo "<form action='makeorder.php' method='post' class='order-form'>";
echo "<div class='quantity'>";
echo "<span>Quantity</span>";
echo "<button type='button' onclick='decreaseQuantity(this)'>&minus;</button>";
echo "<input type='number' name='quantity' min='1' value='1' required />";
echo "<button type='button' onclick='increaseQuantity(this)'>&plus;</button>";
echo "</div>";
echo "<p>Total: <span class='total-price'>{$row['product_price']}</span></p>";

// Hidden input for product_id within the same form as the quantity
echo "<input type='hidden' name='product_id' value='{$id}' />";
echo "<input type='submit' class='cart-button' value='Make Order'>";
echo "</form>";
echo "<div class='cart-buttons'>";
echo "<form action='remove_from_cart.php' method='post'>";
echo "<input type='hidden' name='product_id' value='{$id}' />";
echo "<input type='submit' class='cart-button remove' value='Remove from Cart'>";
echo "</form>";
echo "</div>"; // Close cart-buttons div
echo "</div>"; // Close cart-item div
                    
                   

                    echo "</div>";

                    
                }
            }
        }
    }

    mysqli_close($conn);
    ?>
</div>

<footer>
    <p>&copy; 2024 Agro Connect. All rights reserved.</p>
</footer>

<script>
    function increaseQuantity(button) {
        var inputField = button.closest('.quantity').querySelector('input[type="number"]');
        var currentValue = parseInt(inputField.value);
        inputField.value = currentValue + 1;
        updateTotal(inputField);
    }

    function decreaseQuantity(button) {
        var inputField = button.closest('.quantity').querySelector('input[type="number"]');
        var currentValue = parseInt(inputField.value);
        if (currentValue > 1) {
            inputField.value = currentValue - 1;
            updateTotal(inputField);
        }
    }

    function updateTotal(input) {
        var quantity = parseInt(input.value);
        // Find the price element. Make sure to adjust the selector if your HTML structure changes.
        var priceElement = input.closest('.cart-item').querySelector('.cart-info p:nth-child(3)');
        // Extract the numeric value from the price text.
        var pricePerItem = parseFloat(priceElement.textContent.match(/[\d,.]+/)[0].replace(/,/g, ''));
        var total = quantity * pricePerItem;
        // Update the total price in the corresponding element.
        var totalElement = input.closest('.cart-item').querySelector('.total-price');
        totalElement.textContent = "Kshs " + total.toFixed(2);
    }
</script>

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
</script>

</body>
</html>
