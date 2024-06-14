<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="aboutus.css">
    <title>About Us - Agro Connect</title>

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
<?php
    // Start the session before any output
    session_start();
    
    // Check if the user is logged in
    $isLoggedIn = isset($_SESSION["user_email"]);

    // Define the current page
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
    ?>

<header>
    <nav>
    <div class="logo">
    <a href="index.php">
        <img src="logo1.png" alt="Agro Connect Logo">
        <span>AgroConnect</span>
    </a>
</div>
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

    <button onclick="toggleDarkMode()">Toggle Dark Mode</button>

    <section class="welcome-section">
    <img src="smile.jpg" alt="Image Description">
    <div class="welcome-section-text">
        <h1>About Agro Connect</h1>
        <p>Welcome to Agro Connect, your trusted online marketplace for fresh agricultural products. Our mission is to connect farmers with consumers, providing a platform for buying and selling high-quality, locally sourced products.</p>

        <p>At Agro Connect, we believe in supporting local farmers and promoting sustainable agriculture. Our platform allows farmers to showcase their products directly to consumers, ensuring transparency and fair pricing.</p>

        <p>Explore our wide range of products, from farm-fresh fruits and vegetables to organic meats and dairy. With Agro Connect, you can enjoy the convenience of shopping for the finest agricultural products from the comfort of your home.</p>
    </div>
</section>

    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

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

    <script src="scriptx.js"></script>
</body>
</html>
