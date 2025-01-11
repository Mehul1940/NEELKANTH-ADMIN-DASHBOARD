<?php require_once "/xampp/htdocs/Project/config/db.php" ?> 
<?php
// Query for Daily View (total customers added today)
$dailyViewQuery = "
    SELECT COUNT(*) AS daily_view
    FROM customer
";

// Check if the query was executed successfully
$dailyViewResult = $conn->query($dailyViewQuery);
if ($dailyViewResult === false) {
    die("Error executing query: " . $conn->error);  // Output the error message if the query fails
}

$dailyView = $dailyViewResult->fetch_assoc()['daily_view'];

// Query for Sales (completed orders count)
$salesQuery = "
    SELECT COUNT(*) AS sales
    FROM orders
    WHERE DELIVERY_STATUS = 'Completed'
";
$salesResult = $conn->query($salesQuery);
if ($salesResult === false) {
    die("Error executing query: " . $conn->error);
}

$sales = $salesResult->fetch_assoc()['sales'];

// Query for Comments (number of feedback entries)
$commentsQuery = "
    SELECT COUNT(*) AS comments
    FROM feedback
";
$commentsResult = $conn->query($commentsQuery);
if ($commentsResult === false) {
    die("Error executing query: " . $conn->error);
}

$comments = $commentsResult->fetch_assoc()['comments'];

// Query for Earnings (total earnings from completed orders)
$earningsQuery = "
    SELECT SUM(total_amt) AS earnings
    FROM payment
    WHERE STATUS = 'Completed'
";
$earningsResult = $conn->query($earningsQuery);
if ($earningsResult === false) {
    die("Error executing query: " . $conn->error);
}

$earnings = $earningsResult->fetch_assoc()['earnings'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card</title>
    <!-- Style -->
    <link rel="stylesheet" href="/Project/assets/css/style.css">
</head>

<body>
    <div class="cardBox">
        <!-- Daily View Card (now showing new customers added today) -->
        <div class="card">
            <div>
                <div class="numbers"><?php echo number_format($dailyView); ?></div>
                <div class="cardName">Total Customer</div>
            </div>
            <div class="iconBx">
                <ion-icon name="person-add-outline"></ion-icon>
            </div>
        </div>
        
        <!-- Sales Card -->
        <div class="card">
            <div>
                <div class="numbers"><?php echo number_format($sales); ?></div>
                <div class="cardName">Sales</div>
            </div>
            <div class="iconBx">
                <ion-icon name="cart-outline"></ion-icon>
            </div>
        </div>

        <!-- Comments Card -->
        <div class="card">
            <div>
                <div class="numbers"><?php echo number_format($comments); ?></div>
                <div class="cardName">Comments</div>
            </div>
            <div class="iconBx">
                <ion-icon name="chatbubble-outline"></ion-icon>
            </div>
        </div>

        <!-- Earnings Card -->
        <div class="card">
            <div>
                <div class="numbers">$<?php echo number_format($earnings, 2); ?></div>
                <div class="cardName">Earnings</div>
            </div>
            <div class="iconBx">
                <ion-icon name="cash-outline"></ion-icon>
            </div>
        </div>
    </div>
    <?php require_once "../chart.php"?>
    <script src="/Project/assets/js/main.js"></script>
    <!-- Icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
