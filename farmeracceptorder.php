<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_email"]) || $_SESSION["user_type"] !== "Farmer") {
    header("Location: login.php");
    exit;
}

// Redirects to farmer_orders.php if no order ID is provided
if (!isset($_GET['order_id']) && !isset($_POST['order_id'])) {
    header("Location: farmer_orders.php");
    exit;
}

$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $_GET['order_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status']; // Assuming 'approved' or 'not approved' values
    $feedback = $_POST['feedback']; // Assuming feedback is now a part of your table

    $updateQuery = "UPDATE new_orders SET status = ?, feedback = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $status, $feedback, $order_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: farmer_orders.php");
        exit;
    } else {
        echo "Error updating order: " . $conn->error;
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmeracceptorder.css">
    <title>Accept/Decline order - Agro Connect</title>

    <style>
       footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
    margin-top: 10px; /* Add margin at the bottom */
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

h2 {
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
textarea,
select {
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
    font-size: 16px;
}

textarea {
    height: 100px;
    resize: vertical;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    margin-top: 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
header {
    background-color: #4CAF50;
    padding: 15px;
    color: white;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 1.5em;
    font-weight: bold;
}

.nav-links {
    list-style: none;
    display: flex;
}

.nav-links li {
    margin-right: 20px;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: color 0.3s; /* Add transition for a smooth color change */
}

.nav-links a:hover {
    color: black; /* Change the color on hover */
}
/* Add the following styles for the logo */
.logo a {
            color: white;
            text-decoration: none;
        }

        .logo a:hover {
            color: white; /* You can customize the hover color if needed */
        }
    </style>
</head>
<body>


<header>
        <nav>
            <div class="logo"><a href="index.php">Agro Connect</a></div>
            <ul class="nav-links">
                <li><a href="farmerdashboard2.php">Home</a></li>
                <li><a href="farmermyproducts.php">My Products</a></li>
                <li><a href="farmer_orders.php">My Orders</a></li>
            </ul>
            <?php
                if (isset($_SESSION["user_email"])) {
                    echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                    echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
                }
            ?>
        </nav>
    </header>

    <div class="container">
        <h2>Update Order</h2>
        <form action="farmeracceptorder.php" method="post"> <!-- Corrected form action -->
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="approved">Approved</option>
                <option value="not approved">Not Approved</option>
            </select>
            <br>
            <label for="feedback">Feedback:</label>
            <textarea name="feedback" id="feedback"></textarea>
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>
    
    <footer>
        <p>&copy; 2023 Agro Connect. All rights reserved.</p>
    </footer>

</body>
</html>
