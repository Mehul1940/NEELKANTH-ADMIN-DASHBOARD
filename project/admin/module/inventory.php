<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>
<?php require_once "/xampp/htdocs/Project/config/db.php" ?>
<?php
// Fetching all inventory items with joined brand, category, and product names
$query = "
    SELECT i.*, c.CATEGORY_NAME, b.BRAND_NAME, p.PRODUCT_NAME
    FROM inventory i
    LEFT JOIN categories c ON i.CATEGORY_ID = c.CATEGORY_ID
    LEFT JOIN brand b ON i.BRAND_ID = b.BRAND_ID
    LEFT JOIN product p ON i.PRODUCT_ID = p.PRODUCT_ID
    ORDER BY i.STOCK_ID ASC
";

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
    <title>Inventory Management</title>
    <link rel="stylesheet" href="/Project/assets/css/style.css">
    <style>
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th,
        .inventory-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .inventory-table thead th {
            background-color: rgb(23, 62, 188);
            color: white;
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
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: rgb(19, 6, 159);
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn1 {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: rgb(4, 94, 13);
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn1:hover {
            background-color: rgb(4, 94, 13);
        }

        .btn:hover {
            background-color: rgb(17, 40, 133);
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Modal styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Fixed position to stay on the screen */
            z-index: 1;
            /* Stay on top of other content */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            overflow: auto;
            /* Allow scrolling if needed */
            padding-top: 60px;
            /* Space for the modal content */
            transition: all 0.3s ease;
            /* Smooth transition for modal opening/closing */
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            /* Center the modal content */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Default width */
            max-width: 600px;
            /* Maximum width */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            transition: transform 0.3s ease-in-out;
            /* Smooth scaling effect */
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
        }

        /* Close Button */
        .close-btn {
            font-size: 2rem;
            color: #888;
            cursor: pointer;
            background: none;
            border: none;
        }

        /* Close Button Hover */
        .close-btn:hover {
            color: #000;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
        }

        /* Modal Footer */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 10px;
        }

        .modal-footer .btn {
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Primary Button */
        .modal-footer .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .modal-footer .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Secondary Button */
        .modal-footer .btn-secondary {
            background-color: #ccc;
            color: #333;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #999;
        }

        /* Cancel Button Hover */
        #cancelModal:hover {
            background-color: #f8f8f8;
        }

        /* Modal Transition */
        .modal.fade-in {
            display: block;
            opacity: 1;
        }

        /* Small Device Handling */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin-top: 20px;
            }

            .modal-header h2 {
                font-size: 1.2rem;
            }

            .form-group label {
                font-size: 0.9rem;
            }

            .form-group input,
            .form-group select {
                font-size: 0.9rem;
                padding: 7px;
            }

            .modal-footer .btn {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require_once "/xampp/htdocs/Project/admin/Nav.php" ?>

        <div class="main">
            <?php require_once "/xampp/htdocs/Project/admin/main.php" ?>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Inventory</h2>
                        <a href="/Project/admin/add/add_inventory.php" class="btn1">Add New Inventory</a>
                    </div>

                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Stock ID</th>
                                <th>Stock Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Product</th>
                                <th>Current Units</th>
                                <th>Units Required</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row["STOCK_ID"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["STOCK_NAME"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["CATEGORY_ID"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["BRAND_ID"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["PRODUCT_ID"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["CURRENT_UNITS"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["UNITS_REQUIRED"]); ?></td>
                                        <td>
                                            <button class="btn btn-update" data-stock-id="<?php echo htmlspecialchars($row['STOCK_ID']); ?>"
                                                data-stock-name="<?php echo htmlspecialchars($row['STOCK_NAME']); ?>"
                                                data-category="<?php echo htmlspecialchars($row['CATEGORY_ID']); ?>"
                                                data-brand="<?php echo htmlspecialchars($row['BRAND_ID']); ?>"
                                                data-product="<?php echo htmlspecialchars($row['PRODUCT_ID']); ?>"
                                                data-current-units="<?php echo htmlspecialchars($row['CURRENT_UNITS']); ?>"
                                                data-units-required="<?php echo htmlspecialchars($row['UNITS_REQUIRED']); ?>">
                                                Update
                                            </button>
                                            <form action="/Project/admin/delete/delete_inventory.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row["STOCK_ID"]); ?>">
                                                <button class="btn" type="submit" style="background-color: red;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="no-products">No inventory found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Inventory</h2>
            <form id="updateForm" action="/Project/admin/update/update_inventory.php" method="post">
                <input type="hidden" name="id" id="modalStockId">
                <div class="form-group">
                    <label for="stockName">Stock Name:</label>
                    <input type="text" id="stockName" name="stockName" required>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" required>
                </div>
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <input type="text" id="brand" name="brand" required>
                </div>
                <div class="form-group">
                    <label for="product">Product:</label>
                    <input type="text" id="product" name="product" required>
                </div>
                <div class="form-group">
                    <label for="currentUnits">Current Units:</label>
                    <input type="number" id="currentUnits" name="currentUnits" required>
                </div>
                <div class="form-group">
                    <label for="unitsRequired">Units Required:</label>
                    <input type="number" id="unitsRequired" name="unitsRequired" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/Project/assets/js/updateInventory.js"></script>
    <script src="/Project/assets/js/main.js"></script>
</body>

</html>