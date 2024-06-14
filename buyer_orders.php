<?php
session_start();
include("db_connect.php");

// Define the current page
$currentPage = basename($_SERVER['PHP_SELF'], '.php');

if (!isset($_SESSION["user_email"]) || $_SESSION["user_type"] !== "Buyer") {
    header("Location: login.php");
    exit;
}

// Assuming user_name is stored in the session upon login. If not, adjust accordingly.
$buyerName = $_SESSION["user_name"];

$query = "SELECT new_orders.*, farmer_tablenew.driver_name 
          FROM new_orders 
          LEFT JOIN farmer_tablenew ON new_orders.farmer_email = farmer_tablenew.email
          WHERE customer_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $buyerName);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="buyer_orders.css"> <!-- Update the path to your CSS file -->
    <!-- Add inline CSS or link to an external CSS file -->
    <style>
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
            background-color: #f2f2f2;
        }
        
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
<body id="<?php echo $currentPage; ?>">
<header>
    <nav>
        <div class="logo">
            <a href="index.php">
                <img src="logo1.png" alt="Agro Connect Logo">
                <span>AgroConnect</span>
            </a>
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
        // Check if the user is logged in
        $isLoggedIn = isset($_SESSION["user_email"]);
        // Display additional user information if logged in
        if ($isLoggedIn) {
            echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
            echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
        }
        ?>
    </nav>
</header>
<button onclick="toggleDarkMode()">Toggle Dark Mode</button>

<h2>My Orders</h2>
<table>
    <tr>
        <th>Order ID</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Quantity</th> <!-- New header for quantity -->
        <th>Total Price</th> <!-- New header for total price -->
        <th>Status</th>
        <th>Feedback</th>
        <th>Driver Name</th> <!-- Existing column for driver's name -->
    </tr>

    <?php if ($result->num_rows === 0): ?>
        <tr>
            <td colspan="9">No orders made</td>
        </tr>
    <?php else: ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['product_description']); ?></td>
                <td><?php echo htmlspecialchars($row['product_price']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td> <!-- Data cell for quantity -->
                <td><?php echo htmlspecialchars($row['total_cost']); ?></td> <!-- Data cell for total price -->
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['feedback']); ?></td>
                <td><?php echo htmlspecialchars($row['driver_name']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</table>

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
