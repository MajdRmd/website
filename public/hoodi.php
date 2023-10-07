<!DOCTYPE html>
<html>
 
<head>
		<link rel="stylesheet" type="text/css" href="test.css">

	<script type="text/javascript" src="secondd.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

           <?php
    session_start();
     $username = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';

    ?>
 <style type="text/css">
  
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
    <div class="act-item"> <a href="afterlogin.php" onclick="homepage()">Home</a></div>
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
		<td><div id="hood"><img src="white-hoodie.png" alt="Image"></div></td>
	</tr>
  <tr>
    <div id="itemname" value="Hoodie" hidden >Hoodie</div>
  </tr>
	<tr>
		<td><div id="price">24.99$</div></td>

	</tr>

	<tr>


    <td>

      <div id="size" class="justify-content">Size:
      <select name="size" id="size-select">
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
      </select></div>
          			<div id="color" class="justify-content">
  <label for="color-select">Select color:</label>
  <select name="color" id="color-select" onchange="changeColor()">
    <option value="white">White</option>
    <option value="black">Black</option>
       <option value="blue">Blue</option>
  </select>
  <br>
 
</div>


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

<script type="text/javascript">
    function toggleDropdown() {
  var dropdownContent = document.getElementById("dropdown-content");
  dropdownContent.classList.toggle("show");
  var settingsLink = document.getElementById("settings-link");
  settingsLink.style.display = settingsLink.style.display === "none" ? "block" : "none";
  var logoutLink = document.getElementById("logout-link");
  logoutLink.style.display = logoutLink.style.display === "none" ? "block" : "none";
}

window.onclick = function(event) {
  if (!event.target.matches('.material-symbols-outlined')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        var settingsLink = document.getElementById("settings-link");
        settingsLink.style.display = "none";
        var logoutLink = document.getElementById("logout-link");
        logoutLink.style.display = "none";
      }
    }
  }
};

</script>
</main>
</body>
</html>