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


// Fetch all buyers from the buyer_table
$select_sql = "SELECT * FROM buyer_tablenew";
$result = mysqli_query($conn, $select_sql);

// Check if there are buyers
if ($result && mysqli_num_rows($result) > 0) {
    $buyers = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $buyers = []; // Empty array if there are no buyers
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmersadmin.css"> <!-- Include your admin stylesheet -->
    <title>Buyers Page</title>
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
        <h2>Buyers</h2>
        <?php
        // Display an error message if there was an issue fetching buyers
        if (empty($buyers)) {
            echo "<p>No buyers found.</p>";
        } else {
            // Display the table of buyers
            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Phone Number</th>";
            echo "<th>Identity Card</th>";
            echo "<th>KRA PIN</th>";
            echo "<th>Photo Path</th>";
            // Add additional columns as needed
            echo "<th>Action</th>";
            echo "</tr>";
            foreach ($buyers as $buyer) {
                echo "<tr>";
                echo "<td>{$buyer['id']}</td>";
                echo "<td>{$buyer['name']}</td>";
                echo "<td>{$buyer['email']}</td>";
                echo "<td>{$buyer['phone_number']}</td>";
                echo "<td>{$buyer['identity_card']}</td>";
                echo "<td>{$buyer['kra_pin']}</td>";
                echo "<td><img src='{$buyer['photo_path']}' alt='Buyer Photo' style='width: 100px;'></td>";
                // Output additional columns here
                echo "<td>";
                echo "<a href='edit_buyer.php?id={$buyer['id']}'>Edit</a> | ";
                echo "<a href='#' class='delete-link' data-id='{$buyer['id']}'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
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

<script>
    // JavaScript to show confirmation dialog for delete action
    document.addEventListener('DOMContentLoaded', function () {
        var deleteLinks = document.getElementsByClassName('delete-link');
        
        Array.prototype.forEach.call(deleteLinks, function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // Show confirmation dialog
                var result = confirm("Are you sure you want to delete this buyer?");

                // If user confirms, proceed with deletion
                if (result) {
                    var buyerId = link.getAttribute('data-id');
                    window.location.href = 'delete_buyer.php?id=' + buyerId;
                }
            });
        });
    });
</script>
