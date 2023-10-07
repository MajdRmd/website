<!DOCTYPE html>
<html>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<head>
		<link rel="stylesheet" type="text/css" href="test.css">

	<script type="text/javascript" src="secondd.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>


</head>
<body>

<div class="act-bar">
<div class="act-item">
<img src="logo.png" alt="button" id="im" onclick="home()">

</div>

	<div class="act-item"> <a href="afterlogin.php" onclick="homepage()">Home</div>
	<div class="act-item"> <a href="shop.php" onclick="shop()">Shop Now</div>
<div class="act-item"> <a href="about.php" onclick="about()">About Us</div>
  <div class="act-item">
        <a href="#" onclick="openCart()">Cart</a>
    </div>
</div>

<div id="cart-popup" class="cart-popup">
    <div class="cart-content">
        <span class="close" onclick="closeCart()">&times;</span>
        <h3>Shopping Cart</h3>
        <div id="cart-items"></div>
        <button onclick="checkout()">Checkout</button>
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
    <option value="white">White</option>
    <option value="black">Black</option>
       <option value="blue">Blue</option>
  </select>
  <br>
  <span>Payment Method</span>
                <select name="paymentMethod" class="payment-method">
                    <option value="cod">Cash on Delivery</option>
                    <option value="visa">By Visa</option>
                </select>
</div>


    </td>
  </tr>
	<tr><td><div id="confirm">Are you sure you want to purchase this item?</div>
	</td>
</table>
<form action="hoodie.php" method="post">
    <div id="cart">
                <button onclick="addToCart()" type="button" id="cart-button">
                    Add to Cart
                </button>

</form>
</body>
</html>