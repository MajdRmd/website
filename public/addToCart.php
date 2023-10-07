<?php
session_start();

if (isset($_SESSION['user'])) {
    $item = json_decode(file_get_contents('php://input'), true);

    // Get the user's cart from the session or create a new empty cart
    $cart = $_SESSION['user']['cart'] ?? [];

    // Add the item to the user's cart
    $cart[] = $item;

    // Update the user's cart in the session
    $_SESSION['user']['cart'] = $cart;

    // Return success status
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    // Return error status if user is not logged in
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
}
?>
