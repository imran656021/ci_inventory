-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2022 at 09:48 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` bigint(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `entry_date`) VALUES
(73, 'CatsEye', '2022-02-09 10:37:18'),
(75, 'Yeollow', '2022-02-09 11:11:55'),
(76, 'RichMan', '2022-02-09 11:12:14'),
(77, 'Lenevo', '2022-02-09 11:13:35'),
(84, 'DF3', '2022-02-14 16:53:59'),
(85, 'CF21', '2022-02-14 16:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `brand_id`, `model_id`, `name`, `entry_date`) VALUES
(4, 77, 7, 'Lenevo503', '2022-02-13 10:48:08'),
(5, 77, 7, 'lenevo504', '2022-02-13 10:52:13'),
(6, 75, 16, 'Yeollo501', '2022-02-13 11:06:18'),
(7, 73, 17, 'CatsEye512', '2022-02-13 11:24:38'),
(11, 76, 3, 'RichMan333', '2022-02-14 05:08:26'),
(13, 76, 10, 'RichMan3334', '2022-02-14 09:20:46'),
(16, 77, 7, 'Lenevo132', '2022-02-15 10:28:19'),
(17, 75, 16, 'YTTTTT11', '2022-02-15 10:31:07'),
(18, 77, 7, 'lolipop', '2022-06-01 21:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `brand_id`, `name`, `entry_date`) VALUES
(3, 76, 'RichMan111', '2022-02-13 05:15:29'),
(5, 75, 'Yeollo321', '2022-02-10 13:29:28'),
(7, 77, 'Lenevo21334', '2022-02-10 13:45:11'),
(10, 76, 'RichMan102', '2022-05-31 14:54:26'),
(16, 75, 'Yellow111', '2022-02-13 05:14:50'),
(17, 73, 'Cats101', '2022-02-14 06:47:21'),
(18, 73, 'Cats102', '2022-02-14 06:00:27'),
(19, 73, 'Cats103', '2022-02-14 09:18:27'),
(20, 82, 'BT365', '2022-02-14 09:34:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
