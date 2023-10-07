<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="after.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
<style>
main {
  position: relative;
}
    
.video-container {
margin: 0 auto;
  display: flex;
justify-content: center;
  padding: 20px;
  box-sizing: border-box;
}

.video-container video {
  
  border: 2px solid dimgray;
  border-radius: 5px;
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 30px 0 rgba(0, 0, 0, 0.19);
  background: #383838;
}


.featured-products {
  display: flex;
  align-items: center;
  justify-content: center;
}

#im {
  width: 300px;
  height: 150px;
  box-sizing: border-box;
  border: 2px solid dimgray;
  border-radius: 5px;
  /* round the corners of the border */
  padding: 20px;
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 30px 0 rgba(0, 0, 0, 0.19);
  color: black;
  background: #383838;
}

.featured-products a {
  margin: 0 10px;
}

.featured-products a:nth-child(3) {
  align-self: flex-start;
  margin-bottom: 40px; /* Adjust the margin as desired */
}

</style>

  <header>
    <nav>
      <ul>


        <li><a href="men.php">Shop Now</a></li>
        <li><a href="about.php">About Us</a></li>
        <li class="login">
        <?php
        session_start(); // Start the session to access session variables

        if (isset($_SESSION['user']) && isset($_SESSION['user']['username'])) {
          // User is logged in
          $username = $_SESSION['user']['username'];

          echo "<a href='logout.php'>Logout</a>";
        } else {
          // User is not logged in
          echo "<a href='login.php'>Login</a>";
        }
        ?>

      </ul>
    </nav>
  </header>

  <main>

    <h1>Welcome to our Clothing Website <?php if (isset($username)) { echo $username;} ?>!</h1>
    <p>Check out our latest collections:</p>
    <div class="featured-products">
      <a href="men.php"><img src="black-shoes.png" alt="Product 1"></a>
      <a href="men.php"><img src="jeans.png" alt="Product 2"></a>
      <a href="men.php"><img src="white-shirt.png" alt="Product 3"></a>
    </div>
    <a href="men.php" >
    <button class="cta">
    <span class="hover-underline-animation"> Shop now </span>
    <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
        <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
    </svg>
</button>
</a>
<div class="video-container" ><p>
  <video controls loop playsinline poster="logo.png" id="vid" width="900px" height="400px">
         <source src = "videoShop.mp4" type = "video/mp4">
      </p></video>
  </div>
  </main>

    <footer>
    <p>Copyright &copy 2023 Clothing Website</p>
      <a href="https://www.instagram.com" target="_blank" class="ig"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
</svg></a>
<a href="https://www.facebook.com/LaaFamiliaa1/" target="_blank" class="fb"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
</svg></a>
    
    <ul>
      <li><a href="about.php">About Us</a></li>
      <li><a href = "https://mail.google.com/mail/?view=cm&to=lafamiliaplatform@gmail.com&su=Feedback&body = Message" target="_blank">
Contact Us
</a></li>
      <li><a href="privacy.pdf" target="_blank">Privacy and cookies policies</a></li>
      <li><a href="terms.pdf" target="_blank">Terms of use</a></li>
       <li id="qr"><a href="#" onclick="openQRPopup()">Rate Us</a></li>
    </ul>

    <!-- Footer content... -->
    
    <!-- Popup overlay and content -->
    <div id="qrPopupOverlay" class="popup-overlay">
        <div class="popup-content">
            <!-- Close button -->
            <span class="popup-close" onclick="closeQRPopup()">&times;</span>
            
            <!-- QR code image -->
            <h3>Welcome to La Familia!</h3>
            <p>Scan the QR code below to rate our website:</p>
            <div class="qr-image-container">
            
            <img src="qr.png"  alt="QR Code">
        </div>
         <a href="https://forms.gle/CR4riTE8gHbhp1pb6" target="_blank" class="rate">Or click here</a>
      </div>
    </div>
  
    <script>
        function openQRPopup() {
            // Show the QR code popup overlay
            document.getElementById('qrPopupOverlay').style.display = 'flex';
        }
        
        function closeQRPopup() {
            // Hide the QR code popup overlay
            document.getElementById('qrPopupOverlay').style.display = 'none';
        }
    </script>


</footer>


<style>
    .ig svg,
  .fb svg {
    width: 35px;
    height: 35px;
  }
  
  .ig{
    color: white;
   float: right;
    margin-right: 15px;
       margin-top: -20px;
    font-size: 20px;

  }
  .fb{
    color: white;
     float: right;
    margin-right: 10px;
       margin-top: -20px;

 
  }
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .popup-content {
      color: black;
        position: relative;
        width: 50%;
        height: 50%;
        background-color: #fff;
        text-align: center;
    }
    
    .popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
        color: black;
        font-size: 24px;
        cursor: pointer;
    }
    
    /* Additional styles for responsiveness */
    @media screen and (max-width: 768px) {
        .popup-content {
            width: 80%;
            height: 80%;
        }
    }
  .qr-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .popup-content p{
      color: black;
    }
  .rate{

    position: absolute;
    bottom: 40px;
    left: 50%;
    color: blue;
    transform: translateX(-50%);

  }
    .qr-image-container img {
        max-width: 100%;
        max-height: 100%;
        margin-bottom: 120px;
    }
</style>

</body>
</html>
