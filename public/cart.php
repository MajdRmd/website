<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart'])) {
        $_SESSION['cart'] = $_POST['cart'];
        echo 'Cart saved successfully';
    }
}
?>
