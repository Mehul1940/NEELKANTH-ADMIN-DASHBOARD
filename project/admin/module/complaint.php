<?php
require_once "/xampp/htdocs/Project/config/admincheck.php";
require_once "/xampp/htdocs/Project/config/db.php";

// Fetch all complaints
$complaintQuery = "SELECT * FROM complaint";
$complaintResult = $conn->query($complaintQuery);

if (!$complaintResult) {
    die("Query Failed: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle admin reply submission
    $complaint_id = $_POST['complaint_id'];
    $reply = $_POST['reply'];

    $updateQuery = "UPDATE complaint SET REPLY = ? WHERE COMPLAINT_ID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $reply, $complaint_id);

    if ($stmt->execute()) {
        echo "<script>alert('Reply added successfully.');</script>";
    } else {
        echo "<script>alert('Failed to add reply.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <style>
        /* Add your styles here */
        .complaint-container {
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

        table {
            width: 100%;
            border-collapse: collapse;
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
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .reply-form {
            margin-top: 10px;
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

        .reply-btn {
            background-color: #28a745;
        }

        .reply-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <!-- Include Navigation -->
    <?php require_once "../Nav.php" ?>

    <!-- Main Content -->
    <div class="main">
        <?php require_once "../main.php" ?>
        <div class="complaint-container">
            <h1>Manage Complaints</h1>

            <?php if ($complaintResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Complaint ID</th>
                            <th>Customer ID</th>
                            <th>Service ID</th>
                            <th>Order ID</th>
                            <th>Comment</th>
                            <th>Admin Reply</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($complaint = $complaintResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($complaint['COMPLAINT_ID']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['CUSTOMER_ID']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['SERVICE_ID']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['ORDER_ID']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['COMMENT']); ?></td>
                                <td>
                                    <?php if (!empty($complaint['REPLY'])): ?>
                                        <p><strong>Reply:</strong> <?php echo htmlspecialchars($complaint['REPLY']); ?></p>
                                    <?php else: ?>
                                        <span>No reply yet.</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form class="reply-form" action="" method="POST">
                                        <input type="hidden" name="complaint_id" value="<?php echo $complaint['COMPLAINT_ID']; ?>">
                                        <textarea name="reply" rows="3" placeholder="Write your reply here..." required></textarea><br>
                                        <button type="submit" class="action-btn reply-btn">Reply</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No complaints found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>