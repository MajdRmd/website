<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="items.css">
    <script type="text/javascript" src="second.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
<div class="act-bar">
    <div class="act-item">
        <img src="logo.png" alt="button" id="im" onclick="home()">
    </div>
    <div class="act-item"> <a href="afterlogin.php" onclick="homepage()">Home</a></div>
    <div class="act-item"> <a href="shop.php" onclick="shop()">Shop Now</a></div>
    <div class="act-item"> <a href="about.php" onclick="about()">About Us</a></div>
</div>
<table cellspacing="5">
    <tr>
        <td><div id="hood"><img src="white-hoodie.png" alt="Image"></div></td>
    </tr>
    <tr>
        <td><div id="price">25$</div></td>
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
            </div>
            <div id="payment">
                <label for="payment-select">Payment Method:</label>
                <select name="paymentMethod" id="payment-select" onchange="toggleVisaCardContainer()">
                    <option value="cod">Cash on Delivery</option>
                    <option value="visa">By Visa</option>
                </select>
            </div>
            <div id="visa-card-container" style="display: none;">
                <?php
                // Check if the payment method is "By Visa"
                if ($paymentMethod == "visa") {
                    // Check if the user has a saved Visa card
                    if ($result->num_rows > 0) {
                        // User has a saved Visa card, display the card details
                        echo "Card Holder: " . $cname . "<br>";
                        echo "Card Number: " . $cnumber . "<br>";
                        echo "Expiration Date: " . $cdate . "<br>";
                        echo "CVC: " . $cvc . "<br>";
                    } else {
                        // User does not have a saved Visa card, redirect to credit.php
                        echo "You don't have a saved Visa card. Please add a Visa card <a href='credit.php'>here</a>.";
                    }
                }
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td><div id="confirm">Are you sure you want to purchase this item?</div></td>
    </tr>
</table>
<form action="hoodie.php" method="post">
    <button onclick="makePurchase()" type="submit" name="purchase" id="confirm">Purchase</button>
    <script>
        function makePurchase() {
            var size = document.getElementById("size-select").value;
            var color = document.getElementById("color-select").value;
            if (confirm('Are you sure you want to purchase this item in size ' + size + ' ' + color + '?')) {
                var form = document.forms[0];
                var inputSize = document.createElement("input");
                inputSize.setAttribute("type", "hidden");
                inputSize.setAttribute("name", "size");
                inputSize.setAttribute("value", size);
                form.appendChild(inputSize);

                var inputColor = document.createElement("input");
                inputColor.setAttribute("type", "hidden");
                inputColor.setAttribute("name", "color");
                inputColor.setAttribute("value", color);
                form.appendChild(inputColor);

                // Redirect to the hoodiecancel.html page after form submission
                window.location.href = 'hoodiecancel.html?color=' + document.getElementById('color-select').value;
                form.submit();
            } else {
                // Prevent the form from submitting
                event.preventDefault();
                return false;
            }
        }

        function changeColor() {
            var colorSelect = document.getElementById("color-select");
            var color = colorSelect.value;
            var hood = document.getElementById("hood");
            hood.innerHTML = "<img src='" + color + "-hoodie.png' alt='Image'>";
        }

        function toggleVisaCardContainer() {
            var paymentSelect = document.getElementById("payment-select");
            var visaCardContainer = document.getElementById("visa-card-container");

            if (paymentSelect.value === "visa") {
                visaCardContainer.style.display = "block";
            } else {
                visaCardContainer.style.display = "none";
            }
        }
    </script>
</form>
</body>
</html>
