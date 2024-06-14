<?php
session_start();
include("db_connect.php");

// Identify the current page
$current_page = basename($_SERVER['PHP_SELF']);

// Check if the user is logged in and is a farmer
if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Farmer") {
    // Redirect to login page or another page
    header("Location: login.php");
    exit();
}

// Fetch products added by the logged-in farmer from the new products table
$sql = "SELECT * FROM productsnew WHERE farmer_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["user_email"]);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmermyproducts.css">
    <title>My Products - Agro Connect</title>

    <style>
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
                if (isset($_SESSION["user_email"])) {
                    echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                    echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
                }
            ?>
        </nav>
    </header>
    <button onclick="toggleDarkMode()">Toggle Dark Mode</button>

    <div class="dashboard-container">
        <h2>My Products</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['product_description'] . "</td>";
                    echo "<td>" . $row['product_price'] . "</td>";
                    echo "<td><img src='" . $row['image_path'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
                    echo "<td><a href='editfarmersproducts.php?id=" . $row['id'] . "'>Edit</a> | <a href='deletefarmerproducts.php?id=" . $row['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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
</script>

</body>
</html>
