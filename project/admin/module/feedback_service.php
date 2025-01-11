<?php
require_once "/xampp/htdocs/Project/config/admincheck.php";
require_once "/xampp/htdocs/Project/config/db.php";

// Validate the Service ID from the query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Service ID");
}

$service_id = intval($_GET['id']);

// Fetch service details
$service_query = "SELECT * FROM services WHERE SERVICE_ID = ?";
$service_stmt = $conn->prepare($service_query);
if (!$service_stmt) {
    die("Service query preparation failed: " . $conn->error);
}
$service_stmt->bind_param("i", $service_id);
$service_stmt->execute();
$service_result = $service_stmt->get_result();
$service = $service_result->fetch_assoc();

if (!$service) {
    die("Service not found");
}

// Fetch feedback for the service
$feedback_query = "SELECT * FROM feedback WHERE SERVICE_ID = ? ORDER BY FEEDBACK_ID ASC";
$feedback_stmt = $conn->prepare($feedback_query);
if (!$feedback_stmt) {
    die("Feedback query preparation failed: " . $conn->error);
}
$feedback_stmt->bind_param("i", $service_id);
$feedback_stmt->execute();
$feedback_result = $feedback_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Feedback</title>
    <link rel="stylesheet" href="asserts/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
            color: #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-feedback {
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <?php require_once "/xampp/htdocs/Project/admin/Nav.php"; ?>

    <div class="main">
        <?php require_once "/xampp/htdocs/Project/admin/main.php"; ?>
        <div class="container">
            <h1>Service Feedback</h1>

            <!-- Display Service Details -->
            <h2>Service Details</h2>
            <p><strong>Service ID:</strong> <?php echo htmlspecialchars($service["SERVICE_ID"]); ?></p>
            <p><strong>Service Name:</strong> <?php echo htmlspecialchars($service["SERVICE_NAME"]); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($service["DESCRIPTION"]); ?></p>

            <h2>Feedback</h2>
            <?php if ($feedback_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Feedback ID</th>
                            <th>Customer ID</th>
                            <th>Order ID</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($feedback["FEEDBACK_ID"]); ?></td>
                                <td><?php echo htmlspecialchars($feedback["CUSTOMER_ID"]); ?></td>
                                <td><?php echo htmlspecialchars($feedback["ORDER_ID"]); ?></td>
                                <td><?php echo htmlspecialchars($feedback["COMMENT"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-feedback">No feedback available for this service.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>