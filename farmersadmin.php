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


// Fetch data from the farmer_table
$sql = "SELECT * FROM farmer_tablenew";
$result = mysqli_query($conn, $sql);

// Check if there are rows in the result
if (mysqli_num_rows($result) > 0) {
    // Output data in a table
    $farmers = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $farmers = [];
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmersadmin.css">
    <title>Farmers Page</title>
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

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #4CAF50;
            padding: 15px;
            color: white;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
    <h2>Farmers</h2>
    <?php if (!empty($farmers)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>User Type</th>
                    <th>Identity Card</th>
                    <th>KRA PIN</th>
                    <th>Photo Path</th>
                    <th>Driver Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($farmers as $farmer): ?>
                    <tr>
                        <td><?= $farmer['id']; ?></td>
                        <td><?= $farmer['name']; ?></td>
                        <td><?= $farmer['email']; ?></td>
                        <td><?= $farmer['phone_number']; ?></td>
                        <td><?= $farmer['user_type']; ?></td>
                        <td><?= $farmer['identity_card']; ?></td>
                        <td><?= $farmer['kra_pin']; ?></td>
                        <td><img src="<?= $farmer['photo_path']; ?>" alt="Photo" style="max-width: 50px;"></td>
                        <td><?= $farmer['driver_name']; ?></td>
                        <td><a href='edit_farmer.php?id=<?= $farmer['id']; ?>'>Edit</a></td>
                        <td><a href='delete_farmer.php?id=<?= $farmer['id']; ?>'>Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No farmers found in the database.</p>
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
