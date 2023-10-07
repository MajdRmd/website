<?php
// Retrieve the form data from the AJAX request
$username = $_POST['username'];
$cname = $_POST['cname'];
$cnumber = $_POST['cnumber'];
$cdate = $_POST['cdate'];
$cvc = $_POST['cvc'];

// Establish a database connection
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "my_db";

$conn = mysqli_connect($servername, $usernameDB, $passwordDB, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the username already exists in the payments table
$sql = "SELECT * FROM payments WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Update the existing payment information
    $sql = "UPDATE payments SET cname = '$cname', cnumber = '$cnumber', cdate = '$cdate', cvc = '$cvc' WHERE username = '$username'";
    if (mysqli_query($conn, $sql)) {
        echo "Payment information updated successfully";
    } else {
        echo "Error updating payment information: " . mysqli_error($conn);
    }
} else {
    // Insert new payment information
    $sql = "INSERT INTO payments (username, cname, cnumber, cdate, cvc) VALUES ('$username', '$cname', '$cnumber', '$cdate', '$cvc')";
    if (mysqli_query($conn, $sql)) {
        echo "Payment information saved successfully";
    } else {
        echo "Error saving payment information: " . mysqli_error($conn);
    }
}


// Close the database connection
mysqli_close($conn);
?>
