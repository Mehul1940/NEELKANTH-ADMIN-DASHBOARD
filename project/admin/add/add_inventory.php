<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>
<?php require_once "/xampp/htdocs/Project/config/db.php" ?>

<?php
// Fetch category data for dynamic dropdown (Category ID)
$categoryQuery = "SELECT CATEGORY_ID, CATEGORY_NAME FROM categories";
$categoryResult = $conn->query($categoryQuery);

// Fetch brand data for dynamic dropdown (Brand ID)
$brandQuery = "SELECT BRAND_ID, BRAND_NAME FROM brand";
$brandResult = $conn->query($brandQuery);

// Fetch product data for dynamic dropdown (Product ID)
$productQuery = "SELECT PRODUCT_ID, PRODUCT_NAME FROM product";
$productResult = $conn->query($productQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Getting data from the form
    $stock_id = $_POST['stock_id'];
    $stock_name = $_POST['stock_name'];
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $product_id = $_POST['product_id'];
    $current_units = $_POST['current_units'];
    $units_required = $_POST['units_required'];

    // Insert new inventory item into the database
    $insertQuery = "INSERT INTO inventory (STOCK_ID, STOCK_NAME, CATEGORY_ID, BRAND_ID, PRODUCT_ID, CURRENT_UNITS, UNITS_REQUIRED) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    // Correcting the bind_param statement
    $stmt->bind_param("ssissss", $stock_id, $stock_name, $category_id, $brand_id, $product_id, $current_units, $units_required);

    if ($stmt->execute()) {
        header("Location: /Project/admin/module/inventory.php"); // Redirect to inventory page after insertion
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory</title>
    <link rel="stylesheet" href="/Project/assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 60%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .form-group select {
            height: 40px;
        }

        .form-group .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>

<body>
        <div class="container">
            <h2>Add New Inventory</h2>
            <!-- Error message -->
            <?php if (isset($stmt) && !$stmt->execute()): ?>
                <div class="message">Error: <?php echo htmlspecialchars($stmt->error); ?></div>
            <?php endif; ?>

            <form action="/Project/admin/add/add_inventory.php" method="POST">
                <div class="form-group">
                    <label for="stock_id">Stock ID</label>
                    <input type="text" id="stock_id" name="stock_id" required>
                </div>

                <div class="form-group">
                    <label for="stock_name">Stock Name</label>
                    <input type="text" id="stock_name" name="stock_name" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php while ($row = $categoryResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['CATEGORY_ID']; ?>">
                                <?php echo $row['CATEGORY_NAME']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select id="brand_id" name="brand_id" required>
                        <option value="">Select Brand</option>
                        <?php while ($row = $brandResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['BRAND_ID']; ?>">
                                <?php echo $row['BRAND_NAME']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select id="product_id" name="product_id" required>
                        <option value="">Select Product</option>
                        <?php while ($row = $productResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['PRODUCT_ID']; ?>">
                                <?php echo $row['PRODUCT_ID']; ?> - <?php echo $row['PRODUCT_NAME']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="current_units">Current Units</label>
                    <input type="number" id="current_units" name="current_units" required>
                </div>

                <div class="form-group">
                    <label for="units_required">Units Required</label>
                    <input type="number" id="units_required" name="units_required" required>
                </div>

                <button type="submit">Add Inventory</button>
            </form>
        </div>
    <script src="/Project/assets/js/main.js"></script>
    <!-- IonIcons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>