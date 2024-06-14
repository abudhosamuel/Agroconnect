<?php
session_start();

// Include the database connection file
include("db_connect.php");

// Check if the user is logged in and is an administrator
if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    // Redirect to login page or another page
    header("Location: login.php");
    exit();
}

// Identify the current page
$current_page = basename($_SERVER['PHP_SELF']);


// Fetch orders from the new_orders table
$sql = "SELECT * FROM new_orders";
$result = mysqli_query($conn, $sql);

// Check if there are any orders
if (mysqli_num_rows($result) > 0) {
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="orders_admin.css">
    <title>Orders - Admin</title>
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
        .container {
    margin: 20px auto;
    width: 80%;
    margin-bottom: 100px; /* Add margin-bottom to create space for the footer */
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
            // Display the welcome message and logout link
            if (isset($_SESSION["user_email"])) {
                echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
            }
            ?>
        </nav>
    </header>
    <button onclick="toggleDarkMode()">Toggle Dark Mode</button>

    <div class="container">
        <h1>Orders</h1>
        <?php if (!empty($orders)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Product Price</th>
                    <th>Farmer Email</th>
                    <th>Customer Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Phone number</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['product_name']; ?></td>
                    <td><?php echo $order['product_description']; ?></td>
                    <td><?php echo $order['product_price']; ?></td>
                    <td><?php echo $order['farmer_email']; ?></td>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td><?php echo $order['status']; ?></td>

                    <td>
                    <a href="edit_orderforadmin.php?id=<?php echo $order['id']; ?>">Edit</a>
                    <a href="delete_orderforadmin.php?id=<?php echo $order['id']; ?>">Delete</a>
                    </td>
                    <td><?php echo $order['phone_number']; ?></td>


                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
        <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <footer>
        &copy; 2024 Agro Connect. All rights reserved.
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
</script>
</body>
</html>