<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexloggedin.css">
    <title>Online Farmers Marketplace</title>

    <style>
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

    <!--<section class="welcome-section">
        <h1>Welcome to Agro Connect</h1>
        <p>Your trusted marketplace for fresh agricultural products.</p>
        <button onclick="redirectToProducts()">Explore Products</button>
    </section> 
-->

    <!-- New section for displaying products -->
    <section class="product-section">
        <h2>Our Products</h2>

        <div class="product-cards">
            <?php
                // Replace the following with your actual database connection details
                $servername = "localhost";
                $username = "agroconnect_user";
                $password = "your_password";
                $dbname = "agroconnect_db";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Fetch product data from the database
                $query = "SELECT * FROM productsnew";
                $result = mysqli_query($conn, $query);

                // Loop through the result and generate cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='product-card'>";
                    echo "<img src='{$row['image_path']}' alt='{$row['product_name']}' />";
                    echo "<h3>{$row['product_name']}</h3>";
                    echo "<p>{$row['product_description']}</p>";
                    echo "<p>Price: {$row['product_price']}</p>";
                    // Display the image using the image_path

                     // Display the farmer's name
                    echo "<p>Posted by: {$row['farmer_name']}</p>";
    
                    echo "</div>";
}
                    
                    // Function to generate star ratings
function generateStarRating($rating) {
    $stars = "";
    $fullStars = floor($rating);
    $halfStar = ceil($rating - $fullStars);
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $fullStars) {
            $stars .= "<span class='star'>&#9733;</span>"; // Full star
        } elseif ($i == $fullStars + 1 && $halfStar == 1) {
            $stars .= "<span class='star'>&#9733;&#9734;</span>"; // Half star
        } else {
            $stars .= "<span class='star'>&#9734;</span>"; // Empty star
        }
    }
    return $stars;
}

                // Close the database connection
                mysqli_close($conn);
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

    <script src="scriptx.js"></script>
</body>
</html>
