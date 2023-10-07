<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user']['id'];

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$db = "my_db";

// Create a new connection
$conn = mysqli_connect($host, $user, $password, $db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the field and value are set in the POST data
if (isset($_POST['field']) && isset($_POST['value'])) {
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Update the field in the database
    $sql = "UPDATE users SET $field = '$value' WHERE id = $userId";
    if (mysqli_query($conn, $sql)) {
        echo "Field updated successfully";
    } else {
        echo "Error updating field: " . mysqli_error($conn);
    }
}


// Fetch user information from the database based on the logged-in user ID
$sql = "SELECT name, username, password, email, gender, country FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);

// Display the user information if available
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row["name"];
    $username = $row["username"];
    $password = $row["password"];
    $email = $row["email"];
    $gender = $row["gender"];
    $country = $row["country"];

    // Fetch payment information from the database
$sqlPayment = "SELECT id, username, cname, cnumber, cdate, cvc FROM payments WHERE username = '$username'";
$resultPayment = mysqli_query($conn, $sqlPayment);

// Check if the field and value are set in the POST data
if (isset($_POST['field']) && isset($_POST['value'])) {
    $field = $_POST['field'];
    $value = $_POST['value'];


 if ($field === 'ccnumber') {
    // Update the cnumber field in the payments table
    $sql = "UPDATE payments SET cnumber = '$value' WHERE username = '$username'";
} elseif ($field === 'expiryDateMonth') {
    // Update the cdate field (month) in the payments table
    $sql = "UPDATE payments SET cdate = CONCAT('$value', '/', SUBSTRING_INDEX(cdate, '/', -1)) WHERE username = '$username'";
} elseif($field == 'cname'){

 $sql = "UPDATE payments SET cname = '$value' WHERE username = '$username'";
}elseif ($field === 'expiryDateYear') {
    // Update the cdate field (year) in the payments table
    $sql = "UPDATE payments SET cdate = CONCAT(SUBSTRING_INDEX(cdate, '/', 1), '/', '$value') WHERE username = '$username'";
} else {
    // Update other fields in the users table
    $sql = "UPDATE users SET $field = '$value' WHERE id = $userId";
}


    if (mysqli_query($conn, $sql)) {
        echo "Field updated successfully";
    } else {
        echo "Error updating field: " . mysqli_error($conn);
    }
}

// Display the payment information if available
if (mysqli_num_rows($resultPayment) > 0) {
    $rowPayment = mysqli_fetch_assoc($resultPayment);
    $paymentId = $rowPayment["id"];
    $cname = $rowPayment["cname"];
    $cnumber = $rowPayment["cnumber"];
    $cdate = $rowPayment["cdate"];
    list($cdate_month, $cdate_year) = explode('/', $cdate);
    $cvc = $rowPayment["cvc"];
} else {
    // Set default values if payment information is not available
    $paymentId = "";
    $cname = "";
    $cnumber = "";
    $cdate = "";
    $cvc = "";
    $cdate_month="";
    $cdate_year="";
}
    // Rest of the code...
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <style>

        .box {
  border: 1px solid black;
  border-radius: 5px;
  padding: 20px;
  margin: 20px;
}
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #DADDD8;
        }

        h1 {
            margin-bottom: 50px;
            margin-top: 30px;
            position: relative;
            
        }
        #username{
            font-size: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="password"] {
            width: 300px;
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
select{
    font-size: 20px;
    width: 100px;
   padding: 5px;
}
        .message {
            color: #f00;
            margin-top: 10px;
        }

        .field {
            margin-bottom: 20px;
        }

        .value {
            display: inline-block;
        }

        .edit-input {
            display: none;
            width: 300px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .button-container {
            margin-top: 10px;
        }

        .save-button,
        .cancel-button {
            margin-right: 5px;
        }

        .edit-icon {
            cursor: pointer;
            display: inline-block;
            transform: rotateZ(90deg);
        }
  
     .box {
            border: 3px solid black;
            border-radius: 5px;
            padding: 20px;
            margin: 20px;
            display: flex;
            height: 450px;
            font-size: 20px;
            margin-top: 120px;
        }

        .nav-line {
            width: 2px;
            background-color: #000;
            margin: 10px 0;
        }

        .navigation {
            display: flex;
            flex-direction: column;
            width: 150px;
        }

        .nav-item {
            border-radius: 5px;
            padding: 10px;
            background-color: #f0f0f0;
            cursor: pointer;
         
            margin-top: 70px;
        }

        .nav-item:hover {
            background-color: #45a049;
            color: white;
        }

        .nav-item.active {
            background-color: gray;
            color: white;
        }

        .section {
            flex-grow: 1;
            margin-left: 20px;
            border-left: 2px solid #000;
            padding-left: 20px;
        }

        .section:not(:first-child) {
            display: none;
        }
              .settings {
            position: absolute;
            top: 45px; /* Adjust this value as needed */
            left: 43px;
            text-decoration: underline;
        }
      
    </style>
</head>
<body>
 <h1 class="settings">Settings</h1>

    <?php
  

    // Check if the user is logged in
    if (!isset($_SESSION['user'])) {
        header("Location: login.php"); // Redirect to the login page if not logged in
        exit();
    }

    // Get the user ID from the session
    $userId = $_SESSION['user']['id'];

    // Database configuration
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "my_db";

    // Create a new connection
    $conn = mysqli_connect($host, $user, $password, $db);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch user information from the database based on the logged-in user ID
    $sql = "SELECT name, username, email, gender, country FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    // Display the user information if available
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $username = $row["username"];
        $email = $row["email"];
        $gender = $row["gender"];
        $country = $row["country"];

       
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
<div class="box">

    <div class="navigation">
         <div class="nav-item" onclick="showSection('profile')">Account Information</div>
    <div class="nav-item" onclick="showSection('security')">Security</div>
    <div class="nav-item" onclick="showSection('payments')">Payments</div>
        <div class="nav-line"></div>
  </div>
   <div class="sections">
        
   <section id="profile" class="section" style="display: none;">
    <h1>Profile</h1>

    <div class="field" data-field="name">
        <label style="font-weight: bold;">Full Name:</label>
        <span class="value" id="nameValue"><span id="nameText"><?php echo $name ?></span></span>
        <span class="edit-icon" onclick="toggleEditMode('name')">✎</span>
        <input type="text" id="nameField" class="edit-input">
        <div class="button-container">
            <input type="submit" class="save-button" value="Save" onclick="saveEdit('name')">
            <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('fullName')">
        </div>
    </div>

    <div class="field" data-field="bio">
        <label style="font-weight: bold;">Your Bio:</label>
        <span class="value" id="bioValue">
            <span id="bioText">A front-end developer that focuses more on user interface design, a web interface wizard, a connector of awesomeness.</span>
        </span>
        <span class="edit-icon" onclick="toggleEditMode('bio')">✎</span>
        <textarea id="bioField" class="edit-input" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"></textarea>
        <div class="button-container">
            <input type="submit" class="save-button" value="Save" onclick="saveEdit('bio')">
            <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('bio')">
        </div>
    </div>

   <div class="field" data-field="gender">
        <label style="font-weight: bold;">Gender:</label>
        <span class="value" id="genderValue">
            <span id="genderText"><?php echo $gender; ?></span>
        </span>
        <span class="edit-icon" onclick="toggleEditMode('gender')">✎</span>
        <select id="genderField" class="edit-input">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <div class="button-container">
            <input type="submit" class="save-button" value="Save" onclick="saveEdit('gender')">
            <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('gender')">
        </div>
    </div>

    <div class="field" data-field="country">
        <label style="font-weight: bold;">Country:</label>
        <span class="value" id="countryValue">
            <span id="countryText"><?php echo $country ?></span>
        </span>
        <span class="edit-icon" onclick="toggleEditMode('country')">✎</span>
        <select id="countryField" class="edit-input">
            <option value="LB">LB</option>
            <option value="PLN">PLN</option>
            <option value="SYR">SYR</option>
        </select>
        <div class="button-container">
            <input type="submit" class="save-button" value="Save" onclick="saveEdit('country')">
            <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('country')">
        </div>
    </div>
</section>




    <!-- Add the remaining sections and forms for Security and Payments -->
   <section id="payments" class="section" style="display: none;"><h1>Payments</h1>
   <div class="field" data-field="cname"> <label style="font-weight: bold;"> Credit Card Name Holder: </label>
    <span class="value" id="cnameValue"><span id="cnameText"><?php echo $cname?></span></span>

    <span class="edit-icon" onclick="toggleEditMode('cname')">✎</span>
    <input type="text" id="cnameField" class="edit-input">
    <div class="button-container">
        <input type="submit" class="save-button" value="Save" onclick="saveEdit('cname')">
        <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('cname')">
    </div>
</div>

<div class="field" data-field="ccnumber">   <label style="font-weight: bold;">Credit Card Number: </label>
    <span class="value" id="ccnumberValue"><span id="ccnumberText"><?php echo $cnumber?></span></span>
    <span class="edit-icon" onclick="toggleEditMode('ccnumber')">✎</span>
    <input type="text" id="ccnumberField" class="edit-input">
    <div class="button-container">
        <input type="submit" class="save-button" value="Save" onclick="return validateCreditCard() && saveEdit('ccnumber')">
        <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('ccnumber')">
    </div>
</div>


    <div class="field" data-field="expiryDateMonth">
      <label style="font-weight: bold;">Credit Card Expiry Date</label>
        <span class="value" id="expiryDateMonthValue">
            <span id="expiryDateMonthText"><?php echo $cdate_month ?></span>
        </span>
        <span class="edit-icon" onclick="toggleEditMode('expiryDateMonth');">✎</span>
     <select name="cdate_month" id="expiryDateMonthField" class="edit-input"> 
<option value="01" <?php if ($cdate_month == '01') echo 'selected'; ?>>01</option>
<option value="02" <?php if ($cdate_month == '02') echo 'selected'; ?>>02</option>
<option value="03" <?php if ($cdate_month == '03') echo 'selected'; ?>>03</option>
<option value="04" <?php if ($cdate_month == '04') echo 'selected'; ?>>04</option>
<option value="05" <?php if ($cdate_month == '05') echo 'selected'; ?>>05</option>
<option value="06" <?php if ($cdate_month == '06') echo 'selected'; ?>>06</option>
<option value="07" <?php if ($cdate_month == '07') echo 'selected'; ?>>07</option>
<option value="08" <?php if ($cdate_month == '08') echo 'selected'; ?>>08</option>
<option value="09" <?php if ($cdate_month == '09') echo 'selected'; ?>>09</option>
<option value="10" <?php if ($cdate_month == '10') echo 'selected'; ?>>10</option>
<option value="11" <?php if ($cdate_month == '11') echo 'selected'; ?>>11</option>
<option value="12" <?php if ($cdate_month == '12') echo 'selected'; ?>>12</option>
</select>
<div class="button-container">
            <input type="submit" class="save-button" value="Save" onclick="saveEdit('expiryDateMonth')">
            <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('expiryDateMonth')">
        </div>
</div>
 <div class="field" data-field="expiryDateYear">
        <span class="value" id="expiryDateYearValue">
            <span id="expiryDateYearText"><?php echo $cdate_year ?></span>
        </span>
        <span class="edit-icon" onclick="toggleEditMode('expiryDateYear');">✎</span>
<select name="cdate_year" id="expiryDateYearField" class="edit-input"> 
<option value="2024" <?php if ($cdate_year == '2024') echo 'selected'; ?>>2024</option>
<option value="2025" <?php if ($cdate_year == '2025') echo 'selected'; ?>>2025</option>
<option value="2026" <?php if ($cdate_year == '2026') echo 'selected'; ?>>2026</option>
<option value="2027" <?php if ($cdate_year == '2027') echo 'selected'; ?>>2027</option>
</select>
<div class="button-container">
            <input type="submit" class="save-button" value="Save" onclick="saveEdit('expiryDateYear')">
            <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('expiryDateYear')">
        </div>

</div>
    <div class="field" data-field="cccvc" >  <label style="font-weight: bold;"> Credit Card CVC: </label>
         <span class="value" id="cccvcValue"><span id="cccvcText"><?php echo $cvc?></span></span>
    <span class="edit-icon" onclick="toggleEditMode('cccvc')">✎</span>
    <input type="text" id="cccvcField" class="edit-input" pattern="\d{3}" required>
    <div class="button-container">
        <input type="submit" class="save-button" value="Save" onclick="handleEdit('cccvc')">
        <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('cccvc')">
    </div></div>

</section>




<section id="security" class="section" style="display: none;">
  <h1>Security</h1>
  <div class="field" data-field="username">
    <label style="font-weight: bold;">Username:</label>
    <span class="value" id="usernameValue"><span id="usernameText"><?php echo $username ?></span></span>
    <span class="edit-icon" onclick="toggleEditMode('username')">✎</span>
    <input type="text" id="usernameField" class="edit-input">
    <div class="button-container">
      <input type="submit" class="save-button" value="Save" onclick="saveEdit('username')">
      <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('username')">
    </div>
  </div>

  <div class="field" data-field="password">
    <label style="font-weight: bold;">Password:</label>
    <span class="value" id="passwordValue"><span id="passwordText"><?php echo $password ?></span></span>
    <span class="edit-icon" onclick="toggleEditMode('password')">✎</span>
    <input type="password" id="passwordField" class="edit-input">
    <div class="button-container">
      <input type="submit" class="save-button" value="Save" onclick="saveEdit('password')">
      <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('password')">
    </div>
  </div>


  <div class="field" data-field="email">
    <label style="font-weight: bold;">Email:</label>
    <span class="value" id="emailValue"><span id="emailText"><?php echo $email ?></span></span>
    <span class="edit-icon" onclick="toggleEditMode('email')">✎</span>
    <input type="email" id="emailField" class="edit-input">
    <div class="button-container">
      <input type="submit" class="save-button" value="Save" onclick="saveEdit('email')">
      <input type="submit" class="cancel-button" value="Cancel" onclick="cancelEdit('email')">
    </div>
  </div>
</section>

</div>
</div>
    <!-- ... -->

    <script>
       function toggleEditMode(fieldName) {
    var valueElement = document.getElementById(fieldName + 'Value');
    var editIcon = document.querySelector('.field[data-field="' + fieldName + '"] > .edit-icon');
    var inputField = document.getElementById(fieldName + 'Field');
    var buttonContainer = document.querySelector('.field[data-field="' + fieldName + '"] > .button-container');

    if (valueElement.style.display === 'none') {
        // Cancel editing if already in edit mode
        cancelEdit(fieldName);
    } else {
        valueElement.style.display = 'none';
        editIcon.style.display = 'none';
        inputField.value = valueElement.innerText; // Set the input field value
        inputField.style.display = 'inline-block';
        buttonContainer.style.display = 'inline-block';
        inputField.focus(); // Set focus on the input field
    }
}

function saveEdit(fieldName) {
    var valueElement = document.getElementById(fieldName + 'Value');
    var editIcon = document.querySelector('.field[data-field="' + fieldName + '"] > .edit-icon');
    var inputField = document.getElementById(fieldName + 'Field');
    var buttonContainer = document.querySelector('.field[data-field="' + fieldName + '"] > .button-container');

    var newValue = inputField.value; // Get the new value from the input field

    if (fieldName === 'ccnumber') {
        var ccNumber = newValue.replace(/\s|-/g, ''); // Remove whitespace and "-" characters
        if (ccNumber.length !== 16 || !(/^\d+$/.test(ccNumber))) {
            alert('Credit card number should be 16 digits.');
            return;
        }
    } else if (fieldName === 'cccvc') {
        var cvcValue = newValue.trim();
        if (cvcValue !== '' && cvcValue.length >4) {
            alert('Credit card CVC should be less than 4 digits.');
            return;
        }
    }

    // Send an AJAX request to update the field in the database
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Update the displayed text and hide the input field and buttons
            valueElement.innerText = newValue;
            valueElement.style.display = 'inline-block';
            editIcon.style.display = 'inline-block';
            inputField.style.display = 'none';
            buttonContainer.style.display = 'none';
        }
    };
    xhttp.open("POST", "", true); // Empty URL to send the request to the same file
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("field=" + fieldName + "&value=" + encodeURIComponent(newValue));
}

function cancelEdit(fieldName) {
    var valueElement = document.getElementById(fieldName + 'Value');
    var editIcon = document.querySelector('.field[data-field="' + fieldName + '"] > .edit-icon');
    var inputField = document.getElementById(fieldName + 'Field');
    var buttonContainer = document.querySelector('.field[data-field="' + fieldName + '"] > .button-container');

    inputField.value = valueElement.innerText; // Restore the original text

    valueElement.style.display = 'inline-block';
    editIcon.style.display = 'inline-block';
    inputField.style.display = 'none';
    buttonContainer.style.display = 'none';
}

function validateCreditCard() {
    var ccnumberValue = ccnumberField.value.replace(/\s|-/g, ''); // Remove whitespace and "-" characters
    var cccvcValue = cccvcField.value.trim();

    if (ccnumberValue.length !== 16) {
        alert('Credit card number should be 16 digits.');
        return false;
    }

    if (cccvcValue !== '' && cccvcValue.length > 4) {
        alert('Credit card CVC should be less than 4 digits.');
        return false;
    }

    return true;
}



var ccnumberField = document.getElementById('ccnumberField');
    ccnumberField.addEventListener('input', function(event) {
        var inputValue = event.target.value.replace(/\s/g, '');
        var formattedValue = inputValue.replace(/(\d{4})(?=\d)/g, '$1-');
        ccnumberField.value = formattedValue;
    });

        // Hide the Save and Cancel buttons initially
        var buttonContainers = document.getElementsByClassName('button-container');
        for (var i = 0; i < buttonContainers.length; i++) {
            buttonContainers[i].style.display = 'none';
        }
        function savePaymentInfo() {
            // Get the values from the input fields
            var username = document.getElementById('usernameText').innerText;
            var cname = document.getElementById('cnameField').value;
            var cnumber = document.getElementById('ccnumberField').value;
            var cdate_month = document.getElementsByName('cdate_month')[0].value;
            var cdate_year = document.getElementsByName('cdate_year')[0].value;
            var cdate = cdate_month + '/' + cdate_year;
            var cvc = document.getElementById('cccvcField').value;

            // Check if all fields are filled
            if (username.trim() === '' || cname.trim() === '' || cnumber.trim() === '' || cdate.trim() === '' || cvc.trim() === '') {
                alert('Please fill in all payment information.');
                return;
            }

            // Send an AJAX request to save the payment information to the database
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Handle the response from the server if needed
                    console.log(this.responseText);
                }
            };
            xhttp.open("POST", "save_payment.php", true); // Update the URL with the actual PHP file to handle the request
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("username=" + encodeURIComponent(username) + "&cname=" + encodeURIComponent(cname) + "&cnumber=" + encodeURIComponent(cnumber) + "&cdate=" + encodeURIComponent(cdate) + "&cvc=" + encodeURIComponent(cvc));
        }


/////////////



        function handleEdit(fieldName) {
    var valueElement = document.getElementById(fieldName + 'Value');
    var editIcon = document.querySelector('.field[data-field="' + fieldName + '"] > .edit-icon');
    var inputField = document.getElementById(fieldName + 'Field');
    var buttonContainer = document.querySelector('.field[data-field="' + fieldName + '"] > .button-container');

    if (inputField.style.display === 'none') {
        // Enter edit mode
        inputField.value = valueElement.innerText;
        valueElement.style.display = 'none';
        editIcon.style.display = 'none';
        inputField.style.display = 'inline-block';
        buttonContainer.style.display = 'inline-block';
    } else {
        // Exit edit mode
        var newValue = inputField.value;

       
         if (fieldName === 'cccvc') {
            var cvcValue = newValue.trim();
            if (cvcValue !== '' && cvcValue.length > 4) {
                alert('Credit card CVC should be less than 4 digits.');
                return;
            }
             else if (cvcValue !== '' && cvcValue.length < 3) {
                alert('Credit card CVC should be greater than 3 digits.');
                return;
            }
              var username = document.getElementById('usernameText').innerText;
        var cname = document.getElementById('cnameField').value;
        var cnumber = document.getElementById('ccnumberField').value;
        var cdate_month = document.getElementsByName('cdate_month')[0].value;
        var cdate_year = document.getElementsByName('cdate_year')[0].value;
        var cdate = cdate_month + '/' + cdate_year;
        var cvc = document.getElementById('cccvcField').value;
        }

        // Get the values from the input fields
      

        // Check if all fields are filled
        console.log("Sending AJAX request with the following data:");
console.log("username:", username);
console.log("cname:", cname);
console.log("cnumber:", cnumber);
console.log("cdate:", cdate);
console.log("cvc:", cvc);
        // Send an AJAX request to save or update the payment information in the database
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response from the server if needed
                console.log(this.responseText);

                // Update the displayed text and hide the input field and buttons
                valueElement.innerText = newValue;
                valueElement.style.display = 'inline-block';
                editIcon.style.display = 'inline-block';
                inputField.style.display = 'none';
                buttonContainer.style.display = 'none';
            }
        };
        xhttp.open("POST", "save_payment.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username=" + encodeURIComponent(username) + "&cname=" + encodeURIComponent(cname) + "&cnumber=" + encodeURIComponent(cnumber) + "&cdate=" + encodeURIComponent(cdate) + "&cvc=" + encodeURIComponent(cvc));
    }
}
window.addEventListener('DOMContentLoaded', function() {
  // Show the "Security" section by default
  showSection('profile');

  // Add click event listeners to navigation items
  var navItems = document.getElementsByClassName('nav-item');
  for (var i = 0; i < navItems.length; i++) {
    navItems[i].addEventListener('click', handleNavigationClick);
  }
});

function handleNavigationClick(event) {
  // Get the selected section from the data attribute
  var sectionId = event.target.getAttribute('data-section');

  // Show the selected section and hide other sections
  showSection(sectionId);
}

function showSection(sectionId) {
  // Hide all sections
  var sections = document.getElementsByClassName('section');
  for (var i = 0; i < sections.length; i++) {
    sections[i].style.display = 'none';
  }

  // Remove the "active" class from all navigation items
  var navItems = document.getElementsByClassName('nav-item');
  for (var i = 0; i < navItems.length; i++) {
    navItems[i].classList.remove('active');
  }

  // Show selected section and set the corresponding navigation item as active
  document.getElementById(sectionId).style.display = 'block';
  document.querySelector('.nav-item[data-section="' + sectionId + '"]').classList.add('active');
}


    </script>
</body>
</html>