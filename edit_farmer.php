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

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $farmer_id = $_GET['id'];

    // Fetch farmer data from the database based on the ID
    $sql = "SELECT * FROM farmer_tablenew WHERE id = $farmer_id";
    $result = mysqli_query($conn, $sql);

    // Check if there is a result
    if (mysqli_num_rows($result) > 0) {
        $farmer = mysqli_fetch_assoc($result);
    } else {
        // Redirect to the farmers page or show an error message
        header("Location: farmers.php");
        exit();
    }
} else {
    // Redirect to the farmers page if the ID is not provided
    header("Location: farmers.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_phone_number = $_POST['new_phone_number'];

    // Update farmer information in the database
    $update_sql = "UPDATE farmer_tablenew SET name = '$new_name', email = '$new_email', phone_number = '$new_phone_number' WHERE id = $farmer_id";
    $update_result = mysqli_query($conn, $update_sql);

    // Check if the update was successful
    if ($update_result) {
        // Redirect to the farmers page or another page
        header("Location: farmersadmin.php");
        exit();
    } else {
        // Handle the update error (e.g., display an error message)
        $error_message = "Failed to update farmer information.";
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
    <link rel="stylesheet" href="farmersadmin.css">
    <title>Edit Farmer</title>
    
</head>
<body>

    <header>
        
        <nav>
            <div class="logo"><a href="index.php">Agro Connect</a></div>
            <ul class="nav-links">
                <li><a href="">Home</a></li>
                <li><a href="">Farmers</a></li>
                <li><a href="">Buyers</a></li>
                <li><a href="">Products</a></li>
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

    <h1>Edit Farmer Information</h1>
    <div class="dashboard-container">
        <form method="post" action="">
            <label for="new_name">New Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?= $farmer['name']; ?>" required>

            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="new_email" value="<?= $farmer['email']; ?>" required>

            <label for="new_phone_number">New Phone Number:</label>
            <input type="tel" id="new_phone_number" name="new_phone_number" value="<?= $farmer['phone_number']; ?>" required>

            <button type="submit">Update Farmer</button>
        </form>

        <?php
        // Display error message if there is an error
        if (isset($error_message)) {
            echo "<div class='error-message'>$error_message</div>";
        }
        ?>
    </div>

    <footer>
        &copy; 2023 Agro Connect. All rights reserved.
    </footer>

</body>
</html>
