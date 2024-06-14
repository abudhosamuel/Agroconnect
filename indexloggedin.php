<?php
    // Start the session before any output
    session_start();
    
    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION["user_email"]);
    
    // Define the current page
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

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

        .nav-links a.active {
            text-decoration: underline; /* Adds underline on hover for visual feedback */
        }

        .nav-links a:hover {
            text-decoration: underline; /* Adds underline on hover for visual feedback */
        }

        /* Additional styles for responsiveness if necessary */
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column; /* Stack links vertically on smaller screens */
                align-items: flex-end; /* Aligns links to the end (right side) */
            }
        }

        /* Add styles for the slide text animation */
        .slide-text {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 50px; /* Adjust the height as needed */
            background-color: #333; /* Background color of the slide text */
            color: #fff; /* Text color */
            font-size: 20px; /* Font size of the slide text */
            text-align: center;
            line-height: 50px; /* Line height for vertical centering */
        }

        .slide-text span {
            position: absolute;
            left: 100%; /* Initially position the text outside the container */
            white-space: nowrap; /* Prevent text wrapping */
            animation: slideText 20s linear infinite; /* Animation settings */
        }

        @keyframes slideText {
            0% {
                left: 100%; /* Start position */
            }
            100% {
                left: -100%; /* End position */
            }
        }

        .product-section {
    margin-bottom: 100px; /* Add margin to create space for the footer */
}

        /* Add styles for the search bar */
.search-bar {
    text-align: right;
    margin-top: 20px;
    margin-right: 20px;
}

.search-bar input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-bar button {
    padding: 8px 15px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.search-bar button:hover {
    background-color: #45a049;
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
            // Display additional user information if logged in
            if ($isLoggedIn) {
                echo "<div class='welcome'>Welcome, " . $_SESSION["user_name"] . "!</div>";
                echo "<div class='logout'><a href='logout.php'>Logout</a></div>";
            }
            ?>
        </nav>
    </header>

    <!-- Slide text animation -->
    <div class="slide-text">
        <span>Payment to be done on delivery. Deliveries will be made within 24 hours</span>
    </div>

    <button onclick="toggleDarkMode()">Toggle Dark Mode</button>

    <!--<section class="welcome-section">
        <h1>Welcome to Agro Connect</h1>
        <p>Your trusted marketplace for fresh agricultural products.</p>
        <button onclick="redirectToProducts()">Explore Products</button>
    </section> 
-->

    <!-- New section for displaying products -->
    <section class="product-section">
    <!-- Add the search bar above the products section -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search products...">
    </div>
    <h2>Our Products</h2>

    <!-- Add an ID to the product cards container -->
    <div id="productCards" class="product-cards">
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
                    echo "<a href='product_details.php?id={$row['id']}' class='product-link'>";
                    echo "<div class='product-card'>";
                    echo "<img src='{$row['image_path']}' alt='{$row['product_name']}' />";
                    echo "<h3>{$row['product_name']}</h3>";
                    echo "<p>{$row['product_description']}</p>";
                    echo "<p>Price: {$row['product_price']}</p>";
                    echo "</div>";
                    echo "</a>";
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

    <script>
        // JavaScript code for the slide text animation
        window.onload = function() {
            var slideText = document.querySelector('.slide-text span');

            function slide() {
                slideText.style.left = '100%';
                setTimeout(function() {
                    slideText.style.left = '-100%';
                }, 20000); // Adjust the duration (in milliseconds) as needed
            }

            slide(); // Start the animation

            setInterval(slide, 22000); // Repeat the animation after every 22 seconds (adjust as needed)
        };
    </script>

<script>
    // Function to filter products based on user input
    function filterProducts() {
        // Get the input value and convert it to lowercase
        var input = document.getElementById('searchInput').value.toLowerCase();
        // Get all product cards
        var productCards = document.querySelectorAll('.product-card');

        // Loop through each product card
        productCards.forEach(function(card) {
            // Get the product name and convert it to lowercase
            var productName = card.querySelector('h3').textContent.toLowerCase();
            // Show or hide the product card based on the input value
            if (productName.startsWith(input)) {
                card.style.display = 'block'; // Show the product card
            } else {
                card.style.display = 'none'; // Hide the product card
            }
        });
    }

    // Add event listener to the search input field
    document.getElementById('searchInput').addEventListener('input', filterProducts);
</script>

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
