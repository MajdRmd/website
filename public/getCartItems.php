<?php
session_start();

if (isset($_SESSION['user'])) {
  $response = array('isLoggedIn' => true, 'cartItems' => $_SESSION['cart']);
} else {
  $response = array('isLoggedIn' => false, 'cartItems' => []);
}

header('Content-Type: application/json');
echo json_encode($response);
?>
