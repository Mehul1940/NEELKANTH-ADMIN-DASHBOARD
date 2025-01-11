<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <!-- Style -->
    <link rel="stylesheet" href="/Project/assets/css/style.css">
</head>

<body>
    <div class="container">
        <!-- Include Navigation -->
        <?php require_once "../Nav.php" ?>

        <!-- Main Content -->
        <div class="main">
            <?php require_once "../main.php" ?>
           

            <!-- Customer Table -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>CUSTOMER ID</td>
                                <td>CUSTOMER NAME</td>
                                <td>EMAIL</td>
                                <td>PHONE</td>
                                <td>ADDRESS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database Connection
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "project";
                            $conn = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($conn->connect_error) {
                                echo '<tr><td colspan="5">Database connection failed: ' . htmlspecialchars($conn->connect_error) . '</td></tr>';
                                exit();
                            }

                            // SQL Query
                            $sql = "SELECT * FROM customer";
                            $result = $conn->query($sql);

                            // Check for Results
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                                        <td>' . htmlspecialchars($row["CUSTOMER_ID"]) . '</td>
                                        <td>' . htmlspecialchars($row["CUSTOMER_NAME"]) . '</td>
                                        <td>' . htmlspecialchars($row["EMAIL"]) . '</td>
                                        <td>' . htmlspecialchars($row["PHONE"]) . '</td>
                                        <td>' . htmlspecialchars($row["ADDRESS"]) . '</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">No customers found</td></tr>';
                            }

                            // Close Connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/Project/assets/js/main.js"></script>
    <!-- IonIcons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>