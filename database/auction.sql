-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2021 at 01:02 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `bought`
--

CREATE TABLE `bought` (
  `buyid` int(255) NOT NULL,
  `tippingauction_auctiontip_id` int(255) NOT NULL,
  `userid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `saleId` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `startPrice` int(11) NOT NULL,
  `methodOfPayment` varchar(255) DEFAULT NULL,
  `wayOfDelivery` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL DEFAULT '2021-01-01',
  `end_date` date NOT NULL DEFAULT '2021-01-01',
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`saleId`, `name`, `description`, `startPrice`, `methodOfPayment`, `wayOfDelivery`, `image`, `start_date`, `end_date`, `userId`) VALUES
(1, 'City Events', 'tst', 250, 'Credit Card', 'Personal Acquirement', 'assets/uploads/0.jpg', '2021-01-01', '2021-01-01', 1),
(2, 'City Events', 'stst', 250, 'Credit Card', 'Personal Acquirement', 'assets/uploads/0.jpg', '2021-01-01', '2021-01-01', 2),
(3, 'Kamion', 'traktor', 8900000, 'Credit Card', 'Personal Acquirement', 'assets/uploads/0.jpg', '2021-01-01', '2021-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tippingauction`
--

CREATE TABLE `tippingauction` (
  `auctiontip_id` int(255) NOT NULL,
  `sell_saleid` int(255) NOT NULL,
  `userid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`) VALUES
(1, 'Vasilije', 'Tomovic', 'sad@gmail.com', '$2y$10$mCjLWBknbCl8PM7NiBThdO6evdw/rJa9BmsvSOJy48t3deNvxOPnW'),
(2, 'marko', 'polo', 'marko@gmail.com', '$2y$10$7txsH4pu.Fmjap9KYZmmUeL.nKKhE/KL5rUZO6/ccrn3biukiO9J.'),
(35, 'Ilija', 'Kovacevic', 'iko@gmail.com', '$2y$10$OFY6Cbe6SlSke/21RBFXnOtJ6hP8Xf8VeLjZlGWE6bOtJ2ESpKh3G');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bought`
--
ALTER TABLE `bought`
  ADD PRIMARY KEY (`buyid`),
  ADD KEY `tippingauction_auctiontip_id` (`tippingauction_auctiontip_id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`saleId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tippingauction`
--
ALTER TABLE `tippingauction`
  ADD PRIMARY KEY (`auctiontip_id`),
  ADD KEY `sell_saleid` (`sell_saleid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bought`
--
ALTER TABLE `bought`
  MODIFY `buyid` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `saleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tippingauction`
--
ALTER TABLE `tippingauction`
  MODIFY `auctiontip_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bought`
--
ALTER TABLE `bought`
  ADD CONSTRAINT `bought_ibfk_1` FOREIGN KEY (`tippingauction_auctiontip_id`) REFERENCES `tippingauction` (`auctiontip_id`),
  ADD CONSTRAINT `bought_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `sell`
--
ALTER TABLE `sell`
  ADD CONSTRAINT `sell_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `tippingauction`
--
ALTER TABLE `tippingauction`
  ADD CONSTRAINT `tippingauction_ibfk_1` FOREIGN KEY (`sell_saleid`) REFERENCES `sell` (`saleId`),
  ADD CONSTRAINT `tippingauction_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
