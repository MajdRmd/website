<!DOCTYPE html>
<html>
 
<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />

<!-- Leaflet JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder/dist/Control.Geocoder.css">
	<script type="text/javascript" src="secondd.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="test.css">

	<script type="text/javascript" src="secondd.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

           <?php
    session_start();
     $username = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';

    ?>
 <style type="text/css">
 	 #map{
    height: 400px;
  }
  button#cart-button {
    width: 150px; /* Adjust the width value as needed */
    cursor: pointer;
    margin-bottom: 10px;
}
   #search-container {
            text-align: center;
        }

        #search-input {
            padding: 8px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
  
    .dropdown-content {
       display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
        z-index: 1;
        top: calc(8.5% + 10px); /* Adjust the top position as needed */
        right: 0px; /* Align the dropdown to the right */
        top:30px;
    }
  


    .dropdown-content a {
        color: black;
        padding: 8px 0;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .show {
        display: block;
    }
    .material-symbols-outlined {
      cursor: pointer;
      display: flex;
      margin-left: -120px;
    }


    .container {
      display: flex;
    }


 </style>
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	<meta charset="utf-8">
    <style type="text/css">
     
</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>


</head>

<body>
<main>
    <div class="act-bar">
            <div class="act-item">
                <img src="logo.png" alt="button" id="im" onclick="home()">
    </div>
    <div class="act-item"> <a href="index.php" onclick="homepage()">Home</a></div>
    <div class="act-item"> <a href="men.php" onclick="shop()">Shop Now</a></div>
<div class="act-item"> <a href="about.php" onclick="about()">About Us</a></div>
 <div class="act-item">
        <a  onclick="openCart()">Cart </a>
        <div id="cart-count"></div>

    </div>
 <div class="act-item" id="username">
        <?php
            // Start the session to access session variables
            $username = isset($_SESSION['user']) ? $_SESSION['user']['username'] : '<a href="login.php">Login</a>';
            // Check if the user is logged in; otherwise, display "Login" as a clickable link
            if (is_array($username)) {
                $username = implode(", ", $username);
            }
            echo $username;
        ?></div>
        <div class="act-item">
          <span class="material-symbols-outlined" onclick="toggleDropdown()">
                arrow_drop_down
            </span>
            <div class="dropdown-content" id="dropdown-content">
                <a href="settings.php">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
    </div>
</div>
<div id="modal" class="modal"></div>
<div id="cart-popup" class="cart-popup">
    <div class="cart-content">
        <span class="close" onclick="closeCart()">&times;</span>
        <h3>Shopping Cart</h3>
        <div id="cart-items"></div>
        <button onclick="showPaymentOptions()">Checkout</button>
        <div id="payment-modal" class="modal">
  <div class="modal-content">
     <span class="close" onclick="closePaymentModal()">&times;</span>
    <h2>Choose Payment Method</h2>
    <p>Please select your preferred payment method:</p>
    <button onclick="payByCash()">Cash on Delivery</button>
    <button onclick="payByCreditCard()">Credit Card</button>
  </div>
</div>
    </div>

</div>


<table cellspacing="5">
	<tr>
		<td><div id="hood" style="position: relative;"><img src="blue-shirtpocket.png" alt="Image">
         <div id="discount-badge" style="position: absolute; top: 10px; right: 100px; background-color: #ef233c; color: white; padding: 5px; font-size: 20px;">
          -30%
        </div>
        </div></td>

	</tr>
  <tr>
    <div id="itemname" value="ShirtPocket" hidden >ShirtPocket</div>
  </tr>
	<tr>
		<td><span style="text-decoration: line-through;">39.99$</span><br><div id="price">27.99$</div></td>

	</tr>

	<tr>


    <td>

     <div id="size">Size:</div>
      <select name="size" id="size-select">
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
      </select>
          			<div id="color">
  <label for="color-select">Select color:</label>
  <select name="color" id="color-select" onchange="changeColor()">
    <option value="blue">Blue</option>
    <option value="ecru">Ecru</option>
 
  </select>
  <br>
 
</div>
 <div id="search-container">
        <input type="text" id="search-input" placeholder="Search for a location" oninput="searchLocation()">
    </div>
    <div id="map"></div>

    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([33.8547, 35.8623], 10); // Set initial center and zoom level

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        map.on('click', function (e) {
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(e.latlng).addTo(map);
        });

        function searchLocation() {
            var location = document.getElementById('search-input').value;

            if (location) {
                var accessToken = 'pk.eyJ1IjoibWFqZHJtZCIsImEiOiJjbGoxbWl3bGkxN2xyM2xxaG5pMjBtNzY0In0.yImEwPzT2aR4oVZJLTzCAw';
                var geocodingUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${location}.json?country=LB&access_token=${accessToken}`;

                fetch(geocodingUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.features && data.features.length > 0) {
                            var result = data.features[0];

                            if (marker) {
                                map.removeLayer(marker);
                            }

                            map.setView([result.center[1], result.center[0]], 13);
                            marker = L.marker([result.center[1], result.center[0]]).addTo(map);
                        }
                    })
                    .catch(error => console.log(error));
            }
        }
    </script>



    </td>
  </tr>
	<tr><td><div id="confirm">Are you sure you want to purchase this item?</div>
	</td></tr>
</table>
    <div id="cart">
                <button onclick="addToCart()" type="button" id="cart-button">
                    Add to Cart
                </button>
</div>

</main>

    <footer>
    <p>Copyright &copy 2023 Clothing Website</p>
      <a href="https://www.instagram.com/lafamiliaplatform/" target="_blank" class="ig"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
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
    footer {
  background-color: #333;
  color: white;

  padding: 8.5px;
}

footer p {
  margin: 0;
  color: white;
}

footer ul {
  list-style: none;
 margin-left: -35px;

}
footer ul li a {
  color: skyblue; /* Set the text color of <a> elements within <li> elements to white */
text-transform: uppercase;
font-size: 13px;
}

</style>

</footer>

</body>
</html>