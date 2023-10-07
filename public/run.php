<?php
session_start(); // start the session

$host = "localhost";
$user = "root";
$password = "";
$db = "my_db";

$get = mysqli_connect($host, $user, $password);
mysqli_select_db($get, $db);

if (isset($_POST['user'])) {
    $uname = mysqli_real_escape_string($get, $_POST['user']);
    $password = mysqli_real_escape_string($get, $_POST['pass']);

    // query the database for the user's information
    $sql = "SELECT id, username, password FROM users WHERE username='$uname' LIMIT 1";
    $result = mysqli_query($get, $sql);

    // check if the user exists in the database
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // verify the password
        if (password_verify($password, $row['password'])) {
            // Authenticate user credentials and set session data
            $_SESSION['user'] = array(
                'id' => $row['id'],
                'username' => $row['username']
            );
            // Redirect to the afterlogin.php page
            header('Location: index.php');
            exit();
        }

    }
      else if ($uname == "admin" && $password == "admin"){
          header('Location: admindashboard.php');
          exit();
        }

    // Display error alert
    echo "<script>alert('Please check your username and password and try again.'); window.location='login.php';</script>";
    exit();
}
?>
