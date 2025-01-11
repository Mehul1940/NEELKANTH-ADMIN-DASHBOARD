<?php
// Start session
session_start();
?>
<?php require_once "./config/db.php" ?>
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["Email"];
    $password = $_POST["Password"];

    // Query to check login credentials
    $sql = "SELECT * FROM login WHERE email='" . $email . "' AND Password='" . $password . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    // If login is successful, set session variables and redirect
    if ($row) {
        $_SESSION['user_email'] = $row["email"]; // Store email in session
        $_SESSION['userType'] = $row["userType"]; // Store user type in session

        if ($row["userType"] == "user") {
            header("Location: user-dashboard.php");
            exit();
        }
        if ($row["userType"] == "admin") {
            header("Location: admin/module/dashboard.php");
            exit();
        }
    } else {
        $error_message = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="asserts/css/style.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            width: 400px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            text-align: left;
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0056b3;
            background-color: #fff;
        }

        .form-group input[type="submit"] {
            background-color: #0056b3;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #004085;
        }

        .error-message {
            margin-top: 10px;
            color: #ff0000;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <form action="#" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="Password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
            <div class="error-message">
                <?php
                if (isset($error_message)) {
                    echo $error_message;
                }
                ?>
            </div>
        </form>
    </div>
</body>

</html>