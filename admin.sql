-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2018 at 07:07 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `confirm` varchar(1000) NOT NULL,
  `tm_password` varchar(1000) NOT NULL,
  `username` varchar(1000) NOT NULL,
  `admin_cookie` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `confirm`, `tm_password`, `username`, `admin_cookie`) VALUES
(1, 'akpufranklin2@gmail.com', '$2y$10$sdRtmCLJkC/cdOwdiET8Kuz6F6YeX6ysZQcfaNQPw3kXULYShFw.q', '$2y$10$nH8cVuGC1AIAFypAiDgPqeUbd0P52r6qzy30LYmd76.nc.sVyfZBu', 'frank1520004807me', 'frank102', '5d57b6c4edd6816000837bba35226f2fdre45354e'),
(3, 'nnamdi@gmail.com', '$2y$10$LKwXWFJoFoMwpiaFodgl2ODC8t8wE1hFoMflYatcSb50iDMSyoWZe', '$2y$10$7nyHlSL380u2VgGNwP1H6OkgQ0mTTVHkO6v8SiPzatbJMo7n/XITu', 'fc6bd5a60bde69718c760c21a247bd7ajesusislord', 'nnamdi', '3d84e202fcbbc13200507084b11858cbdre45354e'),
(6, 'nnamdi101@gmail.com', '$2y$10$/noLSNKP/1ndL7DwiQ6VP.PMpMUtIFObWsycTJ5ExXt6aJNupIuri', '$2y$10$O/JxipRWQ2rH0P7d4tZyfuQ0ok/HldnglCAjmNeIcrmXCjC.eTDja', 'fc6bd5a60bde69718c760c21a247bd7ajesusislord', 'nnamdi', 'a0bd7cc0c9468b80947cf32dea83394edre45354e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
