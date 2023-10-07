<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in username from the session
$username = $_SESSION['user']['username'];

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$db = "my_db";

// Create a new connection
$conn = mysqli_connect($host, $user, $password, $db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the card number from the database based on the logged-in username
$sql = "SELECT cnumber FROM payments WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $cardNumber = $row["cnumber"];
    echo $cardNumber;
} else {
    echo ""; // Return an empty string if no card number is found
}

// Close the database connection
mysqli_close($conn);
?>
