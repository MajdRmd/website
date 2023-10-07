<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Initialize variables
$showPopUp = isset($_SESSION['showPopUp']) && $_SESSION['showPopUp'];
$popUpMessage = isset($_SESSION['popUpMessage']) ? $_SESSION['popUpMessage'] : '';
$popUpClass = isset($_SESSION['popUpClass']) ? $_SESSION['popUpClass'] : '';

unset($_SESSION['showPopUp']);
unset($_SESSION['popUpMessage']);
unset($_SESSION['popUpClass']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $productName = $_POST['product_name'];
        $productModel = $_POST['product_model'];
        $productPrice = $_POST['product_price'];
        $productQuantity = $_POST['product_quantity'];

        // Check if the product name already exists in the database
        $selectQuery = "SELECT * FROM products WHERE category = '$productName'";
        $result = $conn->query($selectQuery);

        if ($result && $result->num_rows > 0) {
            $existingProduct = $result->fetch_assoc();
            $existingPrice = $existingProduct['price'];
            $existingQuantity = $existingProduct['quantity'];

            if ($existingPrice != $productPrice) {
                $showPopUp = true;
                $popUpMessage = "Error: Product with the same name already exists, but with a different price.";
                $popUpClass = "error";
            } else {
                $updatedQuantity = $existingQuantity + $productQuantity;

                // Update the quantity of the existing product
                $updateQuery = "UPDATE products SET quantity = '$updatedQuantity' WHERE id = " . $existingProduct['id'];
                $updateResult = $conn->query($updateQuery);

                if ($updateResult) {
                    $showPopUp = true;
                    $popUpMessage = "Product quantity updated successfully.";
                    $popUpClass = "success";
                } else {
                    echo "Error updating product: " . $conn->error;
                }
            }
        } else {
            // Insert new product into the "products" table
            $insertQuery = "INSERT INTO products (category, price, quantity,model) VALUES ('$productName', '$productPrice', '$productQuantity','$productModel')";
            $insertResult = $conn->query($insertQuery);

            if ($insertResult) {
                $showPopUp = true;
                $popUpMessage = "New product added successfully.";
                $popUpClass = "success";
            } else {
                $showPopUp = true;
                $popUpMessage = "Error adding product: " . $conn->error;
                $popUpClass = "error";
            }
        }
    }
}



// Fetch data from the "products" table
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error retrieving data: " . $conn->error;
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <style>
    .chart-container {
        width: 800px;
        height: 500px;
     
    }
</style>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <nav>
        <ul>
           <li><a href="#dashboard-section">Dashboard</a></li>
            <li><a href="#sales-section">Sales</a></li>
            <li><a href="#products-section">Products Management</a></li>
            <li><a href="#ordersman-section">Orders Management</a></li>
             <li><a href="#customers-section">Customers</a></li>
        </ul>
    </nav>

    <section class="overview" id="dashboard-section">
    <h2>Dashboard Overview</h2>
    <div class="metrics">
        <div class="metric">
            <h3>Total Sales</h3>
            <?php
            $servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";


$conn = new mysqli($servername, $username, $password, $dbname);

            $totalSales = 0;
            
           
            if (!$conn) {
                echo "<p>Database connection failed.</p>";
            } else {
                // Calculate total sales
   $query = "SELECT SUM(pr.price) AS total_sales FROM purchase p JOIN products pr ON p.category = pr.category";


                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $totalSales = $row['total_sales'];
                }
                
                echo "<p>$" . number_format($totalSales, 2) . "</p>";
            }
            ?>
        </div>
      
        <div class="metric" id="orders-section">
            <h3>Number of Orders</h3>
            <?php

            $orderCount = 0;
            
          
            if (!$conn) {
                echo "<p>Database connection failed.</p>";
            } else {
                // Count the number of orders
                $query = "SELECT COUNT(*) AS order_count FROM purchase";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $orderCount = $row['order_count'];
                }
                
                echo "<p>$orderCount</p>";
            }
            ?>
        </div>
      

</section>

<section class="sales-chart" id="sales-section">
<?php


if (!$conn) {
    echo "<p>Database connection failed.</p>";
} else {
    // Calculate average sales
     $query = "SELECT SUM(pr.price) AS total_sales, COUNT(*) AS item_count
              FROM purchase p
              JOIN products pr ON p.category = pr.category
              WHERE p.Date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
     $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalSales = $row['total_sales'];
        $itemCount = $row['item_count'];
    }

}
$averageSales = ($itemCount > 0) ? $totalSales / $itemCount : 0;
$totalSalesFormatted = number_format($totalSales, 2);
$averageSalesFormatted = number_format($averageSales, 2);

// ...
?>

    <h2>Sales Chart</h2>
<div >
  <h3>Total Sales Last 30 Days: <span style="color: dimgray;"><?php echo $totalSalesFormatted ?>$</span></h3>
    <h3>Number of Items Purchased Last 30 Days: <span style="color: dimgray;"><?php echo $itemCount ?></span></h3>
    <h3>Average Sales Last 30 Days: <span style="color: dimgray;"><?php echo $averageSalesFormatted ?>$</span></h3>
   
</div>
    <form method="POST" action="">
        <label for="category">Select Category:</label>
        <select name="category" id="category">
            <option value="all" selected>All Categories</option>
            <option value="hoodie">Hoodie</option>
            <option value="jeans">Regular Jeans</option>
            <option value="tjeans">Tapered Jeans</option>
            <option value="polo">Polo</option>
            <option value="shirt">Shirt</option>
            <option value="Tshirt">Oxford Tshirt</option>
            <option value="basketball">Basketball</option>
            <option value="shoes">Shoes</option>
            <option value="short">Short</option>
            <option value="jacket">Jacket</option>
            <option value="trainers">Trainers</option>
           
        </select>
    </form>



<div style="width: 800px; height: 500px; display: flex; align-items: flex-start;">

    <canvas id="salesChart" style="width: 100%; height: 100%;"></canvas>
</div>





    <script>
        function updateChart() {
            // Fetch selected category value
            var selectedCategory = document.getElementById('category').value;

            // Fetch sales data from the PHP file based on the selected category
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var labels = response.labels;
                    var data = response.data;

                    // Create or update the sales chart
                    var ctx = document.getElementById('salesChart').getContext('2d');
                    if (window.chart) {
                        window.chart.data.labels = labels;
                        window.chart.data.datasets[0].data = data;
                        window.chart.update();
                    } else {
                        window.chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Sales',
                                    data: data,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {

                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                }
            };

            xhr.open('POST', 'fetch_sales.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('category=' + selectedCategory);

        }

        // Update the chart on page load
        updateChart();

        // Add event listener to update the chart when the category selection changes
        document.getElementById('category').addEventListener('change', function() {
            updateChart();
        });
    </script>
<section class="orders" id="ordersman-section">
    <h2>Orders Management</h2>
    <button id="toggleOrdersButton">Show All Orders</button>
    <table id="ordersTable">
        <tr>
            <th>Order ID</th>
            <th>Customer Username</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php
        // Retrieve orders from the purchase table
        $query = "SELECT * FROM purchase ORDER BY id DESC"; // Fetch orders in descending order by ID
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            $totalOrders = count($orders);
            $displayedOrders = min($totalOrders, 10); // Display up to 10 orders initially

            // Loop through the orders and display them
            for ($i = 0; $i < $displayedOrders; $i++) {
                $orderID = $orders[$i]['id'];
                $customerUsername = $orders[$i]['username'];
                $date = $orders[$i]['Date'];

                echo "<tr>
                        <td>$orderID</td>
                        <td>$customerUsername</td>
                        <td>$date</td>
                        <td>Shipped</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No orders found</td></tr>";
        }
        ?>
        <tbody id="additionalOrders" style="display: none;">
            <?php
            // Loop through the remaining orders and hide them initially
            for ($i = $displayedOrders; $i < $totalOrders; $i++) {
                $orderID = $orders[$i]['id'];
                $customerUsername = $orders[$i]['username'];
                $date = $orders[$i]['Date'];

                echo "<tr>
                        <td>$orderID</td>
                        <td>$customerUsername</td>
                        <td>$date</td>
                        <td>Shipped</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<script>
    var showAllOrders = false;
    var toggleOrdersButton = document.getElementById('toggleOrdersButton');
    var additionalOrders = document.getElementById('additionalOrders');

    toggleOrdersButton.addEventListener('click', function () {
        showAllOrders = !showAllOrders;

        if (showAllOrders) {
            toggleOrdersButton.textContent = 'Show Last 10 Orders';
            additionalOrders.style.display = 'table-row-group';
        } else {
            toggleOrdersButton.textContent = 'Show All Orders';
            additionalOrders.style.display = 'none';
        }
    });
</script>


    <section class="products" id="products-section">
        <h2>Product Management</h2>
        <form method="POST" action="">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" required>
            <label for="product_name">Product Model:</label>
            <input type="text" name="product_model" id="product_model" required>
            <label for="product_price">Price:</label>
            <input type="text" name="product_price" id="product_price" required>
            <label for="product_quantity">Quantity:</label>
            <input type="number" name="product_quantity" id="product_quantity" required>
            <button type="submit" name="add_product">Add New Product</button>
        </form>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Product Model</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo $product['model']; ?></td>
                    <td><?php echo $product['price']; ?>$</td>
                    <td><?php echo $product['quantity']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </section>

    <?php if ($showPopUp) : ?>
        <div class="popup-message <?php echo $popUpClass; ?>"><?php echo $popUpMessage; ?></div>
        <script>
            window.onload = function () {
                const popupMessage = document.querySelector('.popup-message');
                if (popupMessage) {
                    popupMessage.classList.add('show');
                    if (popupMessage.classList.contains('error')) {
                        popupMessage.style.backgroundColor = '#e74c3c';
                    }
                    setTimeout(() => {
                        popupMessage.classList.add('fade-out');
                        setTimeout(() => {
                            popupMessage.remove();
                        }, 500);
                    }, 3000);
                }
            };
        </script>
    <?php endif; ?>

   <section class="inventory">
    <h2>Inventory Management</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Stock Quantity</th>
            <th>Low Stock Alert</th>
        </tr>
        <?php foreach ($products as $product) { ?>
            <tr>
                <td><?php echo $product['category']; ?></td>
                <td><?php echo $product['quantity']; ?></td>
                <td><?php echo ($product['quantity'] < 50) ? 'Yes' : 'No'; ?></td>
            </tr>
        <?php } ?>
    </table>
</section>


    <section class="customers" id="customers-section">
        <h2>Customers</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Registration Date</th>
            </tr>
            <?php


// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

        $query = "SELECT name, email, reg_date FROM users";
        $result = $conn->query($query);
        
        // Loop through each user and populate the form fields
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $email = $row['email'];
            $regDate = $row['reg_date'];
            
            echo "<tr>";
            echo "<td>$name</td>";
            echo "<td>$email</td>";
            echo "<td>$regDate</td>";
            echo "</tr>";
        }
        ?>
        
    </table>

  
    </section>

   


</body>
</html>