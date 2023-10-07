    <!DOCTYPE html>
    <html>
    <head>
    	<link rel="stylesheet" type="text/css" href="shop.css">
    	<script type="text/javascript" src="secondd.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<title></title>
        <?php
    session_start();
     $username = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';

    ?>


    	<script type="text/javascript">



   function search() {
  // Get the user input
  const userInput = document.getElementById("search-input").value.toLowerCase();

  // Get all the items in the grid
  const items = document.querySelectorAll(".items");

  // Loop through all the items and hide the ones that don't match the user input
  let found = false; // flag to indicate whether any matching items were found
  items.forEach((item) => {
    const itemName = item.querySelector("h2").textContent.toLowerCase();
    if (itemName.includes(userInput)) {
      item.style.display = "block";
      found = true;
    } else {
      item.style.display = "none";
    }
  });

  
}


 function applyPriceSort() {
  const priceSortSelect = document.getElementById("price-sort");
  const selectedOption = priceSortSelect.value;

  const itemsContainer = document.getElementById("items-grid");
  const items = Array.from(itemsContainer.getElementsByClassName("items"));

  items.sort((a, b) => {
    const priceA = parseFloat(a.getAttribute("data-price"));
    const priceB = parseFloat(b.getAttribute("data-price"));

    if (selectedOption === "low-to-high") {
      return priceA - priceB;
    } else if (selectedOption === "high-to-low") {
      return priceB - priceA;
    }

    // If no valid option is selected, maintain the original order
    return 0;
  });

  // Clear the existing items
  itemsContainer.innerHTML = '';

  // Append sorted items back to the container
  items.forEach((item) => {
    itemsContainer.appendChild(item);
  });
}

function filterByCategory(category) {
  const items = document.querySelectorAll(".items");
  
  items.forEach((item) => {
    if (category === 'all' || item.classList.contains(category)) {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  });
}

function closePaymentModal() {
  var paymentModal = document.getElementById("payment-modal");
  paymentModal.style.display = "none";
  var modalOverlay = document.getElementById("modal");
  modalOverlay.style.display = "none";
  hidePaymentOptions();
}
function hidePaymentOptions() {
  var cartContent = document.getElementById("cart-items");
  cartContent.classList.remove("blur");
}

    </script>

    	
    <style type="text/css">
.act-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 70px;
  list-style: none;
  margin: 0;
  padding: 0;
  background-color: #333;
  color: #B5E3FC;
    position: relative;
  text-align: center;
}

.act-item {
  display: flex;
  align-items: center;
  font-size: 16px;
  cursor: pointer;
   padding: 0;
   margin: 100px;
     position: relative;
}


.act-item img {
  width: 105px;
  height: 45px;

}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}

.close-button:hover {
  color: red;
}

#payment-modal .modal-container {
  width: 400px;
  height: 300px;
}


.act-item a {
  display: flex;
  align-items: center;
  font-family: 'Dosis', sans-serif;
  color: #E6E6E7;
  margin: 0;
   padding: 0;
  text-decoration: none;
}

.act-item:hover {
  background-color: #444;
}

.act-item a:hover {
  color: #eee;
}

.act-item:first-child {
  margin-left: 20px;
}

#username {
  display: flex;
  align-items: center;
  font-size: 16px;
  margin-left: 60px; /* Push the username/login to the right */
}

#username a {
  color: white;
  text-decoration: none;
}

#username a:hover {
  text-decoration: underline;
}
#cart-count {
  position: absolute;
  top: -5px;
  right: -25px;
  display: inline-block;
  width: 20px;
  height: 20px;
  background-color: red;
  color: white;
  border-radius: 50%;
  text-align: center;
  font-size: 12px;
  font-weight: bold;
  line-height: 20px;
}


    .dropdown-content {
       display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
        z-index: 1;
        top: calc(8.5% + 10px); /* Adjust the top position as needed */
        right: 0; /* Align the dropdown to the right */
    }
        .price-filter select {
        margin-right: 10px;
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
      margin-left: -200px;
    }


    .container {
      display: flex;
    }

    .left-nav {
      width: 200px;
      background-color: #f1f1f1;
      padding: 10px;
    }

    .nav-item {
      display: block;
      padding: 8px 16px;
      color: #333;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .nav-item:hover {
      background-color: #ddd;
    }

    .nav-item.active {
      background-color: #ccc;
    }

    .items-table-container {
      flex-grow: 1;
      margin-top: -10px; /* Adjust this value as needed */
      margin-left: 20px;
    }



    	.search-bar {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 10px 0;
     padding-left: 400px;
     padding-right: 250px;
    }

    .search-bar input[type="text"] {
      width: 400px;
      height: 40px;
      font-size: 18px;
      border: none;
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      outline: none;
      transition: box-shadow 0.3s ease;
    }

    .search-bar input[type="text"]:focus {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
    }

    .search-bar button {
      width: 100px;
      height: 40px;
      margin-left: 10px;
      font-size: 18px;
      color: #fff;
      background-color: #333;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

#cart-popup {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 500px;
  max-width: 80%;
  max-height: 80%;
  padding: 20px;
  background-color: #e3e3e3;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  z-index: 9999;
  overflow: auto;
}

.cart-item-image {
  position: relative;
  display: inline-block;
  max-width: 50px; /* Adjust the maximum width as per your preference */
  height: auto;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

.cart-item-image {
    position: relative;
}

.remove-button {
    position: absolute;
    top: 5px;
    left: 65px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #FF2715;
    color: #F6F4F3;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
.item-image {
  width: 80px; /* Adjust the width as desired */
  height: auto; /* Maintain aspect ratio */
}

.items-image{
    width: 450px;
    height: auto;
}
    .search-bar button:hover {
      background-color: #444;
    }
    .price-filter {
      display: flex;
      align-items: center;
      justify-content: center; /* Add this line to center horizontally */
      margin-bottom: 10px;
    }

    .price-filter label {
      margin-right: 10px;
    }

    .price-filter select {
      height: 30px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 4px;
    }
      .items-table-container {
    display: flex;
    flex-wrap: wrap;
    margin-top: -10px;
    margin-left: 20px;
  }

  .items-table-container > div {
    flex: 1 1 300px; /* Set the width of each item */
    margin: 10px;
  }
  .items-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* Two items per row */
  grid-gap: 1px; /* Adjust the gap between items as needed */
  justify-content: center; /* Center the grid horizontally */
  margin-left: 300px; /* Adjust the left margin as needed */
}


.items {
    position: relative;
     width: 300px; 
  transition: transform 0.3s ease; /* Add a transition to the transform property */
}

.item-image img {
  width: 100%; /* Adjust the width as needed */
  height: auto;
}

.item-details {
    text-align: center;
  font-size: 14px; /* Adjust the font size as needed */
  padding: 10px;
}
.items:hover {
  transform: scale(1.08); /* Increase the size of the item on hover */
  z-index: 1; /* Bring the item to the front */
}
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
   max-width: 80%;
  max-height: 80%;

 
}
.close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
  border: 1px solid #888;
  max-width: 1000px;
  background-color: #fefefe;
  text-align: center;
}
.blur{
    filter: blur(5px);
    background-color: rgba(0, 0, 0, 0.4);
}
.discount-circle {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #ef233c;
  color: white;
  border-radius: 50%;
  padding: 5px;
  font-size: 12px;
}

    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    </head>
    <body>
     
            <main>
    	<div class="act-bar">
    		<div class="act-item">
    			<img src="logo.png" alt="button" id="im" onclick="home()">
	</div>
    <div class="act-item"> <a href="index.php" onclick="homepage()">Home</div>
    <div class="act-item"> <a href="men.php" onclick="shop()">Shop Now</div>
<div class="act-item"> <a href="about.php" onclick="about()">About Us</div>
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

  
           
     
    	<div class="category-bar">
    		<div class="category-item"><a href="men.php">Men</a></div>
    		<div class="category-item"><a href="women.html">Women</a></div>
    		
    	</div>
        
    	<div class="search-bar">
        <input type="text" placeholder="Search..." id="search-input" oninput="search()">
     
    </div>


    <div class="price-filter">
          <label>Category: </label> <select class="category-bar" onchange="filterByCategory(this.value)">
    <option value="all">All Categories</option>
    <option value="sale">Items On Sale</option>
    <option value="hoodie">Hoodie</option>
    <option value="jeans">Jeans</option>
    <option value="polo">Polo</option>
    <option value="shirt">Shirt</option>
    <option value="tshirt">T-Shirt</option>
    <option value="short">Short</option>
    <option value="jacket">Jacket</option>
    <option value="shoes">Shoes</option>

</select>
      <label for="price-sort">Sort by Price:</label>
      <select id="price-sort" onchange="applyPriceSort()">
        <option value="low-to-high">Low to High</option>
        <option value="high-to-low">High to Low</option>
      </select>
    </div>
  


<div class="items-grid" id="items-grid">

       <div class="items shirt sale" data-price="27.99" onclick="shirtpocket()">
                        <div class="items-image">
                            <img src="blue-shirtpocket.png" alt="ShirtPocket">
                        </div>
                        <div class="item-details">
                            <h2>Shirt With Pocket</h2>
                            <p>Price: <span style="text-decoration: line-through;"> $39.99</span> $27.99</p>
                           <div class="discount-circle">-30%</div>
                        </div>
                    </div>

                    <div class="items hoodie" data-price="29.99" onclick="hoodie()">
                        <div class="items-image">
                            <img src="white-hoodie.png" alt="Hoodie">
                        </div>
                        <div class="item-details">
                            <h2>Hoodie</h2>

                            <p>Price: $29.99</p>
                            
                        </div>
                    </div>
          
                    <div class="items jeans" data-price="39.99" onclick="jeans()">
                        <div class="items-image">
                            <img src="nblue-jeans.png" alt="Jeans">
                        </div>
                        <div class="item-details">
                            <h2>Regular Fit Jeans</h2>
                            <p>Price: $39.99</p>
                        
                        </div>
                    </div>
         
                    <div class="items shoes" data-price="69.99" onclick="shoes()">
                        <div class="items-image">
                            <img src="white-shoes.png" alt="Shoes">
                        </div>
                        <div class="item-details">
                            <h2>Casual Shoes</h2>
                            <p>Price: $69.99</p>
                          
                        </div>
                    </div>
              
                       <div class="items basketball tshirt sale" data-price="19.99" onclick="basketball()">
                        <div class="items-image">
                            <img src="red-basketball.png" alt="Basketball">
                        </div>
                        <div class="item-details">
                            <h2>Basketball Training T-Shirt</h2>
                            <p>Price: <span style="text-decoration: line-through;"> $24.99</span> $19.99</p>
                           <div class="discount-circle">-20%</div>
                        </div>
                    </div>

                    <div class="items shirt" data-price="29.99" onclick="shirt()">
                        <div class="items-image">
                            <img src="blue-shirt.png" alt="Shirt">
                        </div>
                        <div class="item-details">
                            <h2>Oxford Shirt With A Tab Collar</h2>
                            <p>Price: $29.99</p>
                          
                        </div>
                    </div>
              
                    <div class="items jacket" data-price="79.99" onclick="jacket()">
                        <div class="items-image">
                            <img src="white-jacket.png" alt="Jacket">
                        </div>
                        <div class="item-details">
                            <h2>Rubberised Puffer Jacket</h2>
                            <p>Price: $79.99</p>
                          
                        </div>
                    </div>
            
                    <div class="items tshirt" data-price="34.99" onclick="tshirt()">
                        <div class="items-image">
                            <img src="white-tshirt.png" alt="Tshirt">
                        </div>
                        <div class="item-details">
                            <h2>T-Shirt With Contrast Top Stitching</h2>
                            <p>Price: $34.99</p>
                          
                        </div>
                    </div>
               
                    <div class="items polo" data-price="39.99" onclick="polo()">
                        <div class="items-image">
                            <img src="gray-polo.png" alt="Polo">
                        </div>
                        <div class="item-details">
                            <h2>Basic Knit Polo Shirt</h2>
                            <p>Price: $39.99</p>
                          
                        </div>
                    </div>
               
                    <div class="items short" data-price="29.99" onclick="short()">
                        <div class="items-image">
                            <img src="basicshort.png" alt="Short">
                        </div>
                        <div class="item-details">
                            <h2>Basic Jogger Bermuda Short</h2>
                            <p>Price: $29.99</p>
                          
                        </div>
                    </div>

                     <div class="items jeans" data-price="34.99" onclick="taperedjeans()">
                        <div class="items-image">
                            <img src="gray-tjeans.png" alt="TJeans">
                        </div>
                        <div class="item-details">
                            <h2>Tapered Fit Jeans</h2>
                            <p>Price: $34.99</p>
                          
                        </div>
                    </div>


                        <div class="items shoes" data-price="49.99" onclick="trainers()">
                        <div class="items-image">
                            <img src="beige-trainers.png" alt="TJeans">
                        </div>
                        <div class="item-details">
                            <h2>Minimalist Lace-Up Trainers Shoes</h2>
                            <p>Price: $49.99</p>
                          
                        </div>
                    </div>
              
</div>
</main>
    </body>

    </html>
