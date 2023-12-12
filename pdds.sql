-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 06:50 AM
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
-- Database: `pdds`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` varchar(50) NOT NULL,
  `categoryName` varchar(32) NOT NULL,
  `description` varchar(100) NOT NULL,
  `picture` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` varchar(50) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactTitle` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `postalCode` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeID` varchar(50) NOT NULL,
  `lastName` varchar(32) NOT NULL,
  `firstName` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `titleOfCourtesy` varchar(5) NOT NULL,
  `birthDate` varchar(10) NOT NULL,
  `hireDate` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `postalCode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `homePhone` varchar(100) NOT NULL,
  `extension` int(4) NOT NULL,
  `photo` varchar(225) NOT NULL,
  `notes` varchar(225) NOT NULL,
  `reportsTo` int(2) DEFAULT NULL,
  `photoPath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_territories`
--

CREATE TABLE `employee_territories` (
  `employeeID` varchar(50) NOT NULL,
  `territoryID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` varchar(50) NOT NULL,
  `customerID` varchar(50) NOT NULL,
  `employeeID` varchar(50) NOT NULL,
  `orderDate` varchar(50) NOT NULL,
  `requiredDate` varchar(50) NOT NULL,
  `shippedDate` varchar(50) NOT NULL,
  `shipVia` varchar(50) NOT NULL,
  `freight` varchar(50) NOT NULL,
  `shipName` varchar(50) NOT NULL,
  `shipAddress` varchar(50) NOT NULL,
  `shipCity` varchar(50) NOT NULL,
  `shipRegion` varchar(50) NOT NULL,
  `shipPostalCode` varchar(50) NOT NULL,
  `shipCountry` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `orderID` varchar(50) NOT NULL,
  `productID` varchar(50) NOT NULL,
  `unitPrice` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `discount` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` varchar(50) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `supplierID` varchar(50) NOT NULL,
  `categoryID` varchar(50) NOT NULL,
  `quantityPerUnit` varchar(50) NOT NULL,
  `unitPrice` varchar(50) NOT NULL,
  `unitsInStock` varchar(50) NOT NULL,
  `unitsOnOrder` varchar(50) NOT NULL,
  `reorderLevel` varchar(50) NOT NULL,
  `discontinued` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `regionID` varchar(50) NOT NULL,
  `regionDescription` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shippers`
--

CREATE TABLE `shippers` (
  `shipperID` varchar(50) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplierID` varchar(50) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactTitle` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `postalCode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `territories`
--

CREATE TABLE `territories` (
  `territoryID` varchar(50) NOT NULL,
  `territoryDescription` varchar(100) NOT NULL,
  `regionID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
