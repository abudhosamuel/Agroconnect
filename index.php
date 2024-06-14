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
    <link rel="stylesheet" href="stylespraco.css">
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



        /* Add the following styles for the logo */
    

        /* Add a class to hide the pop-up initially */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .dot-container {
            text-align: center;
            margin-top: 20px; /* Adjust the margin as needed */
        }

        .dot {
            height: 15px;
            width: 15px;
            margin: 0 5px; /* Adjust the margin as needed */
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
            cursor: pointer;
        }

        .dot.active {
            background-color: #717171;
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

    <section class="welcome-section">
        <?php
        // Check if the user is not logged in
        if (!isset($_SESSION["user_email"])) {
            echo '<p>Please log in to explore products.</p>';
            echo '<a href="login.php"><button>Login</button></a>';
        } else {
            // If the user is logged in, display the welcome message
            echo '<h1>Welcome to Agro Connect</h1>';
            echo '<p>Your trusted marketplace for fresh agricultural products.</p>';
            echo '<button onclick="redirectToProducts()">Explore Products</button>';
        }
        ?>
    </section>


<div class="container">
  <h2>Most Visited</h2>
  <div class="grid">
    <div class="item">
      <img src="chicken.jpg" alt="Chicken">
      <p>Chicken</p>
    </div>
    <div class="item">
      <img src="mangoes.jpg" alt="Mangoes">
      <p>Mangoes</p>
    </div>
    <div class="item">
      <img src="tomatoes.jpg" alt="Tomatoes">
      <p>Tomatoes</p>
    </div>
    <div class="item">
      <img src="onions.jpg" alt="Onions">
      <p>Onions</p>
    </div>
    <div class="item">
      <img src="maize.jpg" alt="Maize">
      <p>Maize</p>
    </div>
    <div class="item">
      <img src="bananas.jpg" alt="bananas">
      <p>Bananas</p>
    </div>
    <!-- Add more items here if necessary -->
  </div>
</div>

<section class="feedback-section slideshow-container">
    <h2>Customer Feedback</h2>

    <!-- Feedback Slide 1 -->
    <div class="mySlides">
        <div class="feedback">
            <div class="user-info">
                <div class="user-image">
                    <img src="gladys1.jpg" alt="gladys1">
                </div>
                <div class="user-details">
                    <strong>Gladys Wairimu - Buyer</strong>
                    <p>Amazing variety and quality of fresh produce!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Slide 2 -->
    <div class="mySlides">
        <div class="feedback">
            <div class="user-info">
                <div class="user-image">
                    <img src="vallery.jpg" alt="vallery">
                </div>
                <div class="user-details">
                    <strong>Vallerie Ouma - Buyer</strong>
                    <p>Agro Connect made my online shopping experience for farm products so convenient.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Slide 3 -->
    <div class="mySlides">
        <div class="feedback">
            <div class="user-info">
                <div class="user-image">
                    <img src="kenneth.jpg" alt="Kenneth">
                </div>
                <div class="user-details">
                    <strong>Ken Njuguna - Buyer</strong>
                    <p>Great experience with Agro Connect! The quality of products is fantastic.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Slide 4 -->
    <div class="mySlides">
        <div class="feedback">
            <div class="user-info">
                <div class="user-image">
                    <img src="william.jpg" alt="william">
                </div>
                <div class="user-details">
                    <strong>William Kipyegon - Farmer</strong>
                    <p>Joining Agro Connect has expanded my market reach, and I've seen a significant increase in sales. </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Slide 5 -->
    <div class="mySlides">
        <div class="feedback">
            <div class="user-info">
                <div class="user-image">
                    <img src="teresia1.jpg" alt="Teresia1">
                </div>
                <div class="user-details">
                    <strong>Teresia Nyaboke - Teresia</strong>
                    <p>The platform's reach has allowed my produce to connect with a broader audience.</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Add more feedback slides with similar structure -->

    <!-- Navigation dots for the slides -->
    <div class="dot-container">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
        <!-- Add more dots for additional slides -->
    </div>
</section>

<footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

    <!-- Add a pop-up div for the login message -->
    <div class="popup" id="loginPopup">
        <p>Please log in to access this feature.</p>
        <a href="login.php"><button>Login</button></a>
        <button onclick="closePopup()">Close</button>
    </div>

    
    <script>
        // JavaScript code to show the pop-up when a user clicks on a link that requires login
        var navbarLinks = document.querySelectorAll('.nav-links a');
        
        navbarLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                // Check if the user is not logged in
                if (!<?php echo isset($_SESSION["user_email"]) ? "true" : "false"; ?>) {
                    event.preventDefault();
                    document.getElementById('loginPopup').style.display = 'block';
                }
            });
        });

        function closePopup() {
            document.getElementById('loginPopup').style.display = 'none';
        }

        function redirectToProducts() {
            // Add the URL of the products page here
            window.location.href = 'indexloggedin.php';
        }

    </script>

    <!-- Your existing scripts... -->

    <script>
        var slideIndex = 0;

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 5000); // Change slide every 5 seconds
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        showSlides(); // Start the slideshow
    </script>

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
