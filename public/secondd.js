var itemImagePrefix = {
  'Shoes' : 'shoes',
  'Hoodie': 'hoodie',
  'Jeans': 'jeans',
  'Polo': 'polo',
  'Shirt': 'shirt',
  'Jacket' : 'jacket',
  'tshirt' : 'tshirt',
  'TJeans' : 'TJeans',
  'trainers':'trainers',
  'ShirtPocket': 'ShirtPocket',
  'Basketball':'Basketball',
  'Short' : 'short'
};
        function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdown-content");
        dropdownContent.classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.material-symbols-outlined')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    };

var modal = document.getElementById("modal");

function isLoggedIn(callback) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        callback(response.isLoggedIn);
      } else {
        callback(false);
      }
    }
  };
  xhr.open('GET', 'isLoggedIn.php');
  xhr.send();
}

function updateCartCount() {
  var cartCount = document.getElementById("cart-count");
  var cartItems = JSON.parse(localStorage.getItem("cart"));

  if (cartItems && cartItems.length > 0) {
    cartCount.textContent = cartItems.length;
    cartCount.style.display = "block";
  } else {
    cartCount.style.display = "none";
  }
}
function handlePageLoad() {
  updateCartCount();
  isLoggedIn(function(isLoggedIn) {
    if (isLoggedIn) {
      // User is logged in
      // Perform any additional actions for a logged-in user
    } else {
      // User is logged out
      // Clear the cart and update the cart count
      localStorage.removeItem('cart');
      updateCartCount();
    }
  });
}
// Add event listener for page load
window.addEventListener('load', function() {
  handlePageLoad();
  updateCartCount();
  // Hide the cart popup on page load
  var cartPopup = document.getElementById("cart-popup");
  if (cartPopup) {
    cartPopup.style.display = "none";
  }
});


function addToCart() {
   isLoggedIn(function(isLoggedIn) {
    if (!isLoggedIn) {
      alert('Please log in to add items to your cart.');
      localStorage.removeItem('cart'); // Clear the cart
      updateCartCount();
      return;
    }

    var size = document.getElementById("size-select").value;
    var color = document.getElementById("color-select").value;

    var itemName = document.getElementById("itemname").innerText;
    var itemPrice = document.getElementById("price").innerText;

    var selectedItem = document.querySelector("#item-name-select option:checked");
    if (selectedItem) {
      itemName = selectedItem.innerText;
      itemPrice = selectedItem.getAttribute("data-price");
    }

    var item = {
      size: size,
      color: color,
      name: itemName,
      price: itemPrice
    };

    var cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    cartItems.push(item);
    localStorage.setItem('cart', JSON.stringify(cartItems));


    alert('Item added to your shopping cart!');
    updateCartCount();
  });
}

function removeItem(index) {
  var cartItems = JSON.parse(localStorage.getItem('cart'));

  if (cartItems && cartItems.length > index) {
    cartItems.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cartItems));
    updateCartCount();
    openCart();
  }
}

function openCart() {
  var cartPopup = document.getElementById("cart-popup");
  var cartItems = JSON.parse(localStorage.getItem('cart'));
  var cartContent = document.getElementById("cart-items");
  cartContent.innerHTML = '';

  if (cartItems && cartItems.length > 0) {
    for (var i = 0; i < cartItems.length; i++) {
      var item = cartItems[i];

      var cartItemDiv = document.createElement("div");
      cartItemDiv.classList.add("cart-item");

      var itemImageDiv = document.createElement("div");
      itemImageDiv.classList.add("cart-item-image");

      var itemImage = document.createElement("img");
      var imagePrefix = itemImagePrefix[item.name];
      itemImage.src =  item.color + "-" + imagePrefix + ".png";
      itemImage.alt = "Item Image";
      itemImage.classList.add("item-image");

      var removeButton = document.createElement("span");
      removeButton.innerHTML = "&#10005;";
      removeButton.classList.add("remove-button");
      removeButton.onclick = removeItem.bind(null, i);

      itemImageDiv.appendChild(removeButton);
      itemImageDiv.appendChild(itemImage);
      cartItemDiv.appendChild(itemImageDiv);

      var itemInfoDiv = document.createElement("div");
      itemInfoDiv.classList.add("cart-item-info");

     var itemName = document.createElement("span");
itemName.innerText = "Name: " + item.name;
itemName.classList.add("cart-item-name");

var itemPrice = document.createElement("span");
itemPrice.innerText = ", Price: " + item.price;
itemPrice.classList.add("cart-item-price");


   

      var itemDetails = document.createElement("span");
      itemDetails.innerText = ", Color: " + item.color + ", Size: " + item.size;
      itemDetails.classList.add("cart-item-details");

      itemInfoDiv.appendChild(itemName);
      itemInfoDiv.appendChild(itemPrice);
      itemInfoDiv.appendChild(itemDetails);

      cartItemDiv.appendChild(itemInfoDiv);
      cartContent.appendChild(cartItemDiv);
    }
  } else {
    var emptyCartDiv = document.createElement("div");
    emptyCartDiv.innerText = "Your cart is empty.";
    cartContent.appendChild(emptyCartDiv);
  }

  cartPopup.style.display = "block";
  modal.style.display = "block";
}

function closeCart() {
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
  modal.style.display = "block";
}

// Rest of the code...




// Function to show the payment options modal
// Function to show the payment options modal
function showPaymentOptions() {
  var cartItems = JSON.parse(localStorage.getItem('cart'));
  if (!cartItems || cartItems.length === 0) {
    alert("Your cart is empty. Please add items to your cart before proceeding to checkout.");
    return;
  }

  var cartContent = document.getElementById("cart-items");
  cartContent.classList.add("blur");

  var modal = document.getElementById("payment-modal");
  modal.style.display = "block";

  // Clear the existing content of the payment options modal
  var paymentModalContent = document.querySelector("#payment-modal .modal-content");
  paymentModalContent.innerHTML = '';

  // Create the close button
  var closeButton = document.createElement("span");
  closeButton.innerHTML = "&times;";
  closeButton.classList.add("close");
  closeButton.onclick = closePaymentModal;

  // Create the payment message
  var paymentMessage = document.createElement("p");
  paymentMessage.innerText = "Please choose your preferred payment option:";

  // Create the "Cash on Delivery" button
  var cashButton = document.createElement("button");
  cashButton.innerText = "Cash on Delivery";
  cashButton.onclick = payByCash;

  // Create the "Credit Card" button
  var creditCardButton = document.createElement("button");
  creditCardButton.innerText = "Credit Card";
  creditCardButton.onclick = showCreditCardOptions;

  // Add the elements to the payment options modal
  paymentModalContent.appendChild(closeButton);
  paymentModalContent.appendChild(paymentMessage);
  paymentModalContent.appendChild(cashButton);
  paymentModalContent.appendChild(creditCardButton);
}

function closePaymentModal() {
  var modal = document.getElementById("payment-modal");
  modal.style.display = "none";

  var cartContent = document.getElementById("cart-items");
  cartContent.classList.remove("blur");
}

function showCreditCardOptions() {

  // Clear the existing content of the payment options modal
  var paymentModalContent = document.querySelector("#payment-modal .modal-content");
  paymentModalContent.innerHTML = '';

  // Create the close button
  var closeButton = document.createElement("span");
  closeButton.innerHTML = "&times;";
  closeButton.className = "close-button";
  closeButton.onclick = closePaymentModal;

  // Create the radio button for "My Visa"
  var visaRadioButton = document.createElement("input");
  visaRadioButton.type = "radio";
  visaRadioButton.name = "creditCardOption";
  visaRadioButton.value = "myVisa";
  visaRadioButton.id = "visa-radio";

  var visaLabel = document.createElement("label");
  visaLabel.setAttribute("for", "visa-radio");
  var cardNumberContainer = document.createElement("div");
  cardNumberContainer.id = "card-number-container";

  

  // Fetch the card number from the database using AJAX
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var cardNumber = this.responseText;
      visaLabel.innerText = cardNumber;

       if (cardNumber === "") {
        visaRadioButton.style.display = "none";
      }
    }
  };
  xhttp.open("GET", "getCardNumber.php", true); // Replace "getCardNumber.php" with the actual PHP file name
  xhttp.send();

  // Create the "+ Add New Credit Card" link
  var addCreditCardLink = document.createElement("a");
  addCreditCardLink.href = "credit.php";
  addCreditCardLink.innerHTML = "<span style='margin-right: 5px;'>+</span>Add New Credit Card";

  // Create the "Pay" button
  var payButton = document.createElement("button");
  payButton.innerText = "Pay";
  payButton.onclick = payByCreditCard;

  // Add the elements to the payment options modal
  paymentModalContent.appendChild(closeButton);
  paymentModalContent.appendChild(visaRadioButton);
  paymentModalContent.appendChild(visaLabel);
  paymentModalContent.appendChild(document.createElement("br"));
  paymentModalContent.appendChild(addCreditCardLink);
  paymentModalContent.appendChild(document.createElement("br"));
  paymentModalContent.appendChild(payButton);

  // Set the width and height of the modal container
  var modalContainer = document.querySelector("#payment-modal .modal-container");
  modalContainer.style.width = "400px !important"; // Adjust the desired width
  modalContainer.style.height = "300px !important"; // Adjust the desired height
}

function closePaymentModal() {
  var paymentModal = document.getElementById("payment-modal");
  paymentModal.style.display = "none";
}
function confirmCreditCard() {
  var cvcInput = document.getElementById("cvc-input");
  var cvc = cvcInput.value;

  // Fetch the stored CVC from the database using AJAX
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var storedCvc = this.responseText;
      if (cvc === storedCvc) {
        payByCreditCard();
      } else {
        alert("Invalid CVC. Please try again.");
      }
    }
  };
  xhttp.open("GET", "getStoredCvc.php", true); // Replace "getStoredCvc.php" with the actual PHP file name
  xhttp.send();
}





// Function to handle payment by cash
function payByCash() {
  // Perform the necessary actions for cash payment
  // ...

  var cartContent = document.getElementById("cart-items");
  alert("Payment successful! Cash on Delivery.");
   cartContent.classList.remove("blur");
  // Close the payment options modal
  var modal = document.getElementById("payment-modal");
  modal.style.display = "none";
    var cartItems = JSON.parse(localStorage.getItem('cart')) || [];

  var items = [];

  for (var i = 0; i < cartItems.length; i++) {
    var item = cartItems[i];

    var size = item.size;
    var color = item.color;
    var itemName = item.name;
    

    var usernameElement = document.getElementById("username");

    var username = usernameElement ? usernameElement.innerHTML.trim() : "";

    var itemDetails = "Name: " + itemName +  ", Color: " + color + ", Size: " + size;

    var itemData = {
      category: itemName, // Replace with the actual category
      size: size,
      color: color,
      username: username,
      details: itemDetails
    };

    items.push(itemData);
    localStorage.removeItem('cart');
     updateCartCount();
       var cartContent = document.getElementById("cart-items");
  cartContent.innerHTML = "Your cart is empty.";
  }


  $.ajax({
    url: 'process_purchase.php',
    type: 'POST',
    data: {
      items: items
    },
    success: function(response) {
      console.log(response);
      deductQuantity(cartItems);
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
function deductQuantity(cartItems) {
  for (var i = 0; i < cartItems.length; i++) {
    var item = cartItems[i];
    var itemName = item.name;

    // AJAX request to deduct the quantity from the database
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          console.log(xhr.responseText);
        } else {
          console.error('Error deducting quantity: ' + xhr.status);
        }
      }
    };
    xhr.open('POST', 'deduct_quantity.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('item_name=' + encodeURIComponent(itemName));
  }

  // Clear the cart and update the UI
  localStorage.removeItem('cart');
  updateCartCount();
  var cartContent = document.getElementById("cart-items");
  cartContent.innerHTML = "Your cart is empty.";
}

}

// Function to handle payment by credit card
function payByCreditCard() {

  var cartContent = document.getElementById("cart-items");

   var visaRadioButton = document.getElementById("visa-radio");
  if (visaRadioButton && visaRadioButton.style.display === "none") {
    // Display an alert indicating no credit card found
    alert("No credit card found. Please add a new credit card.");
    return; // Stop further execution of the function
  }

  else if(!visaRadioButton.checked) {
    // Display an alert indicating no credit card selected
    alert("Please select your credit card.");
    return; // Stop further execution of the function
  
  }
  alert("Payment successful! The amount was deduced from your card.");
  cartContent.classList.remove("blur");

  // Close the payment options modal
  var modal = document.getElementById("payment-modal");
  modal.style.display = "none";

  var cartItems = JSON.parse(localStorage.getItem('cart')) || [];
  var items = [];

  for (var i = 0; i < cartItems.length; i++) {
    var item = cartItems[i];
    var size = item.size;
    var color = item.color;
    var itemName = item.name;
    var itemPrice = item.price;

    var usernameElement = document.getElementById("username");
    var username = usernameElement ? usernameElement.innerHTML.trim() : "";

    var itemDetails = "Name: " + itemName + ", Price: " + itemPrice + ", Color: " + color + ", Size: " + size;

    var itemData = {
      category: itemName, // Replace with the actual category
      price: itemPrice,
      size: size,
      color: color,
      username: username,
      details: itemDetails
    };

    items.push(itemData);
  }

  // AJAX request to insert purchase records into the database
  $.ajax({
    url: 'process_purchase.php',
    type: 'POST',
    data: {
      items: items
    },
    success: function(response) {
      console.log(response);
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });

  // Clear the cart and update the UI
  localStorage.removeItem('cart');
  updateCartCount();
  cartContent.innerHTML = "Your cart is empty.";
}


function changeColor() {
  var colorSelect = document.getElementById("color-select");
  var color = colorSelect.value;
  var itemName = document.getElementById("itemname").innerText;
  var hood = document.getElementById("hood");


  hood.innerHTML = "<img src='" + color + "-" + itemName.toLowerCase() + ".png' alt='Image'>";
       
}
window.addEventListener('load', function() {
  // Rest of the code...
updateCartCount();
  // Hide the cart popup on page load
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
});

function hoodie(){
  window.location.href="hoodie.php"
}
function trainers(){
  window.location.href="trainers.php"
}
function jeans(){
  window.location.href="jeans.php"
}
function taperedjeans(){
  window.location.href="tjeans.php"
}
function shoes(){
  window.location.href="shoes.php"
}
function shirt(){
  window.location.href="shirt.php"
}
function polo(){
  window.location.href="polo.php"
}
function tshirt(){
  window.location.href="tshirt.php"
}
function basketball(){
  window.location.href="basketball.php"
}
function shirtpocket(){
  window.location.href="shirtpocket.php"
}
function jacket(){
  window.location.href="jacket.php"
}
function short(){
  window.location.href="short.php"
}
function home(){
  window.location.href="index.php"
}
function login(){
window.location.href="welcome.html"
}
function about(){
  window.location.href="about.php"
}
function clothes(){
  window.location.href="shop.php"
}