-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 07:02 PM
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
-- Database: `aquastream_pixiebike_e4df`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `CustomerAddress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerName`, `CustomerAddress`) VALUES
(1, 'Krizie Lagman', 'Angeles City'),
(2, 'Alexa Sanchez', 'Porac'),
(3, 'Leewel Tumang', 'Touching Bird'),
(4, 'Leewel Tumang', 'SapangRock'),
(5, 'Raquel', 'Angeles'),
(6, 'Chris', 'HAU'),
(7, 'Sherly', 'HAU'),
(8, 'Tom Oro', 'LH Building'),
(9, 'Analiza', 'Porac'),
(10, 'Innah Pineda', 'Angeles City');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL CHECK (`Quantity` > 0),
  `UnitPrice` decimal(10,2) NOT NULL,
  `TotalAmount` decimal(10,2) GENERATED ALWAYS AS (`Quantity` * `UnitPrice`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetailID`, `OrderID`, `CustomerID`, `ProductID`, `Quantity`, `UnitPrice`) VALUES
(1, 1, 1, 1, 3, 25.00),
(3, 3, 4, 1, 5, 25.00),
(6, 6, 2, 1, 2, 25.00),
(7, 7, 5, 1, 3, 25.00),
(8, 8, 6, 1, 5, 25.00),
(9, 9, 7, 1, 7, 25.00),
(10, 10, 8, 1, 2, 25.00),
(11, 11, 9, 1, 5, 25.00),
(12, 12, 10, 1, 2, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `ordersummary`
--

CREATE TABLE `ordersummary` (
  `OrderID` int(11) NOT NULL,
  `OrderDate` date NOT NULL DEFAULT curdate(),
  `DeliveryDate` date DEFAULT NULL,
  `ModeOfPayment` varchar(20) NOT NULL,
  `OrderStatus` varchar(20) NOT NULL DEFAULT 'Pending',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordersummary`
--

INSERT INTO `ordersummary` (`OrderID`, `OrderDate`, `DeliveryDate`, `ModeOfPayment`, `OrderStatus`, `TotalAmount`, `UpdatedAt`) VALUES
(1, '2026-03-20', '2026-03-20', 'Card', 'Completed', 75.00, '2026-03-20 05:25:54'),
(3, '2026-03-20', '2026-03-23', 'Cash on Delivery', 'Completed', 125.00, '2026-03-20 06:58:14'),
(6, '2026-03-20', '2026-03-24', 'G-Cash', 'Completed', 50.00, '2026-03-20 06:59:49'),
(7, '2026-03-20', '2026-03-20', 'Card', 'Completed', 75.00, '2026-03-20 07:24:03'),
(8, '2026-03-20', '2026-03-20', 'Cash', 'Completed', 125.00, '2026-03-20 07:25:17'),
(9, '2026-03-20', '2026-03-21', 'Cash', 'Completed', 175.00, '2026-03-20 07:36:30'),
(10, '2026-03-20', '2026-03-20', 'Cash', 'Completed', 50.00, '2026-03-20 16:56:58'),
(11, '2026-03-21', '2026-03-21', 'Cash', 'Completed', 125.00, '2026-03-20 17:18:27'),
(12, '2026-03-21', '2026-03-23', 'G-Cash', 'Pending', 50.00, '2026-03-20 17:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL CHECK (`UnitPrice` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `UnitPrice`) VALUES
(1, 'Gallon of Water', 25.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `ordersummary`
--
ALTER TABLE `ordersummary`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ordersummary`
--
ALTER TABLE `ordersummary`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `ordersummary` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `orderdetails_ibfk_3` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
