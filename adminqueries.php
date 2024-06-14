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

// Fetch contact messages from the database
$query = "SELECT id, name, email, message, created_at FROM contactus";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminqueries.css">
    <title>Queries</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

        /* Additional styles for the product captured message */
        .product-captured-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

        /* Styles for welcome message */
        .welcome-message {
            margin: 20px 0;
            text-align: center;
            font-size: 1.2em;
        }

        /* Styles for reports and analytics section */
        .reports-analytics {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Styles for dashboard */
        .dashboard {
            display: flex;
            justify-content: space-around;
            text-align: center;
            padding: 20px;
        }

        .dashboard .card {
            background-color: #4caf50;
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard .card h3 {
            margin: 0;
            font-size: 2em;
        }

        .dashboard .card p {
            margin: 10px 0 0;
            font-size: 1em;
        }

        /* Styles for summary header */
        .summary-header {
            text-align: center;
            margin: 20px 0;
            font-size: 1.5em;
            font-weight: bold;
        }

        /* Styles for the centered logo */
        .center-logo {
            display: block;
            margin: 20px auto;
            text-align: center;
        }

        .center-logo img {
            width: 150px;
            height: auto;
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
<main>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No messages found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

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
