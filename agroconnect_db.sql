-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 07:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agroconnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer_table`
--

CREATE TABLE `buyer_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyer_table`
--

INSERT INTO `buyer_table` (`id`, `name`, `email`, `password`, `confirm_password`, `phone_number`, `user_type`) VALUES
(1, 'buyer buyer2', 'buyer@gmail.com', 'Buyer@12345', 'Buyer@12345', '0797867898', ''),
(4, 'cecil jones', 'cecil@gmail.com', 'Cecil@123', 'Cecil@123', '0798678523', 'Buyer'),
(5, 'William Kabore', 'kabore@gmail.com', 'Kabore@123', 'Kabore@123', '0789653556', 'Buyer'),
(6, 'Will Smith', 'willsmith@gmail.com', 'Willsmith@123', 'Willsmith@123', '0798765432', 'Buyer'),
(7, 'Pamela Obach', 'pam@gmail.com', 'Pamela@123', 'Pamela@123', '0798765478', 'Buyer');

-- --------------------------------------------------------

--
-- Table structure for table `buyer_tablenew`
--

CREATE TABLE `buyer_tablenew` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_type` enum('Buyer') NOT NULL,
  `identity_card` varchar(8) NOT NULL,
  `kra_pin` varchar(20) NOT NULL,
  `photo_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyer_tablenew`
--

INSERT INTO `buyer_tablenew` (`id`, `name`, `email`, `password`, `confirm_password`, `phone_number`, `user_type`, `identity_card`, `kra_pin`, `photo_path`) VALUES
(1, 'Maxwell Wayne', 'max@gmail.com', 'Maxwell@123', 'Maxwell@123', '0730678943', 'Buyer', '', '', ''),
(2, 'Paul Scholes', 'paul@gmail.com', 'Paul@123', 'Paul@123', '0798567945', 'Buyer', '65434343', 'A6583493', 'uploads/man2.jpg'),
(3, 'Kai Havertz', 'kai@gmail.com', 'Kai@123', 'Kai@123', '0789674532', 'Buyer', '98078944', 'A4321578', 'uploads/kai.jpg'),
(4, 'Adele Adele', 'adele@gmail.com', '$2y$10$S3cgydxZId1MT7yI4GIxKOZPTqzxfqGDwgUrQmB8XPHfBgSCGBNUO', 'Adele@123', '0777655678', 'Buyer', '54678998', 'A56783942', 'uploads/man6.jpg'),
(5, 'Samuel Johnson', 'samuel@gmail.com', 'Samuel@123', 'Samuel@123', '0799886677', 'Buyer', '54789398', 'A11223344', 'uploads/man7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Samuel Abudho', 'abudhosamuel@gmail.com', 'geew', '2023-12-21 16:28:55'),
(2, 'Samuel Abudho', 'abudhosamuel@gmail.com', 'go', '2023-12-21 16:34:17'),
(3, 'Samuel Abudho', 'abudhosamuel@gmail.com', 're', '2023-12-21 16:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `farmer_ratings`
--

CREATE TABLE `farmer_ratings` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `rating` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `farmer_table`
--

CREATE TABLE `farmer_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `farmer_table`
--

INSERT INTO `farmer_table` (`id`, `name`, `email`, `password`, `confirm_password`, `phone_number`, `user_type`) VALUES
(1, 'farmer farmer2', 'farmer@gmail.com', 'Farmer@12345', 'Farmer@12345', '0790876545', 'Farmer'),
(2, 'Mark Dom', 'markdom@1234', 'Mark@1234', 'Mark@1234', '0745678453', 'Farmer'),
(3, 'Gregory Orango', 'greg@gmail.com', 'Gregory@123', 'Gregory@123', '0798754542', 'Farmer'),
(4, 'Mohammed Yusuf', 'yusuf@gmail.com', 'Moha@12345', 'Moha@12345', '0789864243', 'Farmer'),
(5, 'Agnettah Atieno', 'agnettahatieno@gmail.com', 'Atieno@123', 'Atieno@123', '0798765345', 'Farmer'),
(6, 'Shakira Syevuo', 'syevuo@gmail.com', 'Syevuo@123', 'Syevuo@123', '0798416789', 'Farmer'),
(7, 'Doreen Mango', 'doreen@gmail.com', 'Doreen@123', 'Doreen@123', '0796654355', 'Farmer'),
(8, 'Samuel Abudho', 'abudhosamuel@gmail.com', 'Sammy@123', 'Sammy@123', '0792202480', 'Farmer'),
(10, 'Jane Bell', 'jane@gmail.com', 'Jane@123', 'Jane@123', '0789765432', 'Farmer'),
(13, 'Lydiah Masika', 'masika@gmail.com', 'Masika@123', 'Masika@123', '0798675372', 'Farmer');

-- --------------------------------------------------------

--
-- Table structure for table `farmer_tablenew`
--

CREATE TABLE `farmer_tablenew` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_type` enum('Farmer') NOT NULL,
  `identity_card` varchar(8) NOT NULL,
  `kra_pin` varchar(20) NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `driver_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `farmer_tablenew`
--

INSERT INTO `farmer_tablenew` (`id`, `name`, `email`, `password`, `confirm_password`, `phone_number`, `user_type`, `identity_card`, `kra_pin`, `photo_path`, `driver_name`) VALUES
(1, 'Gregory Orango', 'greg@gmail.com', 'Gregory@123', 'Gregory@123', '0792202490', 'Farmer', '', '', '', NULL),
(2, 'Okello Max', 'Okello@gmail.com', 'Okello@123', 'Okello@123', '0767890088', 'Farmer', '12345766', 'A456778', 'uploads/farmer1.jpg', 'Bonie'),
(3, 'Sam Smith', 'sam@gmail.com', 'Sam@123', 'Sam@123', '0790697856', 'Farmer', '45643217', 'A232455', 'uploads/seller1.jpg', 'Bob'),
(4, 'John Stones', 'stones@gmail.com', 'Stones@123', 'Stones@123', '0798654367', 'Farmer', '39899006', 'A2346578', 'uploads/man1.jpg', 'Mark'),
(5, 'Allan Namu', 'allan@gmail.com', '$2y$10$0LDQ2YJl.FL/GZY4Q0WBk.pduiIOecSDdw3bBwUpubUbdcZ.6bHQm', 'Allan@123', '0798563422', 'Farmer', '56789087', 'A3123243', 'uploads/man5.jpg', 'Dishan');

-- --------------------------------------------------------

--
-- Table structure for table `newusers`
--

CREATE TABLE `newusers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` enum('Farmer','Buyer') NOT NULL,
  `identity_card` char(8) NOT NULL,
  `kra_pin` varchar(20) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `new_orders`
--

CREATE TABLE `new_orders` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `farmer_email` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `total_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_orders`
--

INSERT INTO `new_orders` (`id`, `product_name`, `product_description`, `product_price`, `farmer_email`, `customer_name`, `status`, `feedback`, `quantity`, `total_cost`) VALUES
(1, 'pumpkins', 'ready pumpkins from the farm', '300.00', 'greg@gmail.com', 'cecil jones', 'approved', 'tomorrow', 1, NULL),
(2, 'pumpkins', 'ready pumpkins from the farm', '300.00', 'greg@gmail.com', 'cecil jones', 'pending', NULL, 1, NULL),
(3, 'pumpkins', 'ready pumpkins from the farm', '300.00', 'greg@gmail.com', 'cecil jones', 'pending', NULL, 1, NULL),
(4, 'Pixies', 'Sweet pixies straight from the farm.', '30.00', 'agnettahatieno@gmail.com', 'Will Smith', 'approved', 'Order received. You will be contacted soon', 1, NULL),
(5, 'Pixies', 'Sweet pixies straight from the farm.', '30.00', 'agnettahatieno@gmail.com', 'Will Smith', 'pending', NULL, 1, NULL),
(6, 'Guavas', 'Sweet succulent guavas', '50.00', 'syevuo@gmail.com', 'cecil jones', 'approved', 'Order received', 1, NULL),
(7, 'Guavas', 'Sweet succulent guavas', '50.00', 'syevuo@gmail.com', 'cecil jones', 'pending', NULL, 1, NULL),
(9, 'pawpaw', 'big tasty pawpaws', '200.00', 'greg@gmail.com', 'Pamela Obach', 'approved', 'Will be contacted shortly', 1, NULL),
(11, 'pumpkins', 'ready pumpkins from the farm', '300.00', 'greg@gmail.com', 'Pamela Obach', 'pending', NULL, 1, NULL),
(12, 'Viazi tamu', 'nice sweet potatoes', '160.00', 'realcash@solarunited.net', 'Pamela Obach', 'pending', NULL, 1, NULL),
(13, 'apples', 'Fresh apples from the farm', '30.00', 'greg@gmail.com', 'cecil jones', 'pending', NULL, 1, NULL),
(14, 'strawberry', 'Sweet strawberries from the farm', '50.00', 'doreen@gmail.com', 'cecil jones', 'approved', 'Will be delivered tomorrow.', 1, NULL),
(15, 'Kiwi', 'Fresh kiwis from the farm', '50.00', 'Okello@gmail.com', NULL, 'pending', NULL, 1, NULL),
(16, 'Watermelon', 'Tasty sweet watermelon', '344.94', 'langry@gmail.com', NULL, 'pending', NULL, 1, NULL),
(17, 'pawpaw', 'big tasty pawpaws', '200.00', 'greg@gmail.com', 'Paul Scholes', 'pending', NULL, 1, NULL),
(18, 'Kiwi', 'Fresh kiwis from the farm', '50.00', 'Okello@gmail.com', 'Paul Scholes', 'approved', 'Will be contacted tomorrow concerning the delivery', 1, NULL),
(19, 'Pixies', 'Sweet pixies straight from the farm.', '30.00', 'agnettahatieno@gmail.com', 'Paul Scholes', 'pending', NULL, 1, '30.00'),
(20, 'apples', 'Fresh apples from the farm', '30.00', 'greg@gmail.com', 'Paul Scholes', 'pending', NULL, 1, '30.00'),
(21, 'pawpaw', 'big tasty pawpaws', '200.00', 'greg@gmail.com', 'Paul Scholes', 'pending', NULL, 2, '400.00'),
(22, 'Kiwi', 'Fresh kiwis from the farm', '50.00', 'Okello@gmail.com', 'Paul Scholes', 'approved', 'Will be delivered tomorrow', 3, '150.00'),
(23, 'Plum', 'Sweet fresh red plums from the farm.', '30.00', 'sam@gmail.com', 'Kai Havertz', 'approved', 'Will be delivered soon', 2, '60.00'),
(24, 'grapes white', 'fresh grapes from farm', '30.00', 'stones@gmail.com', 'Paul Scholes', 'approved', 'Will be delivered tomorrow', 6, '180.00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `buyer_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 4, 'pending', '2024-01-30 12:17:58', '2024-01-30 12:17:58'),
(2, 6, 4, 'pending', '2024-01-30 13:00:10', '2024-01-30 13:00:10'),
(3, 6, 4, 'pending', '2024-01-30 13:03:29', '2024-01-30 13:03:29'),
(4, 6, 4, 'pending', '2024-01-30 13:08:23', '2024-01-30 13:08:23'),
(5, 6, 4, 'pending', '2024-01-30 13:11:07', '2024-01-30 13:11:07'),
(6, 6, 4, 'pending', '2024-01-30 13:11:07', '2024-01-30 13:11:07'),
(7, 6, 4, 'pending', '2024-01-30 13:16:38', '2024-01-30 13:16:38'),
(8, 6, 4, 'pending', '2024-01-30 13:16:38', '2024-01-30 13:16:38'),
(9, 6, 4, 'pending', '2024-01-30 13:17:41', '2024-01-30 13:17:41'),
(10, 6, 4, 'pending', '2024-01-30 13:17:41', '2024-01-30 13:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`) VALUES
(1, 'Tomatoes', 'Ripe round and red tomatoes', '30.00'),
(2, 'Pumpkin', 'Big yellow succulent pumpkins', '500.00'),
(3, 'Mangoes', 'Ripe mangoes from Machakos', '50.00'),
(4, 'Pineapples', 'Sweet Pineapples', '35.00'),
(5, 'blueberry', 'blueberries from machakos', '100.00'),
(6, 'blueberry', 'blueberries from macha', '100.00'),
(7, 'potatoes', 'clean potatoes', '150.00'),
(8, 'potatoes', 'clean potatoes', '150.00'),
(9, 'potatoes', 'clean potatoes', '150.00'),
(10, 'blueberry', 'ukkl', '345.00'),
(11, 'blueberry', 'ukkl', '345.00'),
(12, 'blueberry', 'ukkl', '345.00'),
(13, 'potatoes', 'fddfs', '456.00'),
(14, 'potatoes', 'fddfs', '456.00'),
(15, 'potatoes', 'frsd', '33.00'),
(16, 'potatoes', 'uyjg', '54.00'),
(17, 'potatoes', 'uyjg', '54.00');

-- --------------------------------------------------------

--
-- Table structure for table `productsnew`
--

CREATE TABLE `productsnew` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `farmer_email` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `farmer_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productsnew`
--

INSERT INTO `productsnew` (`id`, `product_name`, `product_description`, `product_price`, `farmer_email`, `image_path`, `created_at`, `farmer_name`) VALUES
(3, 'Viazi tamu', 'nice sweet potatoes', '160.00', 'realcash@solarunited.net', 'uploads/viazi.jpg', '2023-12-27 17:35:56', NULL),
(5, 'Watermelon', 'Tasty sweet watermelon', '344.94', 'langry@gmail.com', 'uploads/potatoes.jpg', '2024-01-13 12:12:30', NULL),
(6, 'pumpkins', 'ready pumpkins from the farm', '300.00', 'greg@gmail.com', 'uploads/pumpkins.jpg', '2024-01-24 13:23:36', 'Gregory Orango'),
(7, 'pawpaw', 'big tasty pawpaws', '200.00', 'greg@gmail.com', 'uploads/pawpaw.jpg', '2024-01-24 13:30:56', NULL),
(8, 'Pixies', 'Sweet pixies straight from the farm.', '30.00', 'agnettahatieno@gmail.com', 'uploads/pixies.jpg', '2024-03-18 11:25:19', NULL),
(9, 'Guavas', 'Sweet succulent guavas', '50.00', 'syevuo@gmail.com', 'uploads/guavas.jpg', '2024-03-18 11:37:06', NULL),
(10, 'apples', 'Fresh apples from the farm', '30.00', 'greg@gmail.com', 'uploads/apples1.jpg', '2024-03-19 13:35:27', NULL),
(11, 'strawberry', 'Sweet strawberries from the farm', '50.00', 'doreen@gmail.com', 'uploads/strawberries.jpg', '2024-03-19 17:07:23', NULL),
(12, 'Kiwi', 'Fresh kiwis from the farm', '50.00', 'Okello@gmail.com', 'uploads/kiwi.jpg', '2024-03-26 05:44:30', NULL),
(13, 'Plum', 'Sweet fresh red plums from the farm.', '30.00', 'sam@gmail.com', 'uploads/plums.jpg', '2024-04-02 07:17:00', NULL),
(14, 'grapes white', 'fresh grapes from farm', '30.00', 'stones@gmail.com', 'uploads/grapes.jpg', '2024-04-05 17:13:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ratings1`
--

CREATE TABLE `ratings1` (
  `rating_id` int(11) NOT NULL,
  `farmer_email` varchar(255) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('farmer','buyer','admin') NOT NULL DEFAULT 'buyer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Samuel Abudho', 'abudhosamuel@gmail.com', '123456', ''),
(2, 'Mary Akinyi', 'maryakinyi@gmail.com', '09876', ''),
(3, 'langry langry', 'langry@gmail.com', '12345', ''),
(4, 'Gabby Okumu', 'realcash@solarunited.net', '12345', 'farmer'),
(5, 'Doris Opanga', 'doris.opanga@gmail.com', '123456', 'buyer'),
(6, 'administrator', 'admin@gmail.com', 'admin@123', 'admin'),
(7, 'Johnson', 'john@gmail.com', '12345', 'farmer');

-- --------------------------------------------------------

--
-- Table structure for table `users3`
--

CREATE TABLE `users3` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users3`
--

INSERT INTO `users3` (`id`, `name`, `email`, `password`, `confirm_password`, `phone_number`, `user_type`) VALUES
(1, 'admin admin', 'admin@gmail.com', '12345', '12345', '0792202489', 'admin'),
(7, 'langry langry', 'langry@gmail.com', 'Langry@12345', 'Langry@12345', '0712345678', 'Farmer'),
(8, 'Doris Opanga', 'doris.opanga@gmail.com', 'Doris@1234', 'Doris@1234', '0798765432', 'Buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer_table`
--
ALTER TABLE `buyer_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_tablenew`
--
ALTER TABLE `buyer_tablenew`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farmer_ratings`
--
ALTER TABLE `farmer_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Indexes for table `farmer_table`
--
ALTER TABLE `farmer_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `farmer_tablenew`
--
ALTER TABLE `farmer_tablenew`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `newusers`
--
ALTER TABLE `newusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `new_orders`
--
ALTER TABLE `new_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `productsnew`
--
ALTER TABLE `productsnew`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `farmer_id` (`farmer_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `ratings1`
--
ALTER TABLE `ratings1`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `farmer_email` (`farmer_email`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users3`
--
ALTER TABLE `users3`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer_table`
--
ALTER TABLE `buyer_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buyer_tablenew`
--
ALTER TABLE `buyer_tablenew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `farmer_ratings`
--
ALTER TABLE `farmer_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmer_table`
--
ALTER TABLE `farmer_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `farmer_tablenew`
--
ALTER TABLE `farmer_tablenew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `newusers`
--
ALTER TABLE `newusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `new_orders`
--
ALTER TABLE `new_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `productsnew`
--
ALTER TABLE `productsnew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings1`
--
ALTER TABLE `ratings1`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users3`
--
ALTER TABLE `users3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farmer_ratings`
--
ALTER TABLE `farmer_ratings`
  ADD CONSTRAINT `farmer_ratings_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer_table` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `productsnew` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `buyer_table` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer_table` (`id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `buyer_table` (`id`);

--
-- Constraints for table `ratings1`
--
ALTER TABLE `ratings1`
  ADD CONSTRAINT `ratings1_ibfk_1` FOREIGN KEY (`farmer_email`) REFERENCES `farmer_table` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings1_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `buyer_table` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
