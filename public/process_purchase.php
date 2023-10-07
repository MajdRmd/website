<?php
$conn = new mysqli('localhost', 'root', '', 'my_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$items = $_POST['items'];

// Prepare the SQL statement
$sql = "INSERT INTO purchase (category, size, color, username, Date) VALUES (?,  ?, ?, ?, ?)";

// Create a prepared statement
$stmt = $conn->prepare($sql);

// Iterate over each item and insert into the database
foreach ($items as $item) {
  $category = $item['category'];
  $size = $item['size'];
  $color = $item['color'];
  $username = $item['username'];
  $date = date('Y-m-d'); // Get the current date

  // ... your code ...

  // Debug statement
  echo "Category: $category, Size: $size, Color: $color, Username: $username, Date: $date<br>";
//$truncatedPrice = substr($price, 0, 4); // Assuming the defined length is 10

// Bind the truncated price to the parameter
$stmt->bind_param("sssss", $category, $size, $color, $username, $date); 


  
  // Execute the statement
  $stmt->execute();
}

// Check if the insertion was successful
if ($stmt->affected_rows > 0) {
  echo "Purchase inserted successfully.";

} else {

  echo "Error inserting purchase.". $stmt->error;
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>