<?php
session_start();
include("db_connect.php"); // Assuming this file sets up the $conn variable with a database connection

// Identify the current page
$current_page = basename($_SERVER['PHP_SELF']);

// Check if the user is logged in and is a farmer
if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Farmer") {
    header("Location: login.php"); // Redirect to login page
    exit;
}

$farmerEmail = $_SESSION['user_email']; // Use the email from the session

// After successful login, check for new orders
// Check if the user is a farmer
if ($_SESSION["user_type"] === "Farmer") {
    // Check for new orders
    $sql = "SELECT COUNT(*) AS new_orders_count FROM new_orders WHERE farmer_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["user_email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $newOrdersCount = $row["new_orders_count"];

    // If there are new orders, set a session variable to indicate this
    if ($newOrdersCount > 0) {
        $_SESSION["new_orders_notification"] = true;
    }
}

// Check if there's a new orders notification in the session
if (isset($_SESSION["new_orders_notification"]) && $_SESSION["new_orders_notification"]) {
    echo "<script>alert('You have new orders!');</script>";
    // Clear the new orders notification flag
    unset($_SESSION["new_orders_notification"]);
}


// Original SQL statement, now including quantity and total cost
$sql = "SELECT id, product_name, product_description, product_price, customer_name, status, quantity, total_cost, phone_number FROM new_orders WHERE farmer_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $farmerEmail);
$stmt->execute();
$result = $stmt->get_result();

// Start HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmer_orders.css">
    <title>Orders - Agro Connect</title>

    <style>
        .accept-btn, .decline-btn {
    /* Button-like styling */
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
}

.accept-btn {
    background-color: #28a745; /* Green background */
}

.decline-btn {
    background-color: #dc3545; /* Red background */
}

.accept-btn:hover, .decline-btn:hover {
    opacity: 0.8;
}
.update-btn {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    color: white;
    background-color: #f0ad4e; /* Bootstrap warning color for example */
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
}

.update-btn:hover {
    opacity: 0.8;
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
                if (isset($_SESSION["user_email"])) {
                    echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                    echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
                }
            ?>
        </nav>
    </header>
    <button onclick="toggleDarkMode()">Toggle Dark Mode</button>

    <div class="order-list">
        <table>
            <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th> <!-- New header for quantity -->
            <th>Total Cost</th> <!-- New header for total cost -->
            <th>Customer Name</th>
            <th>Status</th>
            <th>Actions</th>
            <th>Phone number</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
echo "<td>" . htmlspecialchars($row['id']) . "</td>";
echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
echo "<td>" . htmlspecialchars($row['product_description']) . "</td>";
echo "<td>" . htmlspecialchars($row['product_price']) . "</td>";
echo "<td>" . htmlspecialchars($row['quantity']) . "</td>"; // New cell for quantity
echo "<td>" . htmlspecialchars($row['total_cost']) . "</td>"; // New cell for total cost
echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
echo "<td>" . htmlspecialchars($row['status']) . "</td>";

echo "<td>";
echo "<a href='farmeracceptorder.php?order_id=" . htmlspecialchars($row['id']) . "' class='update-btn'>Update</a>";
echo "</td>";
echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No orders found.</td></tr>";
            }
            ?>
        </table>
    </div>

    <script>
    function acceptOrder(orderId) {
        // Implement the logic to accept the order
        console.log("Accepting order: " + orderId);
        // Redirect to a PHP script or use AJAX to process the acceptance
    }

    function declineOrder(orderId) {
        // Implement the logic to decline the order
        console.log("Declining order: " + orderId);
        // Redirect to a PHP script or use AJAX to process the decline
    }
    </script>


    

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
<?php
$conn->close();
?>
