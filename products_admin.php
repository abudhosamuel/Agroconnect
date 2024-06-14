<?php
// Include the database connection file
include("db_connect.php");

// Identify the current page
$current_page = basename($_SERVER['PHP_SELF']);


// Fetch products data from the database
$sql = "SELECT * FROM productsnew";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Fetch products as an associative array
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmersadmin.css">
    <title>Administrator - Products</title>
    <style>
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
            <li><a href="admin2.php" class="<?= ($current_page == 'admin2.php') ? 'active' : '' ?>">Home</a></li>
            <li><a href="newusersadmin.php" class="<?= ($current_page == 'newusersadmin.php') ? 'active' : '' ?>">New Users</a></li>
            <li><a href="farmersadmin.php" class="<?= ($current_page == 'farmersadmin.php') ? 'active' : '' ?>">Farmers</a></li>
            <li><a href="buyeradmin.php" class="<?= ($current_page == 'buyeradmin.php') ? 'active' : '' ?>">Buyers</a></li>
            <li><a href="products_admin.php" class="<?= ($current_page == 'products_admin.php') ? 'active' : '' ?>">Products</a></li>
            <li><a href="orders_admin.php" class="<?= ($current_page == 'orders_admin.php') ? 'active' : '' ?>">Orders</a></li>
            <li><a href="adminqueries.php" class="<?= ($current_page == 'adminqueries.php') ? 'active' : '' ?>">Queries</a></li>
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
    <button onclick="toggleDarkMode()">Toggle Dark Mode</button>

    <div class="dashboard-container">
        <h2>Products</h2>
        
        <!-- Display the table of products -->
        <table>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Farmer Email</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_name']; ?></td>
                    <td><?= $product['product_description']; ?></td>
                    <td><?= $product['product_price']; ?></td>
                    <td><?= $product['farmer_email']; ?></td>
                    <td><img src="<?= $product['image_path']; ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                    <td><?= $product['created_at']; ?></td>
                    <td>
                        <a href='edit_productadmin.php?id=<?= $product['id']; ?>'>Edit</a> | 
                        <a href='#' class='delete-link' data-id='<?= $product['id']; ?>'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

    <!-- JavaScript for confirmation dialog on delete action -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteLinks = document.getElementsByClassName('delete-link');
            
            Array.prototype.forEach.call(deleteLinks, function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    // Show confirmation dialog
                    var result = confirm("Are you sure you want to delete this product?");

                    // If user confirms, proceed with deletion
                    if (result) {
                        var productId = link.getAttribute('data-id');
                        window.location.href = 'delete_productadmin.php?id=' + productId;
                    }
                });
            });
        });
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
