<?php require_once "/xampp/htdocs/Project/config/db.php" ?>
<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted data
    $paymentId = $_POST['payment_id'];
    $totalAmt = $_POST['total_amt'];
    $orderId = $_POST['order_id'];
    $bookingId = $_POST['booking_id'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the payment
    $sql = "UPDATE payment SET TOTAL_AMT = ?, ORDER_ID = ?, BOOKING_ID = ?, STATUS = ? WHERE PAYMENT_ID = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the query
        $stmt->bind_param("dssss", $totalAmt, $orderId, $bookingId, $status, $paymentId);

        // Execute the query
        if ($stmt->execute()) {
            // Successfully updated the payment
            header("Location: /Project/admin/module/payment.php"); 
        } else {
            echo "Error updating payment: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
