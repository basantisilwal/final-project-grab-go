-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 05:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grab&go`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addfood`
--

CREATE TABLE `tbl_addfood` (
  `f_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `availability` enum('available','unavailable') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_addfood`
--

INSERT INTO `tbl_addfood` (`f_id`, `food_name`, `description`, `price`, `category`, `image`, `availability`) VALUES
(3, 'Samosa', 'normal', 15.00, 'starter', 'samosa.jpg', 'unavailable'),
(4, 'Aaluchop', 'less oily', 10.00, 'starter', 'chop.jpg', 'available'),
(5, 'BlackTea', 'less sweet', 15.00, 'starter', 'black tea.jpg', 'available'),
(6, 'White Tea', 'milky', 20.00, 'starter', 'milk-tea.jpg', 'available'),
(7, 'Black Coffee', 'minimal ingrediant', 100.00, 'starter', 'black cofee.jpg', 'available'),
(8, 'Milk Coffee', 'sweet', 150.00, 'starter', 'cofee.jpg', 'available'),
(10, 'Momo', 'So Delicious', 120.00, 'main-course', 'food.jpg', 'available'),
(11, 'Thukpa', 'veg/chicken', 80.00, 'main-course', 'thukpa-Blog.jpg', 'available'),
(12, 'Veg Chaumin', 'with vegetable', 50.00, 'main-course', 'veg chaumin.jpg', 'available'),
(13, 'Chicken Chaumin', 'with vagetable', 60.00, 'main-course', 'chicken chaumin.jpg', 'unavailable'),
(14, 'Parautha', 'with butter', 30.00, 'main-course', 'images (2).jpg', 'available'),
(15, 'Roti', 'with butter', 15.00, 'main-course', 'images (1).jpg', 'available'),
(16, 'Roti Tarkali', 'with tarkali', 40.00, 'main-course', 'images.jpg', 'available'),
(17, 'Sanwitch', 'Delicious', 80.00, 'main-course', 'sanwitch.jpg', 'available'),
(18, 'Pakauda', 'less oily', 10.00, 'starter', 'pakauda.jpg', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` enum('admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logo`
--

CREATE TABLE `tbl_logo` (
  `o_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_logo`
--

INSERT INTO `tbl_logo` (`o_id`, `name`, `path`) VALUES
(1, 'Unicafe.png', 'uploads/logo/67e5f87eed30f_Unicafe.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `cid` int(11) NOT NULL,
  `f_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `food_description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_notification` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`cid`, `f_id`, `name`, `phone`, `food_description`, `quantity`, `preferred_time`, `payment_method`, `status`, `created_at`, `updated_at`, `customer_notification`) VALUES
(21, 18, 'Guest ', '9844905557', 'Pakauda - less oily', 1, '10:03:00', 'cash', 'Confirmed', '2025-03-27 16:17:08', '2025-03-28 02:08:50', NULL),
(24, NULL, 'Manisha Thapa', '9844905557', 'spicy', 1, '10:36:00', 'online', 'Confirmed', '2025-03-25 16:51:13', '2025-03-25 17:30:51', 'Your order has been confirmed!'),
(25, NULL, 'Manisha Thapa', '9844905557', 'sugar', 1, '00:14:00', 'cash', 'Cancelled', '2025-03-25 17:29:21', '2025-03-25 17:30:53', 'Your order has been cancelled!'),
(26, NULL, 'Manisha Thapa', '9844905557', 'kkkk', 1, '01:14:00', 'online', 'Confirmed', '2025-03-25 17:29:52', '2025-03-28 01:29:06', ''),
(27, NULL, 'Manisha Thapa', '9844905557', 'less sugar', 1, '11:15:00', 'cash', 'Confirmed', '2025-03-25 17:30:23', '2025-03-26 09:42:45', 'Your order has been confirmed!'),
(28, NULL, 'kabin Kc', '9846133299', 'spicy', 1, '11:17:00', 'cash', 'Confirmed', '2025-03-25 17:32:37', '2025-03-26 09:44:04', 'Your order has been confirmed!'),
(29, NULL, 'kabin Kc', '9846133299', 'sweet', 1, '11:18:00', 'cash', 'Cancelled', '2025-03-25 17:32:54', '2025-03-26 09:43:16', 'Your order has been cancelled!'),
(30, NULL, 'Manisha Darai', '9816141807', 'spicy', 1, '09:12:00', 'online', 'Cancelled', '2025-03-26 02:28:10', '2025-03-26 09:46:22', 'Your order has been cancelled!'),
(31, NULL, 'pushpa Thapa', '9844905557', 'less sugar', 1, '09:47:00', 'online', 'Confirmed', '2025-03-26 04:01:01', '2025-03-26 04:03:54', 'Your order has been confirmed!'),
(32, NULL, 'Amisha Sundas', '9824157576', 'less suger', 4, '08:30:00', 'cash', 'Confirmed', '2025-03-26 09:34:29', '2025-03-26 09:46:24', 'Your order has been confirmed!'),
(33, NULL, 'Amisha Sundas', '9824157576', 'normal', 1, '08:25:00', 'cash', 'Confirmed', '2025-03-26 09:35:27', '2025-03-26 09:46:27', 'Your order has been confirmed!'),
(34, NULL, 'pushpa Thapa', '9844905557', 'chicken(steam)', 2, '09:25:00', 'online', 'Cancelled', '2025-03-26 09:38:02', '2025-03-26 09:46:30', 'Your order has been cancelled!'),
(35, NULL, 'pushpa Thapa', '9844905557', 'normal', 2, '07:25:00', 'cash', 'Confirmed', '2025-03-26 09:38:57', '2025-03-26 09:46:32', 'Your order has been confirmed!'),
(36, NULL, 'kabin Kc', '9846133299', 'with spicy achar', 2, '07:10:00', 'online', 'Confirmed', '2025-03-26 10:22:33', '2025-03-27 03:02:44', 'Your order has been confirmed!'),
(37, NULL, 'kabin Kc', '9846133299', 'with tarkali', 3, '08:15:00', 'cash', 'Cancelled', '2025-03-26 10:26:59', '2025-03-27 03:03:00', 'Your order has been cancelled!'),
(38, NULL, 'kabin Kc', '9846133299', 'normal', 1, '07:15:00', 'cash', 'Cancelled', '2025-03-26 10:28:05', '2025-03-28 02:12:29', NULL),
(39, 18, 'Guest ', '9846133299', 'Pakauda - less oily', 1, '07:50:00', 'cash', 'Confirmed', '2025-03-28 02:06:28', '2025-03-28 02:08:26', NULL),
(40, 15, 'Guest ', '9846133299', 'Roti - with butter', 1, '08:00:00', 'cash', 'Confirmed', '2025-03-28 02:11:53', '2025-03-28 02:12:16', NULL),
(41, 17, 'Guest ', '9824157576', 'Sanwitch - Delicious', 1, '07:58:00', 'cash', 'Cancelled', '2025-03-28 02:13:42', '2025-03-28 02:13:53', NULL),
(42, 18, 'Guest ', '9844905557', 'Pakauda - less oily', 1, '08:39:00', 'cash', 'Confirmed', '2025-03-28 02:54:56', '2025-03-28 02:55:59', 'Your order has been confirmed!'),
(43, 14, 'Guest ', '9846133299', 'Parautha - with butter', 1, '08:53:00', 'cash', 'Confirmed', '2025-03-28 03:08:40', '2025-03-28 03:08:50', 'Your order has been confirmed!'),
(44, 18, 'Manisha Darai', '9816141807', 'Pakauda - less oily', 1, '09:12:00', 'cash', 'Cancelled', '2025-03-28 03:27:34', '2025-03-28 03:27:44', 'Your order has been cancelled!'),
(45, 16, 'Manisha Darai', '9816141807', 'Roti Tarkali - with tarkali', 1, '11:13:00', 'cash', 'Confirmed', '2025-03-28 03:28:19', '2025-03-28 03:28:24', 'Your order has been confirmed!');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_otp`
--

CREATE TABLE `tbl_otp` (
  `tbl_user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` int(6) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `dashboard_data` text DEFAULT NULL,
  `role` enum('user') NOT NULL DEFAULT 'user',
  `password_reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_otp`
--

INSERT INTO `tbl_otp` (`tbl_user_id`, `first_name`, `last_name`, `address`, `contact_number`, `email`, `username`, `password`, `verification_code`, `profile_pic`, `bio`, `dashboard_data`, `role`, `password_reset_token`, `token_expiry`) VALUES
(20, 'Amisha', 'Sundas', 'Patan', '9824157576', 'ameesaa54@gmail.com', 'amisha', 'amisha@12345', 344658, NULL, NULL, NULL, 'user', NULL, NULL),
(21, 'pushpa', 'Thapa', 'Damauli', '9844905557', 'puspathapamagar017@gmail.com', 'pushpa10', '1234567890', 225493, '67e592fa6abe0_pakauda.jpg', NULL, NULL, 'user', NULL, NULL),
(22, 'kabin', 'Kc', 'Dumre', '9846133299', 'kckabin710@gmail.com', 'kabin', '12345', 820921, NULL, NULL, NULL, 'user', NULL, NULL),
(25, 'Ghan', 'Thapa', 'vyas  3 damauli', '9845633255', 'sinjali.gb@gmail.com', 'ghan thapa', '12', 601091, NULL, NULL, NULL, 'user', NULL, NULL),
(26, 'Manisha', 'Darai', 'Damauli', '9816141807', 'neha888shahi@gmail.com', 'manisha', 'manisha@@12345', 464664, '67e613f62cca1_thukpa-Blog.jpg', NULL, NULL, 'user', 'cccdf7c32cf86380e52e891dad52abe00e1e9ce05807b348f1373659984d0517', '2025-03-26 19:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_qr`
--

CREATE TABLE `tbl_qr` (
  `q_id` int(11) NOT NULL,
  `qr_name` varchar(255) NOT NULL,
  `qr_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_qr`
--

INSERT INTO `tbl_qr` (`q_id`, `qr_name`, `qr_path`) VALUES
(1, '', 'uploads/qr/67d3d05fab6b0_qrcode.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurant`
--

CREATE TABLE `tbl_restaurant` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` enum('owner') NOT NULL DEFAULT 'owner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_restaurant`
--

INSERT INTO `tbl_restaurant` (`id`, `username`, `password`, `role`) VALUES
(8, 'shiva_mijar920', 'shiva@@##$', 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurantname`
--

CREATE TABLE `tbl_restaurantname` (
  `r_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_restaurantname`
--

INSERT INTO `tbl_restaurantname` (`r_id`, `name`, `address`, `date`, `time`, `email`, `contact_number`) VALUES
(8, 'Shiva Mijar', 'damauli', '2025-03-27', '22:42:00', 'shivashiva@gmail.com', '9852311477');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_addfood`
--
ALTER TABLE `tbl_addfood`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_logo`
--
ALTER TABLE `tbl_logo`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `fk_orders_food` (`f_id`);

--
-- Indexes for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD PRIMARY KEY (`tbl_user_id`);

--
-- Indexes for table `tbl_qr`
--
ALTER TABLE `tbl_qr`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `tbl_restaurant`
--
ALTER TABLE `tbl_restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_restaurantname`
--
ALTER TABLE `tbl_restaurantname`
  ADD PRIMARY KEY (`r_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_addfood`
--
ALTER TABLE `tbl_addfood`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_logo`
--
ALTER TABLE `tbl_logo`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  MODIFY `tbl_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_qr`
--
ALTER TABLE `tbl_qr`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_restaurant`
--
ALTER TABLE `tbl_restaurant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_restaurantname`
--
ALTER TABLE `tbl_restaurantname`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `fk_orders_food` FOREIGN KEY (`f_id`) REFERENCES `tbl_addfood` (`f_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
