<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="items.css">
  <script type="text/javascript" src="second.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style>
    .popup-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      width: 300px;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
      text-align: center;
      display: none;
    }

    .popup-close {
      position: absolute;
      top: 5px;
      right: 10px;
      cursor: pointer;
    }
  </style>
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
          <br>
          <span>Payment Method</span>
          <select name="paymentMethod" class="payment-method" onchange="showVisaPrompt()">
            <option value="cod">Cash on Delivery</option>
            <option value="visa">By Visa</option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div id="confirm">Are you sure you want to purchase this item?</div>
      </td>
    </tr>
  </table>

  <div class="popup-container" id="visa-popup">
    <span class="popup-close" onclick="closeVisaPopup()">&times;</span>
    <form id="visa-form">
      <?php
      // Replace with your database connection code
      $host = "localhost";
      $user = "root";
      $password = "";
      $db = "my_db";

      $conn = mysqli_connect($host, $user, $password, $db);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      session_start();
      $username = $_SESSION['user']['username'];

      $sql = "SELECT * FROM payments WHERE username='$username'";
      $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    echo "<h2>Select Visa</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<input type='radio' name='visaType' value='" . $row['username'] . "'>";
        echo $row['cname'] . " - Ending with " . substr($row['cnumber'], -4) . "<br>";
    }
    
   
} else {
    echo "<h2>No saved Visa found.</h2>";
 
}


        
      
      ?>
      <a href='credit.php'><strong>+</strong> Add New Visa</a><br>
      <input type="text" name="newVisaType" placeholder="New Visa Type" style="display: none;"><br><br>
      <button type="button" onclick="processVisaType()">Submit</button>
    </form>
  </div>

  <form action="hoodie.php" method="post">
    <button onclick="makePurchase()" type="submit" name="purchase" id="confirm">
      Purchase
    </button>
    <script>
      function makePurchase() {
  var size = document.getElementById("size-select").value;
  var color = document.getElementById("color-select").value;
  if (confirm('Are you sure you want to purchase this item in size ' + size +' '+ color + '?')) {
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
    window.location.href='hoodiecancel.html?color=' + document.getElementById('color-select').value;
    // Redirect to the hoodiecancel.html page after form submission
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

      function showVisaPrompt() {
        var selectedOption = document.querySelector(".payment-method").value;

        if (selectedOption === "visa") {
          document.getElementById("visa-popup").style.display = "block";
        } else {
          document.getElementById("visa-popup").style.display = "none";
        }
      }

      function closeVisaPopup() {
        document.getElementById("visa-popup").style.display = "none";
      }

      function processVisaType() {
        var visaTypeRadio = document.querySelector('input[name="visaType"]:checked');
        var visaType;
        if (visaTypeRadio && visaTypeRadio.value !== "add_new") {
          visaType = visaTypeRadio.value;
        } else {
          var newVisaTypeInput = document.querySelector('input[name="newVisaType"]');
          if (newVisaTypeInput && newVisaTypeInput.value.trim() !== "") {
            visaType = newVisaTypeInput.value.trim();
          } else {
            alert("Please enter a valid new Visa type.");
            return;
          }
        }

        // You can perform further processing or submission here
        // For now, let's just log the selected Visa type
        console.log("Selected Visa type: " + visaType);

        closeVisaPopup();
      }
    </script>
  </form>
</body>
</html>
