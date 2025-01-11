<?php
require_once "/xampp/htdocs/Project/config/admincheck.php";
require_once "/xampp/htdocs/Project/config/db.php";

// Validate the Product ID from the query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Product ID");
}

$product_id = intval($_GET['id']);

// Fetch product details
$product_query = "SELECT * FROM product WHERE PRODUCT_ID = ?";
$product_stmt = $conn->prepare($product_query);
if (!$product_stmt) {
    die("Product query preparation failed: " . $conn->error);
}
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();
$product = $product_result->fetch_assoc();

if (!$product) {
    die("Product not found");
}

// Fetch reviews for the product
$review_query = "SELECT * FROM review WHERE PRODUCT_ID = ? ORDER BY REVIEW_ID ASC";
$review_stmt = $conn->prepare($review_query);
if (!$review_stmt) {
    die("Review query preparation failed: " . $conn->error);
}
$review_stmt->bind_param("i", $product_id);
$review_stmt->execute();
$reviews_result = $review_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        p {
            margin: 8px 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: #fff;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .no-reviews {
            text-align: center;
            color: #999;
            font-size: 16px;
            margin-top: 20px;
        }

        a,
        button {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Include Navigation -->
    <?php require_once "/xampp/htdocs/Project/admin/Nav.php"; ?>

    <div class="main">
        <?php require_once "/xampp/htdocs/Project/admin/main.php"; ?>
        <div class="container">
            <h1>Product Reviews</h1>

            <!-- Display Product Details -->
            <h2>Product Details</h2>
            <p><strong>Product ID:</strong> <?php echo htmlspecialchars($product["PRODUCT_ID"]); ?></p>
            <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product["PRODUCT_NAME"]); ?></p>
            <p><strong>Price:</strong> ₹<?php echo number_format((float)$product["PRICE"], 2); ?></p>

            <!-- Display Reviews -->
            <h2>Reviews</h2>
            <?php if ($reviews_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Review ID</th>
                            <th>Customer ID</th>
                            <th>Rating</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($review = $reviews_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review["REVIEW_ID"]); ?></td>
                                <td><?php echo htmlspecialchars($review["CUSTOMER_ID"]); ?></td>
                                <td><?php echo htmlspecialchars($review["RATING"]); ?></td>
                                <td><?php echo htmlspecialchars($review["REVIEW"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-reviews">No reviews available for this product.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>