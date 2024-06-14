<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminpage.css">
    <title>Admin Page</title>
</head>
<body>

<?php
    // Start the session before any output
    session_start();
    
    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION["user_email"]);
    ?>

    <header>
        <nav>
            <div class="logo"><a href="index.php">Agro Connect</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="indexloggedin.php">Products</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contactus.php">Contact us</a></li>
            </ul>
            
            <?php
            // Display additional user information if logged in
            if ($isLoggedIn) {
                echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
            }
            ?>
        </nav>
    </header>


    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>
</body>
</html>
