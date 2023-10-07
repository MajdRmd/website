<?php

// connect to the MySQL server
$conn = mysqli_connect("localhost", "root", "", "my_db");

// check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// define an empty variable to store the error message
$error = "";

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the form data
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $country = $_POST['country'];
  $confirm_password = $_POST['confirm_password'];

  // check if the passwords match
  if ($password != $confirm_password) {
    $error = "Error: Passwords do not match!";
  } else {
    // check if email or username already exists
    $checkQuery = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      // email or username already exists
      $error = "Error: Email or username already exists!";
    } else {
      // hash the password
      $hashedPass = password_hash($password, PASSWORD_DEFAULT);

      // insert the data into the database
      $insertQuery = "INSERT INTO users (name, username, password, email, gender, country, reg_date) VALUES ('$name', '$username', '$hashedPass', '$email', '$gender', '$country', CURDATE())";

      if (mysqli_query($conn, $insertQuery)) {
        echo 'Registration complete. Redirecting to the login page...';

        // redirect to the login page after 3 seconds
        header('Refresh: 3; url=login.php');
        exit();
      } else {
        $error = "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      }
    }
  }
}

// close the MySQL connection
mysqli_close($conn);

// display the error message if exists
if (!empty($error)) {
  echo $error;
}
?>
