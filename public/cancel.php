<?php

// Check if the cancel button was clicked
if(isset($_POST['cancel'])) {
  // Connect to the database
  $db = mysqli_connect("localhost","root","","my_db");

  // Insert the purchase into the database
  $query = "delete from `purchase` order by id desc limit 1";
  mysqli_query($db, $query);

  // Close the database connection
  mysqli_close($db);

  // Show an alert message and redirect back to the shoes.html page
  echo "<script>alert('Cancel successful!')</script>";
  header("Location: shop.php");
}

?>
