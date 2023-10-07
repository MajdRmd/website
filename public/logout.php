<?php
session_start(); // Start the session to access session variables

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: afterlogin.php");
exit;
?>
