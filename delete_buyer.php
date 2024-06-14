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

// Check if the buyer ID is provided in the URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: buyers.php"); // Redirect if ID is not provided
    exit();
}

$buyer_id = $_GET["id"];

// Delete the buyer from the database
$delete_sql = "DELETE FROM buyer_tablenew WHERE id = $buyer_id";
$delete_result = mysqli_query($conn, $delete_sql);

// Redirect to the buyers page after deletion
if ($delete_result) {
    header("Location: buyeradmin.php");
    exit();
} else {
    $error_message = "Error deleting buyer: " . mysqli_error($conn);
    // You can handle the error as needed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmersadmin.css"> <!-- Include your admin stylesheet -->
    <title>Delete Buyer</title>
</head>
<body>

    <header>
        <nav>
            <div class="logo"><a href="index.php">Agro Connect</a></div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="farmers.php">Farmers</a></li>
                <li><a href="buyers.php">Buyers</a></li>
                <li><a href="products.php">Products</a></li>
                <!-- Add more links as needed -->
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

    <div class="dashboard-container">
        <h2>Delete Buyer</h2>
        <?php
            // Display error message if there was an error during deletion
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
        ?>
        <p>Are you sure you want to delete this buyer?</p>
        <form method="post" action="">
            <button type="submit">Yes, Delete</button>
            <a href="buyeradmin.php">Cancel</a>
        </form>
    </div>

</body>
</html>
