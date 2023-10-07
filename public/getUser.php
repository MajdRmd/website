<?php
session_start();

if (!isset($_SESSION['user'])) {
  http_response_code(401); // Unauthorized
  exit();
}

// Retrieve the item data sent from the client
$item = json_decode(file_get_contents('php://input'), true);

// Extract the item details
$size = $item['size'];
$color = $item['color'];
$name = $item['name'];
$price = $item['price'];

// Insert the item into the database for the logged-in user
// Replace 'your_table_name' with the actual table name
$servername = 'localhost';
$username = 'your_username';
$password = 'your_password';
$dbname = 'your_database_name';

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  http_response_code(500); // Internal Server Error
  exit();
}

$user_id = $_SESSION['user_id'];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO your_table_name (user_id, item_name, item_price, item_color, item_size) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $user_id, $name, $price, $color, $size);

// Execute the statement
if ($stmt->execute()) {
  http_response_code(200); // OK
} else {
  http_response_code(500); // Internal Server Error
}

$stmt->close();
$conn->close();
?>
