<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="csslog.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form..!</title>
  
</head>

<body>
    <style type="text/css">
            body {
    background-color: #333333;
    margin: 0;
}

            video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .container {
    color: #ffffff;
    text-transform: uppercase;
    text-align: center;
    margin-top: 170px;
}

.background {
    width: 100%;
    height: 100%;
    position: fixed;
    left: 0;
    top: 0;
    z-index: -100;
    opacity: .2;
}
#uname,#pass{
    color: white;
}
    #forgotPass{
        color: blueviolet;
    }
   label, input[type="text"], input[type="password"]{
            color: black;
        }
        a, input[type="submit"]{
            color: white;
        }
    </style>
     <div class="container">
            <div class="background">
                <video src="background2.mp4" muted autoplay loop></video>
            </div>

          
</div>
    <form action="run.php" method = "POST" onsubmit="return validate()">
        <p>
            <label id="uname">Username :</label>
            <input type="text" id ="username" name = "user" required />
        </p>
        <p>
            <label id="pass">Password :</label>
            <input type="password" id ="password" name = "pass" required />
        </p>
          <p>
        <input type="checkbox" onclick="myFunction()">
        <span style="color: white;">Show Password</span>
    </p>
            <script type="text/javascript">function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  function openForgotPasswordPopup() {
  document.getElementById('forgotPasswordPopup').style.display = 'block';
}
}</script>
        <p>
            <input type="submit" id = "submit" value = "Login"/>
        </p>
         <p>
           <span style="color: white;">Don't have an account?</span> <a href="signup.php" style="color: blueviolet;">Sign up</a> 
        </p>
         <p>
      <a href="reset_password.php" id="forgotPass" onclick="openForgotPasswordPopup()">Forgot Password?</a>
    </p>
    </form>
    <div id="forgotPasswordPopup" style="display: none;">
  <h2>Forgot Password</h2>
  <form action="reset_password.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="securityQuestion">Security Question:</label>
    <input type="text" id="securityQuestion" name="securityQuestion" required>
    <br>
    <input type="submit" value="Reset Password">
  </form>
</div>



</body>
</html>