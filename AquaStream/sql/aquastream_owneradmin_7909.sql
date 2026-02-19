-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2026 at 03:39 PM
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
-- Database: `aquastream_owneradmin_7909`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_address`, `quantity`, `delivery_date`, `payment_method`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 'Krizie Lagman', 'Angeles City', 3, '2026-02-18', 'G-Cash', 'Pending', '2026-02-18 15:58:13', '2026-02-18 15:58:13'),
(2, 'Kirsten Zapanta', 'Angeles City', 5, '2026-02-18', 'Cash on Delivery', 'Pending', '2026-02-18 15:58:36', '2026-02-18 15:58:36'),
(3, 'Alexa Sanchez', 'Angeles City', 3, '2026-02-19', 'Card', 'Pending', '2026-02-18 15:59:01', '2026-02-18 15:59:01'),
(4, 'Leewel Tumang', 'Angeles City', 2, '2026-02-19', 'G-Cash', 'Pending', '2026-02-18 15:59:24', '2026-02-18 15:59:24'),
(5, 'JunJun Delacruz', 'Angeles City', 1, '2026-02-18', 'Cash on Delivery', 'Pending', '2026-02-18 15:59:52', '2026-02-18 15:59:52'),
(6, 'Marietes Santos', 'Angeles City', 4, '2026-02-19', 'G-Cash', 'Pending', '2026-02-18 16:00:10', '2026-02-18 16:00:10'),
(7, 'Boyet Sabado', 'Angeles City', 2, '2026-02-27', 'Card', 'Pending', '2026-02-18 16:00:34', '2026-02-18 16:00:34'),
(8, 'Princess Cya', 'Angeles City', 3, '2026-02-20', 'Cash on Delivery', 'Pending', '2026-02-18 16:00:50', '2026-02-18 16:00:50'),
(9, 'Sherryon Top', 'Angeles City', 1, '2026-02-19', 'G-Cash', 'Pending', '2026-02-18 16:01:17', '2026-02-18 16:01:17'),
(10, 'Babylon Co', 'Angeles City', 1, '2026-02-20', 'G-Cash', 'Pending', '2026-02-18 16:01:35', '2026-02-18 16:01:35'),
(11, 'Jolly Vee', 'Angeles City', 2, '2026-02-21', 'Cash on Delivery', 'Pending', '2026-02-18 16:01:58', '2026-02-18 16:01:58'),
(12, 'Kayeffs Cee', 'Angeles City', 4, '2026-02-21', 'Card', 'Pending', '2026-02-18 16:02:19', '2026-02-18 16:02:19'),
(13, 'Vurgiri King', 'Angeles City', 5, '2026-02-23', 'Cash on Delivery', 'Pending', '2026-02-18 16:02:37', '2026-02-18 16:02:37'),
(14, 'Leezie Tugman', 'Angeles City', 1, '2026-02-24', 'Cash', 'Pending', '2026-02-18 16:03:04', '2026-02-18 16:03:04'),
(15, 'Kirla Sanpantan', 'Angeles City', 1, '2026-02-25', 'Cash', 'Completed', '2026-02-18 16:03:30', '2026-02-18 16:13:44'),
(16, 'Krizie Lagman', 'Angeles City', 2, '2026-02-18', 'Card', 'Completed', '2026-02-18 16:11:30', '2026-02-18 16:13:28'),
(17, 'Leewel Tumang', 'Angeles City', 4, '2026-02-28', 'Cash on Delivery', 'Completed', '2026-02-18 16:11:59', '2026-02-18 16:13:37'),
(18, 'Anne Zapatan', 'Angeles City', 1, '2026-02-20', 'G-Cash', 'Completed', '2026-02-18 16:12:29', '2026-02-18 16:13:52'),
(19, 'Alexa Sanchez', 'Angeles City', 3, '2026-02-25', 'Card', 'Completed', '2026-02-18 16:12:51', '2026-02-18 16:14:01'),
(20, 'Sigma Rhein', 'Angeles City', 7, '2026-02-27', 'Cash', 'Completed', '2026-02-18 16:13:10', '2026-02-18 16:14:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
