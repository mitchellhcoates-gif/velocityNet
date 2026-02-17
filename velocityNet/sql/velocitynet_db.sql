-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 12:06 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `velocitynet_db`
--
CREATE DATABASE IF NOT EXISTS `velocitynet_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `velocitynet_db`;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `product_service_id` int(11) NOT NULL,
  `complaint_type_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `technician_notes` text DEFAULT NULL,
  `resolution_date` varchar(25) DEFAULT NULL,
  `resolution_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `customer_id`, `employee_id`, `product_service_id`, `complaint_type_id`, `description`, `status`, `technician_notes`, `resolution_date`, `resolution_notes`, `created_at`) VALUES
(1, 1, NULL, 1, 1, 'Internet has been down since last night. Modem lights are on but there is no connection.', 'open', '', '', '', '2026-02-03 00:10:16'),
(2, 2, 1, 1, 2, 'Fiber speeds are way lower than expected. Multiple speed tests show around 120 Mbps.', 'open', 'Asked customer to test direct to modem and reboot router. Scheduling line test.', '', '', '2026-02-03 00:10:16'),
(3, 3, 2, 4, 5, 'WiFi router keeps disconnecting every 10 to 20 minutes. Reboot fixes it for a short time.', 'open', 'Checking firmware version. Might swap router if issue continues.', '', '', '2026-02-03 00:10:16'),
(4, 4, NULL, 2, 3, 'Service drops for a few minutes a couple times per day. Happens mostly in the evening.', 'open', '', '', '', '2026-02-03 00:10:16'),
(5, 5, 3, 3, 4, 'Charged twice for modem rental this month. Invoice shows duplicate line item.', 'open', 'Reviewed billing history. Escalating to billing team for credit.', '', '', '2026-02-03 00:10:16'),
(6, 1, 1, 5, 6, 'Installer did not finish setup. Connection works sometimes but drops and the line looks loose outside.', 'closed', 'Visited site and replaced connector. Retested signal levels.', '2026-02-01', 'Customer confirmed stable connection after repair.', '2026-02-03 00:10:16'),
(7, 2, NULL, 6, 4, 'Late fee applied even though payment was made on time. Bank statement shows it cleared.', 'open', '', '', '', '2026-02-03 00:10:16'),
(8, 3, 2, 1, 2, 'Speed is fine on Ethernet but WiFi is slow across the apartment.', 'open', 'Recommended moving router location and changing WiFi channel. Offered mesh option.', '', '', '2026-02-03 00:10:16'),
(9, 1, NULL, 6, 4, 'I was charged way too much', 'open', NULL, NULL, NULL, '2026-02-12 10:08:04'),
(10, 1, NULL, 1, 3, 'My internet no working', 'open', NULL, NULL, NULL, '2026-02-12 10:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_types`
--

DROP TABLE IF EXISTS `complaint_types`;
CREATE TABLE `complaint_types` (
  `complaint_type_id` int(11) NOT NULL,
  `complaint_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaint_types`
--

INSERT INTO `complaint_types` (`complaint_type_id`, `complaint_type_name`) VALUES
(1, 'No Internet Connection'),
(2, 'Slow Speeds'),
(3, 'Intermittent Service'),
(4, 'Billing Issue'),
(5, 'Equipment Problem'),
(6, 'Installation Problem');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `street_address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `customer_password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `email`, `first_name`, `last_name`, `street_address`, `city`, `state`, `zip_code`, `phone_number`, `customer_password`) VALUES
(1, 'peter.parker@email.com', 'Peter', 'Parker', '20 Ingram Street', 'Queens', 'NY', '11375', '555-0101', 'spiderman1'),
(2, 'steve.rogers@email.com', 'Steve', 'Rogers', '569 Leaman Place', 'Brooklyn', 'NY', '11201', '555-0102', 'captain1'),
(3, 'natasha.romanoff@email.com', 'Natasha', 'Romanoff', '15 Spyglass Lane', 'Washington', 'DC', '20001', '555-0103', 'blackwidow1'),
(4, 'wanda.maximoff@email.com', 'Wanda', 'Maximoff', '77 Westview Rd', 'Westview', 'NJ', '07001', '555-0104', 'scarlet1'),
(5, 'tchalla@email.com', 'T\'Challa', 'Wakanda', '1 Golden City Way', 'Oakland', 'CA', '94601', '555-0105', 'panther1');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `employee_password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_extension` varchar(10) DEFAULT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `user_id`, `employee_password`, `first_name`, `last_name`, `email`, `phone_extension`, `level`) VALUES
(1, 'tstark', 'velocity123', 'Tony', 'Stark', 'tony.stark@velocitynet.com', '201', 'technician'),
(2, 'bbanner', 'velocity123', 'Bruce', 'Banner', 'bruce.banner@velocitynet.com', '202', 'technician'),
(3, 'pparker', 'velocity123', 'Peter', 'Parker', 'peter.parker@velocitynet.com', '203', 'technician'),
(4, 'nfury', 'admin123', 'Nick', 'Fury', 'nick.fury@velocitynet.com', '101', 'administrator'),
(5, 'mhill', 'admin123', 'Maria', 'Hill', 'maria.hill@velocitynet.com', '102', 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `products_services`
--

DROP TABLE IF EXISTS `products_services`;
CREATE TABLE `products_services` (
  `product_service_id` int(11) NOT NULL,
  `product_service_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_services`
--

INSERT INTO `products_services` (`product_service_id`, `product_service_name`) VALUES
(1, 'Fiber Internet'),
(2, 'Cable Internet'),
(3, 'Modem Rental'),
(4, 'WiFi Router Rental'),
(5, 'Installation Service'),
(6, 'Billing Services');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `product_service_id` (`product_service_id`),
  ADD KEY `complaint_type_id` (`complaint_type_id`);

--
-- Indexes for table `complaint_types`
--
ALTER TABLE `complaint_types`
  ADD PRIMARY KEY (`complaint_type_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `products_services`
--
ALTER TABLE `products_services`
  ADD PRIMARY KEY (`product_service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `complaint_types`
--
ALTER TABLE `complaint_types`
  MODIFY `complaint_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products_services`
--
ALTER TABLE `products_services`
  MODIFY `product_service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `complaints_ibfk_3` FOREIGN KEY (`product_service_id`) REFERENCES `products_services` (`product_service_id`),
  ADD CONSTRAINT `complaints_ibfk_4` FOREIGN KEY (`complaint_type_id`) REFERENCES `complaint_types` (`complaint_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
