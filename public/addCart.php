<?php
session_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if (isset($_POST['item'])) {
  
  $item = $_POST['item'];
  $_SESSION['cart'][] = $item;
}

?>
