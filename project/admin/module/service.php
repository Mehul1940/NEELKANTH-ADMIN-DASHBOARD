<?php require_once "/xampp/htdocs/Project/config/admincheck.php"; ?>
<?php require_once "/xampp/htdocs/Project/config/db.php"; ?>
<?php
// Query to fetch service data
$serviceQuery = "SELECT SERVICE_ID, SERVICE_NAME, DESCRIPTION FROM services";
$serviceResult = $conn->query($serviceQuery);

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .service-container {
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

        .add-service-form {
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

        td:first-child {
            font-weight: bold;
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

            .add-service-form {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .service-btn {
            background-color: #007BFF;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 10px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-form label {
            font-weight: bold;
        }

        .modal-form input,
        .modal-form textarea {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .modal-form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php require_once "/xampp/htdocs/Project/admin/Nav.php"; ?>

    <div class="main">
        <?php require_once "/xampp/htdocs/Project/admin/main.php"; ?>
        <div class="service-container">
            <h1>Our Services</h1>

            <div class="add-service-form">
                <a href="/Project/admin/add/add_service.php" class="add-btn">Add New Service</a>
            </div>

            <?php if ($serviceResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Service ID</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $serviceResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['SERVICE_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['SERVICE_NAME']); ?></td>
                                <td><?php echo htmlspecialchars($row['DESCRIPTION']); ?></td>
                                <td>
                                    <button class="action-btn update-btn" onclick="openModal('<?php echo $row['SERVICE_ID']; ?>', '<?php echo addslashes($row['SERVICE_NAME']); ?>', '<?php echo addslashes($row['DESCRIPTION']); ?>')">Update</button>
                                    <form action="/Project/admin/delete/delete_service.php" method="POST" style="display: inline;">
                                        <button type="submit" name="service_id" value="<?php echo $row['SERVICE_ID']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this service?');">Delete</button>
                                    </form>
                                    <form action="feedback_service.php" method="get" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row["SERVICE_ID"]); ?>">
                                        <button class="action-btn service-btn" type="submit">Feedback</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #666;">No services found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Update Service</h2>
            <form class="modal-form" action="/Project/admin/update/update_service.php" method="POST">
                <input type="hidden" name="SERVICE_ID" id="modal-service-id">
                <label for="SERVICE_NAME">Service Name:</label>
                <input type="text" id="modal-service-name" name="SERVICE_NAME" required>
                <label for="DESCRIPTION">Description:</label>
                <textarea id="modal-description" name="DESCRIPTION" rows="4" required></textarea>
                <button type="submit">Update Service</button>
            </form>
        </div>
    </div>
    <script src="/Project/assets/js/main.js"></script>
    <script src="/Project/assets/js/updateService.js"></script>
</body>

</html>