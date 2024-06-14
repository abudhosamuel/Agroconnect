<?php
session_start();
include("db_connect.php");

// Check if the user is logged in and is a farmer
if (!isset($_SESSION["user_email"]) || !isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Farmer") {
    http_response_code(403); // Forbidden
    exit();
}

$farmerEmail = $_SESSION['user_email']; // Use the email from the session

// Query to count new orders for the farmer
$sql = "SELECT COUNT(*) AS new_orders_count FROM new_orders WHERE farmer_email = ? AND status = 'New'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $farmerEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['new_orders_count']; // Return the count of new orders
} else {
    echo "0"; // No new orders
}

$stmt->close();
$conn->close();
?>
