<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        // Add user logic
        $user_id = $_POST['user_id'];
        $user_type = $_POST['user_type']; // Retrieve user_type from form data
        $sql_select = "SELECT * FROM newusers WHERE id = $user_id";
        $result = mysqli_query($conn, $sql_select);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if ($user_type === 'Farmer') {
                $table = 'farmer_tablenew';
                $driver_name = mysqli_real_escape_string($conn, $user['driver_name']); // Include driver_name for farmers
            } elseif ($user_type === 'Buyer') {
                $table = 'buyer_tablenew';
                $driver_name = ''; // No driver_name for buyers
            } else {
                echo "Invalid user type";
                exit();
            }
            // Insert user information into the appropriate table
            $name = mysqli_real_escape_string($conn, $user['name']);
            $email = mysqli_real_escape_string($conn, $user['email']);
            $password = mysqli_real_escape_string($conn, $user['password']);
            $confirmPassword = mysqli_real_escape_string($conn, $user['confirm_password']);
            $phoneNumber = mysqli_real_escape_string($conn, $user['phone_number']);
            $userType = mysqli_real_escape_string($conn, $user['user_type']);
            $identityCard = mysqli_real_escape_string($conn, $user['identity_card']);
            $kra_pin = mysqli_real_escape_string($conn, $user['kra_pin']);
            $photo_path = mysqli_real_escape_string($conn, $user['photo_path']);
            $sql_insert = "INSERT INTO $table (`name`, `email`, `password`, `confirm_password`, `phone_number`, `user_type`, `identity_card`, `kra_pin`, `photo_path`";
            // Include driver_name column for farmers
            if ($user_type === 'Farmer') {
                $sql_insert .= ", `driver_name`";
            }
            $sql_insert .= ") VALUES ('$name', '$email', '$password', '$confirmPassword', '$phoneNumber', '$userType', '$identityCard', '$kra_pin', '$photo_path'";
            // Include driver_name value for farmers
            if ($user_type === 'Farmer') {
                $sql_insert .= ", '$driver_name'";
            }
            $sql_insert .= ")";
            if (mysqli_query($conn, $sql_insert)) {
                // Successfully inserted into the appropriate table
                // Now, delete the entry from the newusers table
                $sql_delete = "DELETE FROM newusers WHERE id = $user_id";
                if (mysqli_query($conn, $sql_delete)) {
                    // Successfully deleted the entry from newusers table
                    // Redirect to newusersadmin.php
                    header("Location: newusersadmin.php");
                    exit(); // Ensure that no further code is executed after the redirect
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "User not found.";
        }
    } elseif (isset($_POST['delete_user'])) {
        // Delete user logic
        $user_id = $_POST['user_id'];
        // Delete the user from the newusers table
        $sql_delete = "DELETE FROM newusers WHERE id = $user_id";
        if (mysqli_query($conn, $sql_delete)) {
            // Successfully deleted the user
            // Redirect back to the same page
            header("Location: newusersadmin.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
