<?php

include 'ProductClass.php';
include 'ProductFactory.php';

$servername = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate input data
$sku = $_POST['sku'];
$name = $_POST['name'];
$price = $_POST['price'];
$type = $_POST['productType'];
$attributes = $_POST;

try {
    $product = ProductFactory::create($sku, $name, $price, $type, $attributes);
    $product->save($conn);
    echo "success";
    //header("Location: index.php");
    //exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
