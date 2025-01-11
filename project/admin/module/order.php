<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <style>
        /* Modal Background */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5);
            /* Black w/opacity */
            padding-top: 60px;
            transition: opacity 0.3s ease;
            /* Smooth fade-in effect */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            /* You can adjust this width as necessary */
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Modal Header */
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

            <!-- Customer Table -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Customer Id</th>
                                <th>Total Amount</th>
                                <th>Delivery Address</th>
                                <th>Order Date</th>
                                <th>Delivery Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "project");

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT * FROM orders";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                                        <td>' . htmlspecialchars($row["ORDER_ID"]) . '</td>
                                        <td>' . htmlspecialchars($row["CUSTOMER_ID"]) . '</td>
                                        <td>' . htmlspecialchars($row["TOTAL_AMT"]) . '</td>
                                        <td>' . htmlspecialchars($row["DELIVERY_ADDRESS"]) . '</td>
                                        <td>' . htmlspecialchars($row["order_date"]) . '</td>
                                        <td>
                                            <span class="status-badge ' . (strtolower($row['DELIVERY_STATUS']) === 'completed' ? 'status-success' : 'status-warning') . '">
                                                ' . htmlspecialchars(ucfirst(strtolower($row['DELIVERY_STATUS']))) . '
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm update-btn"
                                                    data-id="' . $row["ORDER_ID"] . '"
                                                    data-customer="' . $row["CUSTOMER_ID"] . '"
                                                    data-amount="' . $row["TOTAL_AMT"] . '"
                                                    data-address="' . $row["DELIVERY_ADDRESS"] . '"
                                                    data-status="' . $row["DELIVERY_STATUS"] . '">
                                                Update
                                            </button>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No orders found</td></tr>';
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Order Modal -->
    <div id="updateOrderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Order</h2>
                <span class="close-btn" id="closeModal">&times;</span>
            </div>
            <hr style=" margin-bottom: 15px;">
            </hr>
            <form id="updateOrderForm" action="/Project/admin/update/update_order.php" method="post">
                <div class="form-group">
                    <label for="order_id">Order ID</label>
                    <input type="text" id="order_id" name="order_id" readonly>
                </div>
                <div class="form-group">
                    <label for="customer_id">Customer ID</label>
                    <input type="text" id="customer_id" name="customer_id" required>
                </div>
                <div class="form-group">
                    <label for="total_amt">Total Amount</label>
                    <input type="number" id="total_amt" name="total_amt" required>
                </div>
                <div class="form-group">
                    <label for="delivery_address">Delivery Address</label>
                    <input type="text" id="delivery_address" name="delivery_address" required>
                </div>
                <div class="form-group">
                    <label for="delivery_status">Delivery Status</label>
                    <select id="delivery_status" name="delivery_status" required>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/Project/assets/js/updateOrder.js"></script>
    <script src="/Project/assets/js/main.js"></script>
</body>

</html>