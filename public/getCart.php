<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

// Retrieve the cart data from the user's session
$cartData = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Return the cart data as JSON response
header('Content-Type: application/json');
echo json_encode($cartData);
?>
