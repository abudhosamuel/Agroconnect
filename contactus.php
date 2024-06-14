<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contactus.css">
    <title>Contact Us - Agro Connect</title>
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
    text-decoration: underline;
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
    <img src="tractor.jpg" alt="Image Description">
    <div class="contact-form">
        <h1>Contact Us</h1>
        <p>Have questions or feedback? Reach out to us!</p>

        <!-- Contact Form -->
        <form action="process_contact.php" method="post">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Submit</button>
        </form>

        <?php
            // Check for the success parameter
            if (isset($_GET["success"]) && $_GET["success"] == "true") {
                echo '<div style="color: green;">You will be contacted by Customer Support soon</div>';
            }
        ?>
    </div>
</section>

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
