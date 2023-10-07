<?php
$conn = new mysqli('localhost', 'root', '', 'my_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedCategory = isset($_POST['category']) ? $_POST['category'] : 'all';

$whereClause = '';
if ($selectedCategory !== 'all') {
    $whereClause = "WHERE pr.category = '$selectedCategory'";
}

$query = "SELECT p.Date, SUM(pr.price) AS total_sales
FROM purchase p
JOIN products pr ON p.category = pr.category
$whereClause
GROUP BY p.Date";

$result = $conn->query($query);

if ($result) {
    $salesData = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error retrieving data: " . $conn->error;
}

$response = [
    'labels' => [],
    'data' => []
];

foreach ($salesData as $sale) {
    $response['labels'][] = $sale['Date'];
    $response['data'][] = $sale['total_sales'];
}

header('Content-Type: application/json');
echo json_encode($response);




?>
