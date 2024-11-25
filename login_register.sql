-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 11:07 AM
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
-- Database: `login_register`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Admin User', 'admin@example.com', 'admin@123'),
(2, 'Admin', 'admin@purple.com', '$2y$10$j9hZFRdjQafRXhyenWeeHuVIif5OPFOxkhZ7pytWjq0TTTYw.Rpny');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `address`, `total_price`, `order_date`) VALUES
(1, 'Neetesh Jain', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:24:33'),
(4, 'Neetesh Jain', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:33:34'),
(5, 'Neetesh Jain', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:36:07'),
(6, 'Neetesh', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:36:28'),
(7, 'Neetesh', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:39:59'),
(8, 'Neetesh', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:42:17'),
(10, 'k,mjnhbgfvdcsx', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:43:41'),
(11, 'k,mjnhbgfvdcsx', 'jainniteshreh@gmail.com', '08827455232', 'Makronia', 0.00, '2024-11-25 09:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(2, 'Apple', 25.00, '1732528736_apples-101-about-1440x810.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Aktar', 'aktar@gmail.com', '$2y$10$Jmf9Xk2y8m.fo3c/ZgKmzOrdIRkU05KSGLI0picKLEtr68ll7hjB.'),
(2, 'Neetesh', 'jainniteshreh@gmail.com', '$2y$10$O6npRhviIomDmWeQrStOGeVZLyft9oG14ihqufV654no2rNV7PE9q'),
(3, 'vijay', 'gc3nqlg4or@qejjyl.com', '$2y$10$4iPPXs.LbCzrgVAjsahQw.SwHK39anrxhSePsyroFhrQikstZ44gy'),
(4, 'raj', 'gc3nqlg4or@qejjyl.com', '$2y$10$M1xZHeG/7/h2ms2hCjNKOexC6EzpbeqAF3XrrWwIlRT9yLPkWbwn.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
