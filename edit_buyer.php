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

// Fetch buyer details based on the ID
$select_sql = "SELECT * FROM buyer_tablenew WHERE id = $buyer_id";
$result = mysqli_query($conn, $select_sql);

// Check if the buyer exists
if ($result && mysqli_num_rows($result) > 0) {
    $buyer = mysqli_fetch_assoc($result);
} else {
    header("Location: buyers.php"); // Redirect if buyer not found
    exit();
}

// Check if the form is submitted for updating buyer details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_name = $_POST["new_name"];
    $new_email = $_POST["new_email"];
    $new_phone_number = $_POST["new_phone_number"];

    // Update the buyer details in the database
    $update_sql = "UPDATE buyer_tablenew SET name = '$new_name', email = '$new_email', phone_number = '$new_phone_number' WHERE id = $buyer_id";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        // Redirect to the buyers page after successful update
        header("Location: buyeradmin.php");
        exit();
    } else {
        $error_message = "Error updating buyer details: " . mysqli_error($conn);
        // You can handle the error as needed
    }
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
    <title>Edit Buyer</title>
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
        <h2>Edit Buyer</h2>
        <form method="post" action="">
            <label for="new_name">New Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo $buyer['name']; ?>" required>

            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="new_email" value="<?php echo $buyer['email']; ?>" required>

            <label for="new_phone_number">New Phone Number:</label>
            <input type="text" id="new_phone_number" name="new_phone_number" value="<?php echo $buyer['phone_number']; ?>" required>

            <button type="submit">Update Buyer</button>
        </form>
        <?php
            // Display error message if there was an error during update
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
        ?>
    </div>

</body>
</html>
