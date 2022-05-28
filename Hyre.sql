-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2022 at 07:54 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Hyre`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `name` varchar(30) NOT NULL,
  `phoneNumber` bigint(10) NOT NULL,
  `gender` char(1) NOT NULL DEFAULT 'M',
  `dOB` date NOT NULL,
  `pincode` int(6) NOT NULL,
  `aadhar` bigint(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `userType` char(1) NOT NULL DEFAULT 'W',
  `ID` varchar(32) NOT NULL,
  `accountStatus` tinyint(4) NOT NULL DEFAULT 0,
  `reportCount` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `carpenter`
--

CREATE TABLE `carpenter` (
  `workerID` varchar(32) NOT NULL,
  `woodType` varchar(100) NOT NULL,
  `basicPay` int(11) NOT NULL,
  `costPerKG` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` varchar(32) NOT NULL,
  `clientRating` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `workerID` varchar(32) NOT NULL,
  `clientID` varchar(32) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cook`
--

CREATE TABLE `cook` (
  `workerID` varchar(32) NOT NULL,
  `costPerPlate` int(11) NOT NULL,
  `speciality` varchar(400) NOT NULL,
  `foodPreference` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `clientID` varchar(32) NOT NULL,
  `workerID` varchar(32) NOT NULL,
  `locationNumber` varchar(50) NOT NULL,
  `locationStreetname` varchar(50) NOT NULL,
  `locationPincode` mediumint(6) NOT NULL,
  `time` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `bookingStatus` tinyint(4) NOT NULL,
  `jobStatus` tinyint(4) NOT NULL,
  `clientRating` float NOT NULL,
  `workerRating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maid`
--

CREATE TABLE `maid` (
  `workerID` varchar(32) NOT NULL,
  `hourlyCharge` int(11) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `painter`
--

CREATE TABLE `painter` (
  `workerID` varchar(32) NOT NULL,
  `paintType` varchar(200) NOT NULL,
  `basicPay` float NOT NULL,
  `costPerSqft` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reporterID` varchar(32) NOT NULL,
  `reportedID` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `workerID` varchar(32) NOT NULL,
  `workingHours` varchar(15) NOT NULL,
  `experience` tinyint(11) NOT NULL,
  `photo` blob NOT NULL,
  `reputationCount` int(11) NOT NULL,
  `averageRating` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `carpenter`
--
ALTER TABLE `carpenter`
  ADD PRIMARY KEY (`workerID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `cook`
--
ALTER TABLE `cook`
  ADD PRIMARY KEY (`workerID`);

--
-- Indexes for table `maid`
--
ALTER TABLE `maid`
  ADD PRIMARY KEY (`workerID`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`workerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
