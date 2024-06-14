<?php
session_start();

include("db_connect.php");

if (!isset($_SESSION["user_email"]) || $_SESSION["user_type"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Identify the current page
$current_page = basename($_SERVER['PHP_SELF']);


$sql = "SELECT * FROM newusers";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = [];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Users Page</title>
    <link rel="stylesheet" href="newusersadmin.css">
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
            font-family: 'Arial', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50; /* Changed to green */
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
        <h2>New Users</h2>
        <button onclick="location.href='add_u ser.php'">Add New User</button>
        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Phone Number</th>
                        <th>User Type</th>
                        <th>Id Number</th>
                        <th>KRA Pin</th>
                        <th>Photo</th>
                        <th>Driver Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['name']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['password']); ?></td> <!-- Consider masking or not showing this -->
                            <td><?= htmlspecialchars($user['phone_number']); ?></td>
                            <td><?= htmlspecialchars($user['user_type']); ?></td>
                            <td><?= htmlspecialchars($user['identity_card']); ?></td>
                            <td><?= htmlspecialchars($user['kra_pin']); ?></td>
                            <td>
                <?php if (!empty($user['photo_path'])): ?>
                    <img src="<?= htmlspecialchars($user['photo_path']); ?>" alt="User Photo" style="max-width: 100px;">
                <?php else: ?>
                    No photo available
                <?php endif; ?>
            </td>
                            <td><?= htmlspecialchars($user['driver_name']); ?></td>
                            <td>
    <form action="action_page.php" method="post">
        <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
        <input type="hidden" name="user_type" value="<?= $user['user_type']; ?>"> <!-- Add hidden input for user_type -->
        <button type="submit" name="add_user">Add User</button>
        <button type="submit" name="delete_user" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No new users found.</p>
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
