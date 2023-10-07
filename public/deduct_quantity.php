<?php
// Retrieve the name of the purchased item from the request
$itemName = $_POST['item_name'];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Deduct the quantity of the purchased item by 1
$sql = "UPDATE products SET quantity = quantity - 1 WHERE category = '$itemName'";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo "Quantity deducted successfully.";
} else {
    echo "Error deducting quantity: " . $conn->error;
}

$conn->close();
?>
