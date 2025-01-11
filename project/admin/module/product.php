<?php require_once "/xampp/htdocs/Project/config/admincheck.php"; ?>
<?php require_once "/xampp/htdocs/Project/config/db.php"; ?>

<?php
// Fetch all products
$query = "SELECT * FROM product ORDER BY PRODUCT_ID ASC";
$result = $conn->query($query);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .product-table thead th {
            background-color: rgb(23, 62, 188);
            color: white;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        .no-products {
            text-align: center;
        }

        td button {
            background-color: orange;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            color: white;
            border-radius: 5px;
        }

        td button:hover {
            background-color: darkorange;
        }

        .btn {
            background-color: blue;
        }

        .btn:hover {
            background-color: blue;
        }

        .btn2 {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .modal-close {
            float: right;
            color: red;
            font-size: 20px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn.submit {
            background-color: #4CAF50;
        }

        .btn.submit:hover {
            background-color: #45a049;
        }
    </style>
    <link rel="stylesheet" href="/Project/assets/css/style.css">
</head>

<body>
    <div class="container">
        <!-- Include Navigation -->
        <?php require_once "/xampp/htdocs/Project/admin/Nav.php"; ?>

        <div class="main">
            <?php require_once "/xampp/htdocs/Project/admin/main.php"; ?>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Products</h2>
                        <a href="/Project/admin/add/add_product.php" class="btn2">Add New Product</a>
                    </div>

                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Category ID</th>
                                <th>Brand ID</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row["PRODUCT_ID"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["PRODUCT_NAME"]); ?></td>
                                        <td><?php echo number_format((float)$row["PRICE"], 2); ?></td>
                                        <td><?php echo htmlspecialchars($row["CATEGORY_ID"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["BRAND_ID"]); ?></td>
                                        <td>
                                            <?php if (!empty($row["P_IMG"])): ?>
                                                <img src="<?php echo "../../" . htmlspecialchars($row["P_IMG"]); ?>" alt="<?php echo htmlspecialchars($row["PRODUCT_NAME"]); ?>">
                                            <?php else: ?>
                                                <span>No Image</span>
                                            <?php endif; ?>

                                        </td>
                                        <td>
                                            <button class="btn" type="button" onclick="openModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">Update</button>

                                            <form action="/Project/admin/delete/delete_product.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row["PRODUCT_ID"]); ?>">
                                                <button class="btn" type="submit" style="background-color: red;">Delete</button>
                                            </form>
                                            <form action="product_review.php" method="get" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row["PRODUCT_ID"]); ?>">
                                                <button class="btn1" type="submit">Review</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="no-products">No products found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Product Update -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <div class="modal-header">Update Product</div>
            <form id="updateForm" action="/Project/admin/update/update_product.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="PRODUCT_ID" id="PRODUCT_ID">
                <div class="form-group">
                    <label for="PRODUCT_NAME">Product Name</label>
                    <input type="text" name="PRODUCT_NAME" id="PRODUCT_NAME" required>
                </div>
                <div class="form-group">
                    <label for="PRICE">Price</label>
                    <input type="number" name="PRICE" id="PRICE" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="CATEGORY_ID">Category ID</label>
                    <input type="number" name="CATEGORY_ID" id="CATEGORY_ID" required>
                </div>
                <div class="form-group">
                    <label for="BRAND_ID">Brand ID</label>
                    <input type="number" name="BRAND_ID" id="BRAND_ID" required>
                </div>
                <div class="form-group">
                    <label>Current Image</label>
                    <img id="IMAGE_PREVIEW" alt="No Image" style="max-width: 100px; display: none;">
                </div>
                <div class="form-group">
                    <label for="P_IMG">Upload New Image</label>
                    <input type="file" name="P_IMG" id="P_IMG" accept="image/*">
                </div>
                <button type="submit" class="btn submit">Update</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/Project/assets/js/main.js"></script>
    <script src="/Project/assets/js/updateProduct.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>