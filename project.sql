-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 09:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BOOKING_ID` int(11) NOT NULL,
  `ESTIMATE_ID` int(11) DEFAULT NULL,
  `BOOKING_DATE` date NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `STATUS` char(50) NOT NULL,
  `PICKUP_STATUS` varchar(30) NOT NULL,
  `DELIVERY_STATUS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BOOKING_ID`, `ESTIMATE_ID`, `BOOKING_DATE`, `ADDRESS`, `STATUS`, `PICKUP_STATUS`, `DELIVERY_STATUS`) VALUES
(1, 2, '2024-07-20', 'I-203 SAHAJ RESIDENCY NR KARNAVATI MEGA MALL', 'COMPLETED', 'COMPLETED', 'COMPLETED'),
(2, 3, '2024-07-20', 'D-20 SHANTI NIWAS AJIT MILL', 'SCHEDULED', '', ''),
(3, 2, '2024-10-20', 'B/126 DURGANAGAR TENAMENT SILVERCITY AHEMDABAD', 'PENDING', 'PENDING', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `BRAND_ID` int(11) NOT NULL,
  `BRAND_NAME` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`BRAND_ID`, `BRAND_NAME`) VALUES
(234, 'APPLE'),
(235, 'SONY'),
(345, 'JBL'),
(564, 'BOAT'),
(864, 'PROTAN');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CART_ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CART_ID`, `CUSTOMER_ID`) VALUES
(501, 101),
(507, 104),
(546, 105);

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `C_ID` int(11) NOT NULL,
  `CART_ID` int(11) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `PRICE` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`C_ID`, `CART_ID`, `PRODUCT_ID`, `QUANTITY`, `PRICE`) VALUES
(102, 501, 108, 2, 285000.00),
(342, 507, 108, 1, 148000.00),
(345, 546, 53, 2, 7998.00),
(364, 503, 432, 1, 6999.00),
(756, 504, 203, 1, 6999.00);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CATEGORY_ID` int(11) NOT NULL,
  `CATEGORY_NAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CATEGORY_ID`, `CATEGORY_NAME`) VALUES
(101, 'HEADPHONES'),
(102, 'EARPHONES'),
(108, 'MOBILES'),
(203, 'CHARGERS'),
(645, 'VR-BOXES');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `COMPLAINT_ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  `SERVICE_ID` int(11) DEFAULT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `COMMENT` varchar(250) DEFAULT NULL,
  `REPLY` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`COMPLAINT_ID`, `CUSTOMER_ID`, `SERVICE_ID`, `ORDER_ID`, `COMMENT`, `REPLY`) VALUES
(1, 106, 1, 0, 'YOU DID NOT REPLAY MAY BE I WAS WRONG ABOUT WHAT I HEARD', 'i am so sorry for not repling'),
(2, 103, 1, 0, 'THEY ACCEPTED BUT DID NOT REPLIED FOR MY BOOKED SERVICE', 'your service will take place sorry for inconveince'),
(3, 109, 0, 945, 'I DID NOT RECEIVED MY ORDER YET', 'there is a technical issue you will receive your order really quick sorry for inconveince');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `CUSTOMER_NAME` varchar(250) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE` varchar(10) NOT NULL,
  `ADDRESS` varchar(250) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUSTOMER_ID`, `CUSTOMER_NAME`, `EMAIL`, `PHONE`, `ADDRESS`, `PASSWORD`) VALUES
(101, 'SHANKHLA HARSH', 'harshshankhla9@gmail.com', '9157091014', 'A/36 DURGANAGAR GHODASAR AHEMDABAD', 'HRS100K'),
(102, ' NAGAR DEVARSH', 'devarsh69@gmail.com', '9974311810', 'A/26 MARUTI TENAMENT VASTRAL AHEMDABAD', 'devkkb'),
(103, 'BOKADE MEHUL', 'mehul7@gmail.com', '9725775802', 'B/126 DURGANAGAR TENAMENT SILVERCITY AHEMDABAD', 'PABLOMEHUL7'),
(104, 'KRISHNA', 'KKS3457@gmail.com', '8160083458', 'A/16 KAMDHENU TENAMENT JASHODANAGAR AHEMDABAD', 'SKH3457'),
(105, 'MAURYA GAYATRI', 'mauryag20@gmail.com', '7654322298', 'C-101 PURVADEEP APPARTMENTS JAIN-MANDIR ROAD AHEMDABAD', 'gayu1520'),
(106, 'PATEL PRIYASH', 'patelpriyansh@gmail.com', '8182014851', 'D/302 JOGESHWARI VILLA WONDER POINT AHEMDABAD', '1234557'),
(107, 'PARIKH VATSAL', 'parikhvatsal@gmail.com', '9192954852', 'I-203 SAHAJ RESIDENCY NR KARNAVATI MEGA MALL AHEMDABAD', 'WPHTOGRAPHER'),
(108, 'KANAK', 'kanak@gmail.com', '9865755451', 'A/56 MARUTI TENAMENT VASTRAL AHEMDABAD', 'kanak100sk'),
(109, 'BHUMIKA', 'bhumika@gmail.com', '9023864926', 'A/46 MARUTI TENAMENT VASTRAL AHEMDABAD', 'bhumika100bk');

-- --------------------------------------------------------

--
-- Table structure for table `estimate`
--

CREATE TABLE `estimate` (
  `ESTIMATE_ID` int(11) NOT NULL,
  `SERVICE_ID` int(11) DEFAULT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  `SUGGESTED_PRICE` decimal(11,2) NOT NULL,
  `STATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estimate`
--

INSERT INTO `estimate` (`ESTIMATE_ID`, `SERVICE_ID`, `CUSTOMER_ID`, `SUGGESTED_PRICE`, `STATUS`) VALUES
(1, 1, 106, 3000.00, 'REJECTED'),
(2, 3, 107, 3500.00, 'ACCEPTED'),
(3, 2, 106, 350.00, 'ACCEPTED'),
(4, 1, 103, 2950.00, 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FEEDBACK_ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  `SERVICE_ID` int(11) DEFAULT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `COMMENT` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FEEDBACK_ID`, `CUSTOMER_ID`, `SERVICE_ID`, `ORDER_ID`, `COMMENT`) VALUES
(1, 106, 2, 0, 'GOOD SERVICE BUT BIT EXPENSIVE'),
(2, 107, 3, 0, 'EXCELLENT SERVICE,TIMELY AND PROFESSIONAL'),
(3, 108, 1, 512, 'THEY SELL GOOD PRODUCTS');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `STOCK_ID` int(11) NOT NULL,
  `STOCK_NAME` varchar(70) DEFAULT NULL,
  `CATEGORY_ID` int(11) DEFAULT NULL,
  `BRAND_ID` int(11) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `CURRENT_UNITS` int(11) DEFAULT NULL,
  `UNITS_REQUIRED` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`STOCK_ID`, `STOCK_NAME`, `CATEGORY_ID`, `BRAND_ID`, `PRODUCT_ID`, `CURRENT_UNITS`, `UNITS_REQUIRED`) VALUES
(1, 'MOBILES', 108, 234, 108, 24, 25),
(2, 'CHARGERS', 203, 864, 567, 100, 20),
(3, 'HEADPHONES', 101, 564, 432, 23, 0),
(4, 'EARPHONES', 102, 345, 345, 10, 15),
(5, 'VR_BOXES', 645, 235, 432, 21, 12);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `userType`) VALUES
(1, 'bokdemehul870@gmail.com', 'Mehul@1940', 'admin'),
(2, 'harsh123@gmail.com', 'harsh123', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `OFFER_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `OFFER_NAME` varchar(100) DEFAULT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `DISCOUNT_RATE` int(11) NOT NULL,
  `DESCRIPTION` varchar(250) DEFAULT NULL,
  `OFFER_IMG` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`OFFER_ID`, `PRODUCT_ID`, `OFFER_NAME`, `START_DATE`, `END_DATE`, `DISCOUNT_RATE`, `DESCRIPTION`, `OFFER_IMG`) VALUES
(1, 108, 'PRE-Uttryan Offer', '2025-01-01', '2025-01-30', 10, 'come and get the seller', '/Project/uploads/Screenshot 2025-01-09 164813.png'),
(2, 345, 'PRE-Uttryan Offer', '2025-01-01', '2025-01-23', 12, 'come and get the best offer for wired headsets', '/Project/uploads/Screenshot 2025-01-06 122356.png'),
(3, 567, 'POST-Uttryan Offer', '2025-01-23', '2025-02-09', 16, 'get the best charger offer for post uttryan', '../../uploads/1654100268.jpg'),
(4, 596, 'Sale Offer', '2024-12-30', '2025-01-28', 25, 'Buy This And You will never regret', '../../uploads/797744981.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ORDER_ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  `TOTAL_AMT` decimal(11,2) NOT NULL,
  `DELIVERY_ADDRESS` varchar(250) NOT NULL,
  `DELIVERY_STATUS` varchar(50) NOT NULL,
  `order_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDER_ID`, `CUSTOMER_ID`, `TOTAL_AMT`, `DELIVERY_ADDRESS`, `DELIVERY_STATUS`, `order_date`) VALUES
(512, 108, 6999.00, 'A/56 MARUTI TENAMENT VASTRAL AHEMDABAD', 'Completed', '2025-01-08'),
(645, 104, 147000.00, 'A/16 KAMDHENU SOCIETY JASHODANAGAR AHEMDABAD', 'Completed', '2025-03-07'),
(708, 101, 285000.00, 'A/26  MARUTI TENAMENT VASTRAL AHEMDABAD', 'Completed', '2025-03-06'),
(944, 105, 7998.00, 'C-34 NILE CITY SHITTALCHAYA SOCIETY TAKSHISHILLA ROAD AHEMDABAD', 'Completed', '2025-04-09'),
(945, 109, 6999.00, 'A/46 MARUTI TENAMENT VASTRAL AHEMDABAD', 'Completed', '2025-02-10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OITEM_ID` int(11) NOT NULL,
  `O_ID` int(11) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `TOTAL_AMT` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OITEM_ID`, `O_ID`, `PRODUCT_ID`, `QUANTITY`, `TOTAL_AMT`) VALUES
(1, 512, 432, 1, 6999.00),
(2, 645, 108, 1, 148000.00),
(3, 708, 108, 2, 285000.00),
(4, 944, 53, 2, 7998.00),
(5, 945, 567, 1, 6999.00);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PAYMENT_ID` int(11) NOT NULL,
  `TOTAL_AMT` decimal(11,2) DEFAULT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `BOOKING_ID` int(11) DEFAULT NULL,
  `STATUS` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAYMENT_ID`, `TOTAL_AMT`, `ORDER_ID`, `BOOKING_ID`, `STATUS`) VALUES
(707, 285000.00, 708, 0, 'Pending'),
(708, 147000.00, 645, 0, 'Completed'),
(809, 2999.00, 944, 0, 'Pending'),
(979, 3500.00, 945, 1, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `PRODUCT_ID` int(11) NOT NULL,
  `PRODUCT_NAME` varchar(100) NOT NULL,
  `CATEGORY_ID` int(11) DEFAULT NULL,
  `BRAND_ID` int(11) DEFAULT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `P_IMG` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_ID`, `PRODUCT_NAME`, `CATEGORY_ID`, `BRAND_ID`, `PRICE`, `P_IMG`) VALUES
(345, 'C-50HI WIRED HEADSET', 102, 345, 3999.00, 'imgs/product/Screenshot 2025-01-06 122356.png'),
(432, 'BOAT-C3 HEADPHONES', 102, 564, 5999.00, 'imgs/product/Screenshot 2025-01-06 120253.png'),
(567, 'VOLTAZWSW USB C-TYPE CHARGERS', 203, 864, 500.00, 'imgs/product/VOLTAZWSW USB C-TYPE CHARGERS.jpg'),
(595, 'Tune 510BT', 234, 66999, 10100.00, '/imgs/product/Screenshot 2025-01-09 164813.png'),
(596, 'iPhone 16 Pro', 234, 66999, 99991.00, 'imgs/product/Screenshot 2025-01-06 115730.png'),
(601, 'Xperia 5', 234, 66999, 10800.00, 'imgs/product/Screenshot 2025-01-06 122149.png'),
(602, 'Jv enterprise Ultra pods New Bluetooth 5.3 Earbuds', 345, 700, 102.00, 'imgs/product/Screenshot 2025-01-10 134829.png');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `REVIEW_ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `RATING` int(11) DEFAULT NULL,
  `REVIEW` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`REVIEW_ID`, `CUSTOMER_ID`, `PRODUCT_ID`, `RATING`, `REVIEW`) VALUES
(1, 101, 601, 5, 'AWESOME SHOP TO BUY PRODUCTS THEY DELIVERS PRODUCTS TIMELY'),
(2, 105, 596, 4, 'I GOT MY PHONE AT GOOD RATE AND THEY DELIVERED IT TIMELY ');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `SERVICE_ID` int(11) NOT NULL,
  `SERVICE_NAME` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`SERVICE_ID`, `SERVICE_NAME`, `DESCRIPTION`) VALUES
(1, 'SCREEN REPAIRS', 'FIX SCREEN ISSUES AND DAMAGES'),
(2, 'CHARGING SOCKET REPAIR', 'FIX CHARGING SOCKET'),
(3, 'CAMERA REPAIR', 'FIX CAMERA IF IT IS NOT WORKING'),
(4, 'Volumn Button Repair', 'Any Sound Problem  Will Be repair ');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `STAFF_ID` int(11) NOT NULL,
  `STAFF_NAME` varchar(50) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE` varchar(10) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`STAFF_ID`, `STAFF_NAME`, `EMAIL`, `PHONE`, `ADDRESS`) VALUES
(122, 'PARIHAR ANURAG', 'pariharanurag@gmail.com', '9723862723', 'A-56 AJAY TENAMENT RITA NAGAR AHEMDABAD'),
(123, 'PANCHAL HET', 'panchalhet7@gmail.com', '9982637273', 'A-212 ABHAY APPARTMENTS NIRANT CROSS ROAD AHEMDABA'),
(133, 'KANOJIYA SHIVAM', 'kanojiyask@gmail.com', '9087253625', ' A/55 SHREERAM STREET VASTRAL AHEMDABAD '),
(234, 'PANCHAL BRIJESH ', 'panchalbrijesh@gmail.com', '8727362735', 'A-302 MADHAV ORCHID ODHAV AHEMDABAD'),
(333, 'SHARMA RISHAB', 'rishabsharma77@gmail.com', '7263526354', 'B-105 SHREE KAMDHENU APPARMENTS RTOROAD AHEMDABAD');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SUPPLIER_ID` int(11) NOT NULL,
  `SUPPLIER_NAME` varchar(50) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE` varchar(10) NOT NULL,
  `ADDRESS` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SUPPLIER_ID`, `SUPPLIER_NAME`, `EMAIL`, `PHONE`, `ADDRESS`) VALUES
(127, 'GUPTA SAHIL', 'sahil@gmail.com', '9928364927', 'SHOP N0-101 SUDARSHAN GADGETS GAYATRI ROAD VIRATNAGAR AHEMDABAD'),
(132, 'RAO KIRTIPAL', 'raokirti@gmail.com', '9037286328', 'A-444,445 RAMJI MOBILES VAISHALINAGAR JAIPUR RAJASTHAN'),
(142, 'SHARMA RONIT', 'ronits@gmail.com', '7723668258', 'SHOP NO-453 GURU MEHER ELECTRONICS BABA DEEPSINGHJI ROAD AMRITSAR PUNJAB'),
(157, 'SHIKHAR DHAWAN', 'skdhawan@gmail.com', '9872368237', 'A/557 SHREE RATANJI DIGITALS RANJIT NAGAR PATIALA PUNJAB');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BOOKING_ID`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BRAND_ID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CART_ID`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`C_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CATEGORY_ID`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`COMPLAINT_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CUSTOMER_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `estimate`
--
ALTER TABLE `estimate`
  ADD PRIMARY KEY (`ESTIMATE_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FEEDBACK_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`STOCK_ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`OFFER_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ORDER_ID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OITEM_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PAYMENT_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`PRODUCT_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`REVIEW_ID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`SERVICE_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`STAFF_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SUPPLIER_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `OFFER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=946;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=604;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `SERVICE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SUPPLIER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
