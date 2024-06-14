<?php
session_start();

// Include the database connection file
include("db_connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userFound = false;

    // Query to check user credentials in buyer_table
    $sql_buyer = "SELECT id, name, user_type, password FROM buyer_tablenew WHERE email = ?";
    $stmt_buyer = $conn->prepare($sql_buyer);
    $stmt_buyer->bind_param("s", $email);
    $stmt_buyer->execute();
    $stmt_buyer->bind_result($id, $name, $user_type, $hashed_password);

    if ($stmt_buyer->fetch() && password_verify($password, $hashed_password)) {
        $userFound = true;
    }

    $stmt_buyer->close();

    // Query to check user credentials in farmer_table
    if (!$userFound) {
        $sql_farmer = "SELECT id, name, user_type, password FROM farmer_tablenew WHERE email = ?";
        $stmt_farmer = $conn->prepare($sql_farmer);
        $stmt_farmer->bind_param("s", $email);
        $stmt_farmer->execute();
        $stmt_farmer->bind_result($id, $name, $user_type, $hashed_password);

        if ($stmt_farmer->fetch() && password_verify($password, $hashed_password)) {
            $userFound = true;
        }

        $stmt_farmer->close();
    }

     // Query to check user credentials in users3 table (for admin)
     if (!$userFound) {
        $sql_admin = "SELECT name, user_type FROM users3 WHERE email = ? AND password = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("ss", $email, $password);
        $stmt_admin->execute();
        $stmt_admin->bind_result($name, $user_type);

        if ($stmt_admin->fetch()) {
            $userFound = true;
        }

        $stmt_admin->close();
    }

    // User is authenticated, set session variables and redirect
    if ($userFound) {
        $_SESSION["user_email"] = $email;
        $_SESSION["user_name"] = $name;
        $_SESSION["user_type"] = $user_type;
    
        // Redirect based on user type
        if ($user_type == 'Buyer') {
            header("Location: index.php");
            exit();
        } elseif ($user_type == 'Farmer') {
            header("Location: farmerdashboard2.php");
            exit();
        } elseif ($user_type == 'admin') {
            header("Location: admin2.php");
            exit();
        }
    } else {
        // Invalid credentials, show an error message
        $error_message = "Invalid email or password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login - Agro Connect</title>
    <style>
        .login-container {
            text-align: center;
            margin-top: 50px;
        }
        .password-field {
            text-align: center;
        }

        .logo {
            max-width: 200px; /* Adjust the maximum width as needed */
            height: auto;
        }
        </style>
</head>
<body>

<div class="login-container">
    <h2>Login to Agro Connect</h2>
    <img src="logo1.png" alt="Agro Connect Logo" class="logo">
    <form method="post" action="">
        <!-- Email Field -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <!-- Password Field -->
        <div class="password-field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <!-- Show Password Checkbox and Label -->
            <div class="show-password">
                <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()">
                <label for="show-password">Show Password</label>
            </div>
        </div>

        <!-- Login Button -->
        <button type="submit">Login</button>
    </form>

        <p>Don't have an account? <a href="signup2.php">Sign Up</a></p>

        <?php
        // Display error message if set
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
    </div>

    <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var showPasswordCheckbox = document.getElementById('show-password');
        if (showPasswordCheckbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>

</body>
</html>


