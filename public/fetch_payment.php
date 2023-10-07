<?php
// Establish a database connection (replace with your connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch payment information from the database
$sqlPayment = "SELECT id, username, cname, cnumber, cdate, cvc FROM payments WHERE username = '$username'";
$resultPayment = mysqli_query($conn, $sqlPayment);

// Create an array to store the credit card data
$creditCards = array();

// Fetch and store the credit card data if available
if (mysqli_num_rows($resultPayment) > 0) {
    while ($rowPayment = mysqli_fetch_assoc($resultPayment)) {
        $creditCard = array(
            "id" => $rowPayment["id"],
            "cname" => $rowPayment["cname"],
            "cnumber" => $rowPayment["cnumber"],
            "cdate" => $rowPayment["cdate"],
            "cvc" => $rowPayment["cvc"]
        );

        $creditCards[] = $creditCard;
    }
}

// Close the database connection
mysqli_close($conn);

// Convert the credit card data to JSON format and send the response
header('Content-Type: application/json');
echo json_encode($creditCards);
?>
