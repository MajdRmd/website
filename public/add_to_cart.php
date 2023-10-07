<?php
session_start();

if (isset($_POST['item'])) {
  $item = json_decode($_POST['item'], true);

  // Check if the 'cart' key exists in the session
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }

  // Add the item to the user's cart in the session
  $_SESSION['cart'][] = $item;

  // Return a success response
  http_response_code(200);
  echo 'Item added to the cart!';
} else {
  // Return an error response
  http_response_code(400);
  echo 'Invalid request!';
}
?>
