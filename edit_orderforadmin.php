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

// Check if order ID is provided
if (!isset($_GET['id'])) {
    echo "Order ID not provided.";
    exit;
}

// Retrieve order details from the database based on the provided ID
$order_id = $_GET['id'];
$sql = "SELECT * FROM new_orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    echo "Order not found.";
    exit;
}

// Handle form submission to update the order details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated order details from the form
    $status = $_POST['status'];
    $feedback = $_POST['feedback'];

    // Update the order details in the database
    $update_sql = "UPDATE new_orders SET status = ?, feedback = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $status, $feedback, $order_id);
    $update_stmt->execute();

    // Redirect to the orders_admin.php page after updating the order
    header("Location: orders_admin.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="farmersadmin.css">
    <title>Edit Order</title>
</head>

<body>
    <h1>Edit Order</h1>
    <form method="post">
        <!-- Display the current order details in input fields for editing -->
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="approved" <?php if ($order['status'] == 'approved') echo 'selected'; ?>>Approved</option>
            <option value="not_approved" <?php if ($order['status'] == 'not_approved') echo 'selected'; ?>>Not Approved</option>
        </select>

        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback"><?php echo $order['feedback']; ?></textarea>

        <button type="submit">Update Order</button>
    </form>

    <footer>
        <p>&copy; 2024 Agro Connect. All rights reserved.</p>
    </footer>

</body>
</html>
