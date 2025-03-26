-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 04:39 PM
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
(10, 'Momo', 'So Delicious', 120.00, 'main-course', 'food.jpg', 'available');

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
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `tbl_user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logo`
--

CREATE TABLE `tbl_logo` (
  `u_id` int(11) NOT NULL,
  `logo_name` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_logo`
--

INSERT INTO `tbl_logo` (`u_id`, `logo_name`, `logo_path`) VALUES
(1, 'Screenshot 2025-03-20 061833.png', 'uploads/logo/67db95f57fb2b_Screenshot 2025-03-20 061833.png');

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
(1, NULL, 'Manisha Darai', '9845122366', 'spicy', 1, '08:19:00', 'cash', 'Confirmed', '2025-03-12 01:34:46', '2025-03-20 00:50:04', ''),
(4, NULL, 'pushpa', '9844905557', 'chilly less', 1, '17:33:00', 'cash', 'Confirmed', '2025-03-12 10:48:20', '2025-03-12 10:51:55', 'Your order #4 has been CONFIRMED!'),
(5, NULL, 'Manisha Darai', '9824199146', 'Hello', 3, '17:30:00', 'online', 'Confirmed', '2025-03-16 10:57:13', '2025-03-16 10:58:41', 'Your order #5 has been CONFIRMED!'),
(6, NULL, 'Ram Thapa', '9824133278', 'less sugar', 1, '09:02:00', 'cash', 'Confirmed', '2025-03-16 13:17:16', '2025-03-16 13:17:22', 'Your order has been confirmed!'),
(7, NULL, 'Ram Thapa', '9824133278', 'less sugar', 1, '09:02:00', 'cash', 'Cancelled', '2025-03-16 13:17:32', '2025-03-16 13:30:49', 'Your order has been cancelled!'),
(9, NULL, 'Basanti Silwal', '9824100179', 'spicy', 1, '09:00:00', 'online', 'Confirmed', '2025-03-16 13:30:38', '2025-03-16 13:30:59', 'Your order has been confirmed!'),
(15, NULL, 'Basanti Silwal', '9824100179', 'spicy', 1, '09:00:00', 'online', 'Cancelled', '2025-03-16 15:06:15', '2025-03-20 00:59:04', 'Your order has been cancelled!'),
(16, NULL, 'Basanti Silwal', '9824100179', 'spicy', 1, '09:00:00', 'online', 'Cancelled', '2025-03-16 15:11:49', '2025-03-20 00:59:06', 'Your order has been cancelled!'),
(17, NULL, 'Basanti Silwal', '9824100179', 'spicy', 1, '09:00:00', 'online', 'Cancelled', '2025-03-16 15:12:11', '2025-03-20 00:59:07', 'Your order has been cancelled!'),
(18, NULL, 'Basanti Silwal', '9824100179', 'spicy', 1, '09:00:00', 'online', 'Cancelled', '2025-03-16 15:12:29', '2025-03-20 00:59:09', 'Your order has been cancelled!'),
(19, NULL, 'Basanti Silwal', '9824100179', 'spicy', 1, '09:00:00', 'online', 'Cancelled', '2025-03-16 15:18:37', '2025-03-20 00:59:10', 'Your order has been cancelled!'),
(20, NULL, 'Manisha Darai', '9845622388', 'want less spicey pickles', 1, '07:00:00', 'cash', 'Confirmed', '2025-03-20 00:52:50', '2025-03-20 00:53:51', 'Your order has been confirmed!'),
(21, NULL, 'Manisha Thapa', '9844905557', 'less sugar', 1, '10:57:00', 'cash', 'Confirmed', '2025-03-24 05:12:51', '2025-03-24 05:13:50', ''),
(22, NULL, 'Manisha Thapa', '9844905557', 'njnkm,', 1, '19:58:00', 'cash', 'Confirmed', '2025-03-24 14:14:04', '2025-03-24 14:14:22', 'Your order has been confirmed!'),
(23, NULL, 'Manisha Thapa', '9844905557', 'mmmmmmm', 1, '09:12:00', 'cash', 'Confirmed', '2025-03-24 15:27:39', '2025-03-24 15:27:52', 'Your order has been confirmed!');

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
(20, 'Amisha', 'Sundas', 'Patan', '9824157576', 'ameesaa54@gmail.com', 'amisha', 'amisha', 344658, NULL, NULL, NULL, 'user', NULL, NULL),
(21, 'Manisha', 'Thapa', 'Damauli', '9844905557', 'puspathapamagar017@gmail.com', 'pushpa10', '123456', 225493, '67d7120cabbcc_WIN_20220909_10_00_21_Pro.jpg', NULL, NULL, 'user', NULL, NULL),
(22, 'kabin', 'Kc', 'Dumre', '9846133299', 'kckabin710@gmail.com', 'kabin', '12345', 820921, NULL, NULL, NULL, 'user', NULL, NULL),
(25, 'Ghan', 'Thapa', 'vyas  3 damauli', '9845633255', 'sinjali.gb@gmail.com', 'ghan thapa', '12', 601091, NULL, NULL, NULL, 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_owlogo`
--

CREATE TABLE `tbl_owlogo` (
  `o_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_owlogo`
--

INSERT INTO `tbl_owlogo` (`o_id`, `name`, `path`) VALUES
(1, 'Food Delivery Logo (1).png', 'uploads/logo/67d42fb505b23_Food Delivery Logo (1).png');

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
  `role` enum('owner') NOT NULL DEFAULT 'owner',
  `password_reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_restaurant`
--

INSERT INTO `tbl_restaurant` (`id`, `username`, `password`, `role`, `password_reset_token`, `token_expiry`) VALUES
(1, 'ram', 'ram', 'owner', NULL, NULL),
(2, 'aagya_adhikari855', 'QvOIs5Km', 'owner', NULL, NULL);

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
(2, 'Amisha Restro', 'vyas-5', '2024-10-30', '18:32:00', 'ameesaa22@gmail.com', '2147483647'),
(3, 'Amisha Restro', 'vyas-5', '2024-10-30', '18:32:00', 'ameesaa22@gmail.com', '2147483647'),
(5, 'Aagya Adhikari', 'Vyas-1', '2025-03-19', '10:14:00', 'aagyaadhikari@gmail.com', '9876544322');

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
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `f_id` (`f_id`),
  ADD KEY `tbl_user_id` (`tbl_user_id`);

--
-- Indexes for table `tbl_logo`
--
ALTER TABLE `tbl_logo`
  ADD PRIMARY KEY (`u_id`);

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
-- Indexes for table `tbl_owlogo`
--
ALTER TABLE `tbl_owlogo`
  ADD PRIMARY KEY (`o_id`);

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
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_logo`
--
ALTER TABLE `tbl_logo`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  MODIFY `tbl_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_owlogo`
--
ALTER TABLE `tbl_owlogo`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_qr`
--
ALTER TABLE `tbl_qr`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_restaurant`
--
ALTER TABLE `tbl_restaurant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_restaurantname`
--
ALTER TABLE `tbl_restaurantname`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `tbl_comments_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `tbl_addfood` (`f_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_comments_ibfk_2` FOREIGN KEY (`tbl_user_id`) REFERENCES `tbl_otp` (`tbl_user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `fk_orders_food` FOREIGN KEY (`f_id`) REFERENCES `tbl_addfood` (`f_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
