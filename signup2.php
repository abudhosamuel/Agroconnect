<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $userType = mysqli_real_escape_string($conn, $_POST["userType"]);
    $identityCard = mysqli_real_escape_string($conn, $_POST["identityCard"]);
    $kraPin = mysqli_real_escape_string($conn, $_POST["kraPin"]);
    $driverName = $userType === 'Farmer' ? mysqli_real_escape_string($conn, $_POST["driverName"]) : '';
    $uploadFile = ''; // Default to empty string if no file

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            // Handle photo upload failure
            $uploadFile = ''; // Reset to empty if failed
            echo "Photo upload failed.";
        }
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query to insert user information into the newusers table
    $sql = "INSERT INTO newusers (name, email, password, confirm_password, phone_number, user_type, identity_card, kra_pin, photo_path, driver_name)
            VALUES ('$name', '$email', '$hashed_password', '$confirmPassword', '$phoneNumber', '$userType', '$identityCard', '$kraPin', '$uploadFile', '$driverName')";

    $stmt = mysqli_query($conn, $sql);

    if ($stmt) {
        // Set a session variable to indicate successful registration
        $_SESSION['registration_success'] = "Registered successfully. Wait for admin to verify your details.";
    } else {
        // Handle registration failure
        $error_message = "Registration failed. Error: " . mysqli_error($conn);
        echo $error_message;  // Output the error message for debugging
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <title>Sign Up - Agro Connect</title>
    <style>

        .logo {
            display: block; /* Make the image a block element */
            margin: 0 auto; /* Center the image horizontally */
            max-width: 200px; /* Adjust the maximum width as needed */
            height: auto;
            text-align: center;
            }
        </style>
</head>
<body>

    <div class="signup-container">
        <h2>Sign Up for Agro Connect</h2>
        <img src="logo1.png" alt="Agro Connect Logo" class="logo">
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required placeholder="John Doe" pattern="[A-Za-z\s]+" title="Full Name must contain only alphabets and spaces">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="user@gmail.com">

            <div class="input-wrapper">
                <label for="password">Password:</label>
                <div class="password-input-wrapper">
                    <input type="password" id="password" name="password" required placeholder="user@123">
                    <span onclick="togglePasswordVisibility('password')" class="toggle-password">
                        <i class="far fa-eye" id="togglePassword1" style="cursor: pointer;"></i>
                    </span>
                </div>
            </div>

            <div class="input-wrapper">
                <label for="confirmPassword">Confirm Password:</label>
                <div class="password-input-wrapper">
                    
                <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password">
                    <span onclick="togglePasswordVisibility('confirmPassword')" class="toggle-password">
                        <i class="far fa-eye" id="togglePassword2" style="cursor: pointer;"></i>
                    </span>
                </div>
            </div>

            <label for="phoneNumber">Phone Number:</label>
            <input type="text" id="phoneNumber" name="phoneNumber" required placeholder="0712345678" pattern="\d{10}" title="Phone number must be exactly 10 digits">

            <label for="identityCard">Identity Card Number:</label>
            <input type="text" id="identityCard" name="identityCard" required placeholder="12345678" pattern="\d{8}" title="Identity card must be exactly 8 digits">

            <label for="kraPin">KRA Pin:</label>
            <input type="text" id="kraPin" name="kraPin" required placeholder="A12345678" pattern="[A-Z]\d{8}" title="KRA Pin must start with a letter followed by 8 digits">

            <label for="photo">Upload your photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*">

            <label>User Type:</label>
            <div class="radio-container">
                <input type="radio" id="farmerRadio" name="userType" value="Farmer" required>
                <label for="farmerRadio">Farmer</label>
            </div>

            <div class="radio-container">
                <input type="radio" id="buyerRadio" name="userType" value="Buyer" required>
                <label for="buyerRadio">Buyer</label>
            </div>

            <!-- Driver Name Field, initially hidden, shown only for farmers -->
            <div class="input-wrapper" id="driverNameWrapper" style="display: none;">
                <label for="driverName">Driver Name:</label>
                <input type="text" id="driverName" name="driverName" placeholder="Driver's Full Name">
            </div>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>

    <?php
    // Check if the registration success message is set and display the alert
    if (isset($_SESSION['registration_success'])) {
        echo "<script type='text/javascript'>
                alert('" . $_SESSION['registration_success'] . "');
                window.location.href = 'login.php';
              </script>";
        // Unset the session message after displaying it
        unset($_SESSION['registration_success']);
    }
    ?>

    <script>
        function togglePasswordVisibility(fieldId) {
            var passwordInput = document.getElementById(fieldId);
            var type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            var toggleIcon = fieldId === 'password' ? document.getElementById('togglePassword1') : document.getElementById('togglePassword2');
            toggleIcon.classList.toggle('fa-eye-slash');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var userTypeFarmer = document.getElementById('farmerRadio');
            var userTypeBuyer = document.getElementById('buyerRadio');
            var driverNameWrapper = document.getElementById('driverNameWrapper');

            userTypeFarmer.addEventListener('change', function () {
                if (this.checked) {
                    driverNameWrapper.style.display = 'block';
                }
            });

            userTypeBuyer.addEventListener('change', function () {
                if (this.checked) {
                    driverNameWrapper.style.display = 'none';
                }
            });

            document.querySelector('form').addEventListener('submit', function (event) {
                var password = document.getElementById('password').value;
                var confirmPassword = document.getElementById('confirmPassword').value;
                var identityCard = document.getElementById('identityCard').value;
                var kraPin = document.getElementById('kraPin').value;
                var phoneNumber = document.getElementById('phoneNumber').value;
                var driverName = document.getElementById('driverName').value;

                // Password and Confirm Password validation
                if (password !== confirmPassword) {
                    alert('Password and Confirm Password do not match.');
                    event.preventDefault(); // Prevent form submission
                }

                // Identity card validation
                if (identityCard.length !== 8 || isNaN(identityCard)) {
                    alert('Identity card must be exactly 8 numerical digits.');
                    event.preventDefault(); // Prevent form submission
                }

                // Phone number validation
                if (phoneNumber.length !== 10) {
                    alert('Phone number must be exactly 10 characters.');
                    event.preventDefault(); // Prevent form submission
                }

                // Driver Name validation for farmers
                if (userTypeFarmer.checked && !driverName.trim()) {
                    alert('Please enter the driver name.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
</body>
</html>
