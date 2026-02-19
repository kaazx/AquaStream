-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2026 at 03:33 PM
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
-- Database: `aquastream_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_db` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `user_db`, `created_at`) VALUES
(1, 'Sample', 'Owner', 'kazapanta@student.hau.edu.ph', '$2y$10$X2C2U3N2wY7HZtffJ4lTduXOdbk.aGNd1NatKtcItIhB7ggK2Ksim', 'aquastream_sampleowner_5dd9', '2026-02-17 12:42:26'),
(2, 'Owner', 'Admin', 'owner@gmail.com', '$2y$10$owWDyV2nvBkw./ythyO7I.5jZ7TE5I/9iPXBMnkC6tGV2txyK7Ony', 'aquastream_owneradmin_7909', '2026-02-18 15:56:25'),
(3, 'Kirsten', 'Zapanta', 'keithleenzapanta@gmail.com', '$2y$10$/ZMToD/xJkLbqYDLw5GUNu2GIbAotPe3S3FiJIpx//QzTua77AyhO', 'aquastream_kirstenzapanta_4763', '2026-02-19 12:27:07'),
(4, 'Sample', 'Admin', 'lagmankrizie@gmail.com', '$2y$10$FhcxkIt8R9ctAGA3xbVN9eRT6HKOKEo72JL/EIOhxuGPkOEvDnpT2', 'aquastream_sampleadmin_a430', '2026-02-19 13:56:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
