-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2023 at 12:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khanstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `is_active`) VALUES
(3, 'Rizwan', 'rizwan@gmail.com', '$2y$10$Z1DnKbJRDFUTHMI7y1vSqeU3.Y9cgDyC4AeWx4.ucH34z/mkzL2E.', '0'),
(4, 'ajay', 'ajay@gmail.com', '$2y$10$UGzx/ODNB4ZSFruRF8BN2eC/NNE.6MBhfTTYKtUo.k4ZVHZFD85DO', '0'),
(5, 'Rizwan', 'rizwankhan@gmail.com', '$2y$10$qZ0OoyX8bhAVxDFM/fx8leZSZwlyq15c1C/KTnaqDLSx6eCDJ0VpC', '0'),
(6, 'Faizan', 'faizan@gmail.com', '$2y$10$Ll2.sETLuB8sdhh1LRK4e.cQqn4CtTEudFg.exhf76D6rGzSOwWNm', '0'),
(7, 'Ajay Kumar', 'ajaykumar@gmail.com', '$2y$10$8GlkawEDsNrOQr8Vgv0GceD/MhVpHAXM4xqtMo0.SUaHFXe03MRdi', '0'),
(8, 'Admin', 'admin@gmail.com', '$2y$10$7k1cewD0TgEj3achZ7QpIOL1JOMYJMBBqjVduD4aoL9wLnC0oG7Vq', '0');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(100) NOT NULL,
  `brand_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'HP'),
(2, 'Samsung'),
(3, 'Apple'),
(4, 'Sony'),
(5, 'LG'),
(9, 'Nike'),
(10, 'HRX');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `ip_add` varchar(250) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(100) NOT NULL,
  `cat_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(2, 'Ladies Wearss'),
(3, 'Mens Wear'),
(4, 'Kids Wear'),
(5, 'Furnitures'),
(6, 'Home Appliances'),
(12, 'Mobiles'),
(13, 'Men Footwear'),
(14, 'Women Footwear'),
(19, 'Men Shoes'),
(20, 'Baby N Kids');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_addresses`
--

INSERT INTO `delivery_addresses` (`id`, `user_id`, `name`, `address`, `city`, `state`, `zip_code`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 3, 'Rizwan Khan', 'Rahmat Nagar Road No. 4, Ward No. 83, Burnpur', 'Asansol', 'West Bengal', '713325', '7001629243', '2023-05-27 05:41:36', '2023-05-27 05:41:36'),
(2, 1, 'Rizwan Khan', 'Rahmat Nagar Road No. 4, Ward No. 83, Burnpur', 'Asansol', 'West Bengal', '713325', '9876543210', '2023-06-14 05:26:20', '2023-06-14 05:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_order_amount` int(11) NOT NULL,
  `trx_id` varchar(255) DEFAULT NULL,
  `p_status` varchar(20) NOT NULL,
  `paymode` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_order_amount`, `trx_id`, `p_status`, `paymode`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '9L434522M7706801A', 'Completed', '', '2023-05-27 09:15:55', '0000-00-00 00:00:00'),
(2, 1, 0, '9L434522M7706801A', 'Completed', '', '2023-05-27 09:15:55', '0000-00-00 00:00:00'),
(3, 1, 0, '9L434522M7706801A', 'Completed', '', '2023-05-27 09:15:55', '0000-00-00 00:00:00'),
(4, 1, 0, '8AT7125245323433N', 'Completed', '', '2023-05-27 09:15:55', '0000-00-00 00:00:00'),
(23, 3, 0, NULL, 'pending', 'cod', '2023-05-27 06:40:10', '2023-05-27 06:40:10'),
(24, 3, 45000, NULL, 'pending', 'cod', '2023-05-27 06:41:40', '2023-05-27 06:41:40'),
(26, 3, 5000, NULL, 'pending', 'cod', '2023-05-27 07:02:22', '2023-05-27 07:02:22'),
(27, 3, 5000, NULL, 'pending', 'cod', '2023-05-27 07:03:53', '2023-05-27 07:03:53'),
(28, 3, 5000, NULL, 'pending', 'cod', '2023-05-27 07:05:22', '2023-05-27 07:05:22'),
(29, 3, 5000, NULL, 'pending', 'cod', '2023-05-27 07:07:32', '2023-05-27 07:07:32'),
(30, 3, 5000, NULL, 'pending', 'cod', '2023-05-27 07:13:22', '2023-05-27 07:13:22'),
(31, 3, 5000, NULL, 'pending', 'cod', '2023-05-27 07:13:51', '2023-05-27 07:13:51'),
(32, 3, 45000, NULL, 'pending', 'cod', '2023-05-27 07:14:41', '2023-05-27 07:14:41'),
(33, 3, 45000, NULL, 'pending', 'cod', '2023-05-28 13:13:27', '2023-05-28 13:13:27'),
(34, 3, 0, NULL, 'pending', 'cod', '2023-05-28 13:13:43', '2023-05-28 13:13:43'),
(35, 3, 15000, NULL, 'pending', 'cod', '2023-05-28 13:14:52', '2023-05-28 13:14:52'),
(36, 3, 80000, NULL, 'pending', 'cod', '2023-05-28 13:18:41', '2023-05-28 13:18:41'),
(37, 3, 40000, NULL, 'pending', 'cod', '2023-05-28 13:19:52', '2023-05-28 13:19:52'),
(38, 1, 40000, NULL, 'pending', 'cod', '2023-06-14 05:26:34', '2023-06-14 05:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `purchase_price` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `order_qty`, `purchase_price`, `created_at`, `updated_at`) VALUES
(1, 24, 4, 1, 5000, '2023-05-27 06:41:40', '2023-05-27 06:41:40'),
(2, 24, 2, 1, 40000, '2023-05-27 06:41:40', '2023-05-27 06:41:40'),
(4, 26, 4, 1, 5000, '2023-05-27 07:02:22', '2023-05-27 07:02:22'),
(5, 27, 4, 1, 5000, '2023-05-27 07:03:53', '2023-05-27 07:03:53'),
(6, 28, 4, 1, 5000, '2023-05-27 07:05:22', '2023-05-27 07:05:22'),
(7, 29, 4, 1, 5000, '2023-05-27 07:07:32', '2023-05-27 07:07:32'),
(8, 30, 4, 1, 5000, '2023-05-27 07:13:22', '2023-05-27 07:13:22'),
(9, 31, 4, 1, 5000, '2023-05-27 07:13:51', '2023-05-27 07:13:51'),
(10, 32, 2, 1, 40000, '2023-05-27 07:14:41', '2023-05-27 07:14:41'),
(11, 32, 4, 1, 5000, '2023-05-27 07:14:41', '2023-05-27 07:14:41'),
(12, 33, 4, 1, 5000, '2023-05-28 13:13:27', '2023-05-28 13:13:27'),
(13, 33, 2, 1, 40000, '2023-05-28 13:13:27', '2023-05-28 13:13:27'),
(14, 35, 4, 1, 5000, '2023-05-28 13:14:52', '2023-05-28 13:14:52'),
(15, 35, 1, 1, 10000, '2023-05-28 13:14:52', '2023-05-28 13:14:52'),
(16, 36, 2, 2, 40000, '2023-05-28 13:18:41', '2023-05-28 13:18:41'),
(17, 37, 2, 1, 40000, '2023-05-28 13:19:52', '2023-05-28 13:19:52'),
(18, 38, 2, 1, 40000, '2023-06-14 05:26:34', '2023-06-14 05:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_cat` int(11) NOT NULL,
  `product_brand` int(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` text NOT NULL,
  `product_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_cat`, `product_brand`, `product_title`, `product_price`, `product_qty`, `product_desc`, `product_image`, `product_keywords`) VALUES
(1, 12, 2, 'Samsung Galaxy S11', 10000, 50, 'Its a good phone', '1552670517_sumsung galaxy s8.png', 'samsung, mobile, galaxy'),
(2, 12, 3, 'Iphone 7 plus', 40000, 5000, 'Iphone is a good phone', '1686315990_apple-iphone-7-mn8x2hn-a-original-imafmqymth4z66v4.webp', 'apple, iphone, mobile'),
(4, 12, 2, 'Samsung Galaxy S6', 5000, 100, 'Samsung is a good phone', '1552670857_samsung galaxy s6.jpg', 'samsung, mobile, s6'),
(6, 12, 3, 'APPLE iPhone 13 (Midnight, 128 GB)', 70999, 100, '5G NR (Bands n1, n2, n3, n5, n7, n8, n12, n20, n25, n26, n28, n30, n38, n40, n41, n48, n53, n66, n70, n77, n78, n79), 4G FDD-LTE (B1, B2, B3, B4, B5, B7, B8, B12, B13, B17, B18, B19, B20, B25, B26, B28, B30, B32, B66), 4G TD-LTE (B34, B38, B39, B40, B41, B42, B46, B48, B53), 3G UMTS/HSPA+/DC-HSDPA (850, 900, 1700/2100, 1900, 2100 MHz), 2G GSM/EDGE (850, 900, 1800, 1900 MHz)', '1685881593_iphone-13.webp', 'apple, iphone, iphone 13');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `address1` varchar(300) DEFAULT NULL,
  `address2` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `name`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address1`, `address2`) VALUES
(1, NULL, 'Rizwan', 'Khan', 'rizwankhan.august16@gmail.com', '25f9e794323b453885f5181f1b624d0b', '8389080183', 'Rahmat Nagar Burnpur Asansol', 'Asansol'),
(2, NULL, 'Rizwan', 'Khan', 'rizwankhan.august16@yahoo.com', '25f9e794323b453885f5181f1b624d0b', '8389080183', 'Rahmat Nagar Burnpur Asansol', 'Asa'),
(3, 'Rizwan Khan', NULL, NULL, 'rizwankhan@gmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_meta_data`
--

CREATE TABLE `user_meta_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_used_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_meta_data`
--

INSERT INTO `user_meta_data` (`id`, `user_id`, `last_used_address_id`) VALUES
(2, 3, 1),
(3, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_cat` (`product_cat`),
  ADD KEY `fk_product_brand` (`product_brand`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_meta_data`
--
ALTER TABLE `user_meta_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_used_address_id` (`last_used_address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_meta_data`
--
ALTER TABLE `user_meta_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD CONSTRAINT `delivery_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`product_brand`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `fk_product_cat` FOREIGN KEY (`product_cat`) REFERENCES `categories` (`cat_id`);

--
-- Constraints for table `user_meta_data`
--
ALTER TABLE `user_meta_data`
  ADD CONSTRAINT `user_meta_data_ibfk_1` FOREIGN KEY (`last_used_address_id`) REFERENCES `delivery_addresses` (`id`),
  ADD CONSTRAINT `user_meta_data_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
