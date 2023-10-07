function hoodie(){
  window.location.href="hoodie.html"
}
function jeans(){
  window.location.href="jeans.html"
}
function shoes(){
  window.location.href="shoes.html"
}
function shirt(){
  window.location.href="shirt.html"
}
function polo(){
  window.location.href="polo.html"
}
function tshirt(){
  window.location.href="tshirt.html"
}
function jacket(){
  window.location.href="jacket.html"
}
function short(){
  window.location.href="short.html"
}
function home(){
  window.location.href="afterlogin.php"
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
const searchButton = document.querySelector('#search-button');
searchButton.addEventListener('click', performSearch);

function performSearch() {
  const searchTerm = document.querySelector('#search-input').value.toLowerCase();
  const products = document.querySelectorAll('.product');

  products.forEach(product => {
    const productName = product.textContent.toLowerCase();
    if (productName.includes(searchTerm)) {
      product.style.display = 'block';
    } else {
      product.style.display = 'none';
    }
  });
}

var isZoomed = false;

  // Define a function to toggle the zoom in/out effect
  function toggleZoom() {
    var flipCard = document.getElementById("myFlipCard");
    if (isZoomed) {
      flipCard.classList.remove("zoom-in");
      isZoomed = false;
    } else {
      flipCard.classList.add("zoom-in");
      isZoomed = true;
    }
  }
// Mapping object for item names and their corresponding image prefixes
window.addEventListener('load', function() {
  // Rest of the code...

  // Hide the cart popup on page load
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
});

var itemImagePrefix = {
  'Hoodie': 'hoodie',
  'jeans': 'jeans',
  'Polo': 'polo',
  'Shirt': 'shirt'
};

// Add event listener for page load
window.addEventListener('load', function() {
  // Rest of the code...

  // Hide the cart popup on page load
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
});

function addToCart() {
  var size = document.getElementById("size-select").value;
  var color = document.getElementById("color-select").value;

  var itemName = document.getElementById("itemname").innerText; // Replace with the actual default item name
  var itemPrice = document.getElementById("price").innerText; // Replace with the actual default item price

  // Get the selected item name and price if available
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
}

function removeItem(index) {
  var cartItems = JSON.parse(localStorage.getItem('cart'));

  if (cartItems && cartItems.length > index) {
    cartItems.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cartItems));
    openCart(); // Refresh the cart display after removing an item
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
      // Construct the image source dynamically based on the item name and color
      var imagePrefix = itemImagePrefix[item.name];
      itemImage.src =  item.color + "-" + imagePrefix + ".png";
      itemImage.alt = "Item Image";
      itemImage.classList.add("item-image");

      var removeButton = document.createElement("span");
      removeButton.innerHTML = "&#10005;"; // Use 'x' symbol as the button content
      removeButton.classList.add("remove-button");
      removeButton.onclick = removeItem.bind(null, i);

      itemImageDiv.appendChild(removeButton); // Add the remove button to the item image div
      itemImageDiv.appendChild(itemImage);
      cartItemDiv.appendChild(itemImageDiv);

       var itemInfoDiv = document.createElement("div");
            itemInfoDiv.classList.add("cart-item-info");

            var itemName = document.createElement("span");
            
            itemName.classList.add("cart-item-name");

            var itemPrice = document.createElement("span");
           
            itemPrice.classList.add("cart-item-price");

          var itemDetails = document.createElement("span");
itemDetails.innerText = "Name: " + item.name + ", Price: " + item.price + ", Color: " + item.color + ", Size: " + item.size;
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
}

function closeCart() {
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
}
window.addEventListener('load', function() {
  // Rest of the code...

  // Hide the cart popup on page load
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
});

var itemImagePrefix = {
  'Hoodie': 'hoodie',
  'jeans': 'jeans',
  'Polo': 'polo',
  'Shirt': 'shirt'
};

// Add event listener for page load
window.addEventListener('load', function() {
  // Rest of the code...

  // Hide the cart popup on page load
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
});
var itemName = document.getElementById("itemname").innerText;

function addToCart() {
  var size = document.getElementById("size-select").value;
  var color = document.getElementById("color-select").value;

  var itemName = document.getElementById("itemname").innerText; // Replace with the actual default item name
  var itemPrice = document.getElementById("price").innerText; // Replace with the actual default item price

  // Get the selected item name and price if available
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
}

function removeItem(index) {
  var cartItems = JSON.parse(localStorage.getItem('cart'));

  if (cartItems && cartItems.length > index) {
    cartItems.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cartItems));
    openCart(); // Refresh the cart display after removing an item
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
      // Construct the image source dynamically based on the item name and color
      var imagePrefix = itemImagePrefix[item.name];
      itemImage.src =  item.color + "-" + imagePrefix + ".png";
      itemImage.alt = "Item Image";
      itemImage.classList.add("item-image");

      var removeButton = document.createElement("span");
      removeButton.innerHTML = "&#10005;"; // Use 'x' symbol as the button content
      removeButton.classList.add("remove-button");
      removeButton.onclick = removeItem.bind(null, i);

      itemImageDiv.appendChild(removeButton); // Add the remove button to the item image div
      itemImageDiv.appendChild(itemImage);
      cartItemDiv.appendChild(itemImageDiv);

       var itemInfoDiv = document.createElement("div");
            itemInfoDiv.classList.add("cart-item-info");

            var itemName = document.createElement("span");
            
            itemName.classList.add("cart-item-name");

            var itemPrice = document.createElement("span");
           
            itemPrice.classList.add("cart-item-price");

          var itemDetails = document.createElement("span");
itemDetails.innerText = "Name: " + item.name + ", Price: " + item.price + ", Color: " + item.color + ", Size: " + item.size;
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
}

function closeCart() {
  var cartPopup = document.getElementById("cart-popup");
  cartPopup.style.display = "none";
}



function changeColor() {
  var colorSelect = document.getElementById("color-select");
  var color = colorSelect.value;
  var itemName = document.getElementById("itemname").innerText;
  var hood = document.getElementById("hood");
  hood.innerHTML = "<img src='" + color + "-" + itemName + ".png' alt='Image'>";
}

