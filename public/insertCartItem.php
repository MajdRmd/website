<?php
session_start();

// Retrieve the cart items sent from JavaScript
$cartItems = json_decode(file_get_contents('php://input'), true);

// Store the cart items in the session
$_SESSION['cart'] = $cartItems;

?>
