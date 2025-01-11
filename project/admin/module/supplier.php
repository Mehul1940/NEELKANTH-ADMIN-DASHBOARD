<?php
require_once "/xampp/htdocs/Project/config/admincheck.php";
require_once "/xampp/htdocs/Project/config/db.php";
// Query to fetch all suppliers
$supplierQuery = "SELECT SUPPLIER_ID, SUPPLIER_NAME, EMAIL, PHONE, ADDRESS FROM supplier";
$supplierResult = $conn->query($supplierQuery);

// Check if the query was successful
if (!$supplierResult) {
    echo "Error executing query: " . $conn->error;
    exit();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .supplier-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            color: #007BFF;
        }

        .add-supplier-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .add-btn {
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-btn:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1em;
            background-color: #ffffff;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        td {
            color: #555;
        }

        .action-btn-container {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 8px 15px;
            margin: 5px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .update-btn {
            background-color: #007bff;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .update-btn:hover,
        .delete-btn:hover {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.9em;
            }

            th,
            td {
                padding: 10px;
            }

            .add-supplier-form {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Modal Background */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 100px;
            transition: opacity 0.3s ease;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Title */
        .modal-content h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* Input Fields */
        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        .modal-content textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Button Container */
        .button-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 20px;
        }

        /* Buttons */
        .save-btn,
        .close-btn {
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 48%;
        }

        .save-btn:hover {
            background-color: #45a049;
        }

        .close-btn {
            background-color: #f44336;
            /* Red */
        }

        .close-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>

<body>
    <?php require_once "/xampp/htdocs/Project/admin/Nav.php"; ?>

    <div class="main">
        <?php require_once "/xampp/htdocs/Project/admin/main.php"; ?>
        <div class="supplier-container">
            <h1>Suppliers</h1>

            <!-- Add New Supplier Form -->
            <div class="add-supplier-form">
                <a href="/Project/admin/add/add_supplier.php" class="add-btn">Add New Supplier</a>
            </div>

            <?php if ($supplierResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Supplier ID</th>
                            <th>Supplier Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $supplierResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['SUPPLIER_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['SUPPLIER_NAME']); ?></td>
                                <td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                                <td><?php echo htmlspecialchars($row['PHONE']); ?></td>
                                <td><?php echo htmlspecialchars($row['ADDRESS']); ?></td>
                                <td>
                                    <div class="action-btn-container">
                                        <button class="action-btn update-btn" onclick='openModal(<?php echo json_encode($row); ?>)'>
                                            Update
                                        </button>
                                        <form action="/Project/admin/delete/delete_supplier.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                            <button type="submit" name="supplier_id" value="<?php echo $row['SUPPLIER_ID']; ?>" class="action-btn delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #666;">No suppliers found.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Update Modal -->
    <div class="modal" id="updateModal">
        <div class="modal-content">
            <h2>Update Supplier</h2>
            <form id="updateForm" method="POST" action="/Project/admin/update/update_supplier.php">
                <input type="hidden" name="SUPPLIER_ID" id="modalSupplierID">
                <input type="text" name="SUPPLIER_NAME" id="modalSupplierName" placeholder="Supplier Name" required>
                <input type="email" name="EMAIL" id="modalEmail" placeholder="Email" required>
                <input type="text" name="PHONE" id="modalPhone" placeholder="Phone" required>
                <textarea name="ADDRESS" id="modalAddress" placeholder="Address" required></textarea>
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" class="close-btn" onclick="closeModal()">Close</button>
            </form>
        </div>
    </div>
</body>
<script src="/Project/assets/js/main.js"></script>
<script src="/Project/assets/js/updateSupplier.js"></script>

</html>