<?php
session_start();

// Check if the user is logged in
if (isset($_GET['username'])) {
  // Get the username from the request
  $username = $_GET['username'];

  // Check if the user has a cart
  if (isset($_SESSION['carts'][$username])) {
    // Retrieve the user's cart items
    $cartItems = $_SESSION['carts'][$username];

    // Send the cart items as a response
    echo json_encode(['cartItems' => $cartItems]);
  } else {
    // Send an empty cart response if the user has no items in the cart
    echo json_encode(['cartItems' => []]);
  }
} else {
  // Send an error response if the username is not provided
  http_response_code(400);
  echo "Username not provided.";
}
?>
