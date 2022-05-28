-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2022 at 10:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hyre`
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
  `aadhaar` bigint(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `userType` char(1) NOT NULL DEFAULT 'W',
  `ID` varchar(32) NOT NULL,
  `accountStatus` tinyint(4) NOT NULL DEFAULT 1,
  `reportCount` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`name`, `phoneNumber`, `gender`, `dOB`, `pincode`, `aadhaar`, `password`, `userType`, `ID`, `accountStatus`, `reportCount`) VALUES
('Naveen ', 1234567890, 'M', '2022-05-05', 100000, 1000000000000000, 'c44a471bd78cc6c2fea32b9fe028d30a', 'W', 'aa7372eaa327ee4372711da7f26f73c5', 1, 0),
('Rithvik', 1234567899, 'M', '2022-04-29', 100000, 1000000000000001, 'c44a471bd78cc6c2fea32b9fe028d30a', 'C', 'f56a9e630b931e993bc1ecdd3b0ba853', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` varchar(32) NOT NULL,
  `clientRating` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `clientRating`) VALUES
('f56a9e630b931e993bc1ecdd3b0ba853', 0);

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
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `jobID` int(11) NOT NULL,
  `clientID` varchar(32) NOT NULL,
  `workerID` varchar(32) NOT NULL,
  `landmark` varchar(50) NOT NULL,
  `pincode` mediumint(6) NOT NULL,
  `time` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `workType` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `bookingStatus` tinyint(4) NOT NULL DEFAULT 0,
  `jobStatus` tinyint(4) NOT NULL DEFAULT 0,
  `clientRating` float NOT NULL DEFAULT 0,
  `workerRating` float NOT NULL DEFAULT 0
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
  `job` varchar(30) NOT NULL,
  `workingHours` varchar(20) NOT NULL DEFAULT '9am to 6pm',
  `experience` tinyint(11) NOT NULL,
  `paymentDetails` varchar(100) NOT NULL,
  `photo` blob NOT NULL,
  `reputationCount` int(11) NOT NULL,
  `averageRating` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`workerID`, `job`, `workingHours`, `experience`, `paymentDetails`, `photo`, `reputationCount`, `averageRating`) VALUES
('aa7372eaa327ee4372711da7f26f73c5', '', '9am to 6pm', 0, '', '', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`jobID`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`workerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `jobID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;