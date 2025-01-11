<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <style>
        .nav {
            position: fixed;
            width: 300px;
            height: 100%;
            background: var(--blue);
            border-left: 10px solid var(--blue);
            transition: 0.5s;
            overflow-y: auto;
            /* Allow scrolling vertically */
            padding-top: 20px;
            /* Add padding to top for spacing */
        }

        /* Hide scrollbar */
        .nav::-webkit-scrollbar {
            display: none;
        }

        .nav.active {
            width: 70px;
        }

        .nav ul {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .nav ul li {
            position: relative;
            width: 100%;
            list-style: none;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        .nav ul li:hover,
        .nav ul li.hovered {
            background-color: var(--white);
        }

        .nav ul li:nth-child(1) {
            margin-bottom: 40px;
            pointer-events: none;
        }

        .nav ul li a {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            text-decoration: none;
            color: var(--white);
            padding: 0 10px;
        }

        .nav ul li:hover a,
        .nav ul li.hovered a {
            color: var(--blue);
        }

        .nav ul li a .icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 60px;
            height: 60px;
        }

        .nav ul li a .icon ion-icon {
            font-size: 1.75rem;
        }

        .nav ul li a span:last-child {
            position: relative;
            display: block;
            padding-left: 10px;
            height: 60px;
            line-height: 60px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="nav">
        <ul>
            <li>
                <a href="module/dashboard.php"><span class="icon"><ion-icon name="logo-apple"></ion-icon></span><span class="icon">NILKANTH MOBILES</span></a>
            </li>
            <li>
                <a href="dashboard.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="icon">DashBoard</span></a>
            </li>

            <!-- Admin-specific menu items -->
            <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 'admin'): ?>
                <li>
                    <a href="customer.php"><span class="icon"><ion-icon name="people-circle-outline"></ion-icon></span><span class="icon">Customer</span></a>
                </li>
                <li>
                    <a href="order.php"><span class="icon"><ion-icon name="cart-outline"></ion-icon></span><span class="icon">Orders</span></a>
                </li>
                <li>
                    <a href="payment.php"><span class="icon"><ion-icon name="card-outline"></ion-icon></span><span class="icon">Earning</span></a>
                </li>
                <li>
                    <a href="inventory.php"><span class="icon"><ion-icon name="create-outline"></ion-icon></span><span class="icon">Inventory</span></a>
                </li>
                <li>
                    <a href="product.php"><span class="icon"><ion-icon name="cube-outline"></ion-icon></span><span class="icon">Product</span></a>
                </li>

                <li>
                    <a href="offer.php"><span class="icon"><ion-icon name="pricetags-outline"></ion-icon></span><span class="icon">Offer</span></a>
                </li>
                <li>
                    <a href="service.php"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="icon">Services</span></a>
                </li>

                <li>
                    <a href="supplier.php"><span class="icon"><ion-icon name="swap-horizontal-outline"></ion-icon></span><span class="icon">Supplier</span></a>
                </li>
                <li>
                    <a href="complaint.php"><span class="icon"><ion-icon name="chatbubbles-outline"></ion-icon></span><span class="icon">Complaint</span></a>
                </li>
            <?php endif; ?>

            <!-- User-specific menu items -->
            <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 'user'): ?>
                <li>
                    <a href="user-dashboard.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="icon">User Dashboard</span></a>
                </li>
                <li>
                    <a href="my-orders.php"><span class="icon"><ion-icon name="cart-outline"></ion-icon></span><span class="icon">My Orders</span></a>
                </li>
                <li>
                    <a href="user-profile.php"><span class="icon"><ion-icon name="person-outline"></ion-icon></span><span class="icon">Profile</span></a>
                </li>
            <?php endif; ?>
            <li>
                <a href="/Project/logout.php"><span class="icon"><ion-icon name="log-out-outline"></ion-icon></span><span class="icon">Log Out</span></a>
            </li>
        </ul>
    </div>
</body>

</html>