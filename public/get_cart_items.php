<?php
session_start();

if (isset($_SESSION['cart'])) {
  $cartItems = $_SESSION['cart'];
  echo json_encode($cartItems);
} else {
  echo json_encode(array());
}
?>
