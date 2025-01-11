<?php
require_once "/xampp/htdocs/Project/config/db.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $serviceName = trim($_POST['SERVICE_NAME'] ?? '');
    $description = trim($_POST['DESCRIPTION'] ?? '');

    // Validate inputs
    if (!empty($serviceName) && !empty($description)) {
        // Prepare and execute the insert query
        $query = "INSERT INTO services (SERVICE_NAME, DESCRIPTION) VALUES (?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $serviceName, $description);
            if ($stmt->execute()) {
                // Success: Redirect to the services page
                header("Location: /Project/admin/module/service.php?add=success");
                exit();
            } else {
                // Query execution error
                $error = "Failed to add service. Please try again.";
            }
            $stmt->close();
        } else {
            // Query preparation error
            $error = "Failed to prepare the add query. Please try again.";
        }
    } else {
        // Validation error
        $error = "All fields are required. Please fill out the form completely.";
    }

    // If an error occurred, redirect with the error message
    header("Location: /Project/admin/module/service.php?add=error&message=" . urlencode($error));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007BFF;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }

        button {
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #007BFF;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add New Service</h1>
        <form action="/Project/admin/add/add_service.php" method="POST">
            <label for="SERVICE_NAME">Service Name</label>
            <input type="text" id="SERVICE_NAME" name="SERVICE_NAME" required>
            
            <label for="DESCRIPTION">Description</label>
            <textarea id="DESCRIPTION" name="DESCRIPTION" rows="4" required></textarea>
            
            <button type="submit">Add Service</button>
        </form>
        <a class="back-link" href="/Project/admin/module/service.php">Back to Services</a>
    </div>
</body>
</html>
