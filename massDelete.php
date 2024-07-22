<?php
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

$skus = json_decode($_POST['skus']);

if (!empty($skus)) {
    foreach ($skus as $sku) {
        $sku = $conn->real_escape_string($sku);
        $sql = "DELETE FROM products WHERE sku = '$sku'";
        $conn->query($sql);
    }
}

$conn->close();
?>
