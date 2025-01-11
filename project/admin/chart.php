<?php require_once "/xampp/htdocs/Project/config/db.php" ?> 
<?php
// Query to get the number of orders for each month
$orderQuery = "
    SELECT 
        MONTH(order_date) AS month, 
        COUNT(*) AS order_count
    FROM 
        orders 
    WHERE 
        DELIVERY_STATUS = 'Completed'
    GROUP BY 
        MONTH(order_date)
    ORDER BY 
        MONTH(order_date) ASC
";
$orderResult = $conn->query($orderQuery);

// Prepare data for Recent Orders chart
$months = array_fill(1, 12, 0); // Array with all months initialized to 0

if ($orderResult) {
    if ($orderResult->num_rows > 0) {
        while ($row = $orderResult->fetch_assoc()) {
            $months[(int)$row['month']] = $row['order_count']; // Replace counts for existing months
        }
    } else {
        echo "No order data found.";
    }
} else {
    echo "Error in executing order query: " . $conn->error;
}

// Query to get revenue by status
$revenueQuery = "
    SELECT 
        STATUS, 
        SUM(TOTAL_AMT) AS total_revenue
    FROM 
        payment
    GROUP BY 
        STATUS
";
$revenueResult = $conn->query($revenueQuery);

// Prepare data for Revenue by Status chart
$statuses = [];
$revenues = [];

if ($revenueResult) {
    if ($revenueResult->num_rows > 0) {
        while ($row = $revenueResult->fetch_assoc()) {
            $statuses[] = $row['STATUS']; // Dynamic handling of all statuses
            $revenues[] = $row['total_revenue'];
        }
    } else {
        echo "No revenue data found.";
    }
} else {
    echo "Error in executing revenue query: " . $conn->error;
}

// Close the connection
$conn->close();

// Month labels for display
$monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// Order counts as values
$orderCounts = array_values($months);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders and Revenue Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .chart-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }

        .chart-container {
            flex: 1 1 45%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-width: 300px;
        }

        canvas {
            max-width: 100%;
            height: auto;
        }

        h3 {
            margin-bottom: 10px;
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="chart-wrapper">
        <!-- Recent Orders Bar Chart -->
        <div class="chart-container">
            <h3>Recent Orders</h3>
            <canvas id="recentOrdersChart"></canvas>
        </div>

        <!-- Revenue by Status Bar Chart -->
        <div class="chart-container">
            <h3>Revenue by Status</h3>
            <canvas id="revenueByStatusChart"></canvas>
        </div>
    </div>

    <script>
        // Prepare data for the Recent Orders chart
        const months = <?php echo json_encode($monthLabels); ?>; // Full month names
        const orderCounts = <?php echo json_encode($orderCounts); ?>; // Orders for all months

        // Configuration for the Recent Orders Bar Chart
        const recentOrdersConfig = {
            type: 'bar', // Bar chart
            data: {
                labels: months, // Full month names
                datasets: [{
                    label: 'Number of Orders',
                    data: orderCounts, // Number of orders for each month
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Bar color
                    borderColor: 'rgba(54, 162, 235, 1)', // Border color
                    borderWidth: 1,
                    barThickness: 30 // Adjust bar thickness
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => `Orders: ${context.raw}`
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    }
                }
            }
        };

        // Prepare data for the Revenue by Status chart
        const statuses = <?php echo json_encode($statuses); ?>;
        const revenues = <?php echo json_encode($revenues); ?>;

        // Configuration for the Revenue by Status Bar Chart
        const revenueByStatusConfig = {
            type: 'bar', // Bar chart
            data: {
                labels: statuses, // Payment statuses dynamically loaded
                datasets: [{
                    label: 'Revenue',
                    data: revenues, // Revenue for each status
                    backgroundColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'], // Colors for each status
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1,
                    barThickness: 50 // Adjust bar thickness
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => `Revenue: $${context.raw.toLocaleString()}`
                        }
                    },
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (in USD)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Payment Status'
                        }
                    }
                }
            }
        };

        // Render the Recent Orders Bar Chart
        const recentOrdersChartCtx = document.getElementById('recentOrdersChart').getContext('2d');
        new Chart(recentOrdersChartCtx, recentOrdersConfig);

        // Render the Revenue by Status Bar Chart
        const revenueByStatusChartCtx = document.getElementById('revenueByStatusChart').getContext('2d');
        new Chart(revenueByStatusChartCtx, revenueByStatusConfig);
    </script>
</body>

</html>