<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
      <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      cursor: pointer;
    }

    .form-group input[type="submit"]:hover {
      background-color: #45a049;
    }

    .error-message {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>
    <form action="" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="security_question">Security Question: What is the name of your childhood best friend?</label>
        <input type="text" id="security" name="security" required>
      </div>
      <div class="form-group">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Reset Password">
      </div>
    </form>

  <?php
  // Check if the form has been submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the MySQL server
    $conn = mysqli_connect("localhost", "root", "", "my_db");

    // Check if the connection was successful
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $securityQuestion = $_POST['security'];
    $newPassword = $_POST['new_password'];

    // Query the database to check if the provided information is correct
    $query = "SELECT * FROM users WHERE username = '$username' AND email = '$email' AND security = '$securityQuestion' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
      if (mysqli_num_rows($result) == 1) {
        // User exists and provided correct information
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";
        mysqli_query($conn, $updateQuery);

        echo "Password reset successfully.";
      } else {
  $errorMessage = "Invalid username, email, or security question. Please try again.";
  echo '<div class="error-message">' . $errorMessage . '</div>';
}

    } else {
      echo "Error: " . mysqli_error($conn);
    }

    // Close the MySQL connection
    mysqli_close($conn);
  }
  ?>
</body>
</html>
