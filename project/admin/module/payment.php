<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>
<?php require_once "/xampp/htdocs/Project/config/db.php" ?>
<?php
// Initialize $totalEarnings to 0
$totalEarnings = 0;

// Calculate total earnings (only COMPLETED payments)
$totalQuery = "SELECT SUM(TOTAL_AMT) AS total FROM payment WHERE STATUS = 'COMPLETED'";
$totalResult = $conn->query($totalQuery);

if ($totalResult && $totalResult->num_rows > 0) {
    $row = $totalResult->fetch_assoc();
    $totalEarnings = $row['total'] ?? 0; // Default to 0 if null
}

// Fetch all payment details
$paymentsQuery = "SELECT * FROM payment ORDER BY PAYMENT_ID ASC";
$paymentsResult = $conn->query($paymentsQuery);

if (!$paymentsResult) {
    die("Query Failed: " . $conn->error); // Display the exact error
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earnings Dashboard</title>
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
            border-color:rgb(3, 61, 123);
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
    <link rel="stylesheet" href="/Project/assets/css/style.css">
</head>

<body>
<?php require_once "/xampp/htdocs/Project/admin/Nav.php" ?>

    <div class="main">
    <?php require_once "/xampp/htdocs/Project/admin/main.php" ?>
        <div class="container">
            <h1 class="text-center">Earnings Dashboard</h1>

            <!-- Summary Cards -->
            <div class="earnings-summary">
                <div class="earnings-card">
                    <div class="card-content">
                        <h2 class="card-title">Total Earnings</h2>
                        <p class="earnings-amount">$<?php echo number_format((float)$totalEarnings, 2); ?></p>
                    </div>
                </div>
            </div>

            <!-- Payment Table -->
            <div class="payment-card">
                <div class="card-header">
                    <h5>Payment Details</h5>
                </div>
                <div class="card-content">
                    <div class="table-container">
                        <table class="payment-table">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Total Amount</th>
                                    <th>Order ID</th>
                                    <th>Booking ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($paymentsResult->num_rows > 0): ?>
                                    <?php while ($row = $paymentsResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['PAYMENT_ID']); ?></td>
                                            <td><?php echo number_format((float)$row['TOTAL_AMT'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($row['ORDER_ID']); ?></td>
                                            <td><?php echo htmlspecialchars($row['BOOKING_ID']); ?></td>
                                            <td>
                                                <span class="status-badge <?php echo strtolower($row['STATUS']) === 'completed' ? 'status-success' : 'status-warning'; ?>">
                                                    <?php echo htmlspecialchars(ucfirst(strtolower($row['STATUS']))); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="update-btn" data-payment-id="<?php echo htmlspecialchars($row['PAYMENT_ID']); ?>"
                                                    data-total-amt="<?php echo htmlspecialchars($row['TOTAL_AMT']); ?>"
                                                    data-order-id="<?php echo htmlspecialchars($row['ORDER_ID']); ?>"
                                                    data-booking-id="<?php echo htmlspecialchars($row['BOOKING_ID']); ?>"
                                                    data-status="<?php echo htmlspecialchars($row['STATUS']); ?>"
                                                    onclick="openModal(this)">Update</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No payments found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Payment Model -->
    <div id="updatePaymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Payment</h2>
                <span class="close-btn" id="closeModal">&times;</span>
            </div>
            <hr style=" margin-bottom: 15px;">
            </hr>
            <form id="updateOrderForm" action="/Project/admin/update/update_payment.php" method="post">
                <div class="form-group">
                    <label for="payment_id">Payment ID</label>
                    <input type="text" id="payment_id" name="payment_id" required>
                </div>
                <div class="form-group">
                    <label for="total_amt">Total Amount</label>
                    <input type="number" id="total_amt" name="total_amt" required>
                </div>
                <div class="form-group">
                    <label for="order_id">Order ID</label>
                    <input type="text" id="order_id" name="order_id" required>
                </div>
                <div class="form-group">
                    <label for="booking_id">Booking ID</label>
                    <input type="text" id="booking_id" name="booking_id" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" id="cancelModal" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script src="/Project/assets/js/updatePayment.js"></script>
    <script src="/Project/assets/js/main.js"></script>
</body>

</html>

<?php
$conn->close();
?>