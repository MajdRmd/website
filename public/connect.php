<?php

// Get the POST data
$username = $_POST['username'];
$password = $_POST['password'];

// Establish a connection to the database

$con = mysqli_connect("localhost","my_user","my_pass","my_db");

// Check connection

if (mysqli_connect_errno()){

  die("Connection failed: ".mysqli_connect_error());
}
?>
