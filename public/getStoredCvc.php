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
$database = "my_db";

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Prepare and execute the query to fetch the stored CVC
$query = "SELECT cvc FROM payments WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":username", $username);
$stmt->execute();

// Fetch the stored CVC
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$cvc = $result['cvc'];

// Echo the stored CVC as the response
echo $cvc;
?>
