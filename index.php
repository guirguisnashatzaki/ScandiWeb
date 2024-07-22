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

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <div class="container">
        <h1>Products</h1>
        <div class="top-bar">
            <div>
                <input type="checkbox" class="checkbox" id="selectAll"> Select All
            </div>
            <div class="buttons">
                <button id="massDelete" >Mass Delete</button>
                <button id="addProduct" ><a href="add.html">Add</a></button>
            </div>
        </div>
        <div class="product-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product-card'>";
                    echo "<input type='checkbox' class='checkbox' data-sku='" . $row["sku"] . "'>";
                    echo "<h3>" . $row["sku"] . "</h3>";
                    echo "<p>" . $row["name"] . "</p>";
                    echo "<p>$" . $row["price"] . "</p>";
                    if ($row["type"] == "DVD") {
                        echo "<p>Size: " . $row["size"] . " MB</p>";
                    } elseif ($row["type"] == "Furniture") {
                        echo "<p>Dimensions: " . $row["height"] . "x" . $row["width"] . "x" . $row["length"] . " CM</p>";
                    } elseif ($row["type"] == "Book") {
                        echo "<p>Weight: " . $row["weight"] . " KG</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No products found</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.product-card .checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = document.getElementById('selectAll').checked;
            });
        });

        document.getElementById('massDelete').addEventListener('click', function() {
            var selectedProducts = [];
            var checkboxes = document.querySelectorAll('.product-card .checkbox:checked');
            checkboxes.forEach(function(checkbox) {
                selectedProducts.push(checkbox.getAttribute('data-sku'));
            });

            if (selectedProducts.length > 0) {
                    // Send AJAX request to delete products
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "massDelete.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            location.reload();
                        }
                    };
                    xhr.send("skus=" + JSON.stringify(selectedProducts));
            } else {
                alert("No products selected for deletion.");
            }
        });

        document.getElementById('addProduct').addEventListener('click', function() {
            window.location.href = 'add_product.html';
        });
    </script>
</body>
</html>
