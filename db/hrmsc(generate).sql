-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2021 at 08:28 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrmsc`
--

CREATE DATABASE 'hrmsc';

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminId` tinyint(4) NOT NULL,
  `adminEmail` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `adminLevel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `adminEmail`, `pwd`, `adminLevel`) VALUES
(1, 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1);

-- --------------------------------------------------------

--
-- Table structure for table `allowance`
--

CREATE TABLE `allowance` (
  `allowanceId` int(11) NOT NULL,
  `recruitmentId` int(11) DEFAULT NULL,
  `allowanceTypeId` tinyint(4) DEFAULT NULL,
  `allowanceAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allowance`
--

INSERT INTO `allowance` (`allowanceId`, `recruitmentId`, `allowanceTypeId`, `allowanceAmount`) VALUES
(1, 1, 1, '100.00'),
(2, 1, 2, '200.00'),
(4, 2, 1, '50.00'),
(5, 2, 2, '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `allowance_type`
--

CREATE TABLE `allowance_type` (
  `allowanceTypeId` tinyint(4) NOT NULL,
  `allowanceName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allowance_type`
--

INSERT INTO `allowance_type` (`allowanceTypeId`, `allowanceName`) VALUES
(1, 'Transportation'),
(2, 'Medical'),
(3, 'Phone');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceId` int(11) NOT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `attendanceDate` date NOT NULL,
  `punchInDateTime` datetime DEFAULT NULL,
  `punchOutDateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceId`, `employeeId`, `attendanceDate`, `punchInDateTime`, `punchOutDateTime`) VALUES
(2, 1, '2021-09-05', '2021-09-05 16:15:29', '2021-09-05 16:18:35'),
(3, 1, '2021-08-01', '2021-08-01 09:00:00', '2021-08-01 17:00:00'),
(4, 1, '2021-08-07', '2021-08-07 09:00:00', '2021-08-07 17:00:00'),
(5, 1, '2021-08-08', '2021-08-08 09:00:00', '2021-08-08 17:00:00'),
(6, 1, '2021-08-14', '2021-08-14 09:00:00', '2021-08-14 18:00:00'),
(8, 1, '2021-08-21', '2021-08-21 09:00:00', '2021-08-21 17:00:00'),
(9, 1, '2021-08-22', '2021-08-22 09:00:00', '2021-08-22 17:00:00'),
(10, 1, '2021-08-28', '2021-08-28 09:00:00', '2021-08-28 17:00:00'),
(11, 1, '2021-08-29', '2021-08-29 09:00:00', '2021-08-29 17:00:00'),
(12, 1, '2021-08-20', '2021-08-20 12:00:00', '2021-08-20 17:00:00'),
(13, 1, '2021-08-18', '2021-08-18 09:00:00', '2021-08-18 19:00:00'),
(14, 1, '2021-08-31', '2021-08-31 09:00:00', '2021-08-31 13:00:00'),
(15, 1, '2021-09-08', '2021-09-08 18:45:44', '2021-09-08 18:51:52'),
(16, 2, '2021-09-08', '2021-09-08 19:21:09', '2021-09-08 19:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `claim_request`
--

CREATE TABLE `claim_request` (
  `claimId` int(11) NOT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `claimTypeId` tinyint(4) DEFAULT NULL,
  `claimDetail` varchar(255) DEFAULT NULL,
  `claimAmount` decimal(10,2) NOT NULL,
  `claimFileName` varchar(255) NOT NULL,
  `applyClaimDateTime` datetime NOT NULL,
  `approveClaimDateTime` datetime DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `claimStatus` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `claim_request`
--

INSERT INTO `claim_request` (`claimId`, `employeeId`, `claimTypeId`, `claimDetail`, `claimAmount`, `claimFileName`, `applyClaimDateTime`, `approveClaimDateTime`, `comment`, `claimStatus`) VALUES
(2, 1, 1, 'Sign delivery', '26.00', 'db.jpg', '2021-09-05 18:07:53', NULL, 'noted.', 6),
(3, 1, 2, '', '30.00', 'bbg.png', '2021-09-05 18:12:15', NULL, NULL, 3),
(4, 2, 2, '', '30.00', 'receipt.jpg', '2021-09-08 19:00:56', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `claim_type`
--

CREATE TABLE `claim_type` (
  `claimTypeId` tinyint(4) NOT NULL,
  `claimName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `claim_type`
--

INSERT INTO `claim_type` (`claimTypeId`, `claimName`) VALUES
(1, 'Other'),
(2, 'Transportation');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeId` int(11) NOT NULL,
  `employeeName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(16) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `address3` varchar(255) DEFAULT NULL,
  `stateTypeId` tinyint(4) DEFAULT NULL,
  `postcode` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `epfAcc` varchar(255) DEFAULT NULL,
  `socsoAcc` varchar(255) DEFAULT NULL,
  `eisAcc` varchar(255) DEFAULT NULL,
  `startWorkDate` date DEFAULT NULL,
  `endWorkDate` date DEFAULT NULL,
  `recruitmentId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeId`, `employeeName`, `email`, `pwd`, `phone`, `birthday`, `gender`, `address1`, `address2`, `address3`, `stateTypeId`, `postcode`, `city`, `epfAcc`, `socsoAcc`, `eisAcc`, `startWorkDate`, `endWorkDate`, `recruitmentId`) VALUES
(1, 'Jeff Kai Yi Fu', 'jeff@gmail.com', '6367c48dd193d56ea7b0baad25b19455e529f5ee', '0165201314', '1987-08-17', 'Male', 'No 12', 'Jalan Sangat 34', 'Taman Besar 5', 1, 81500, 'Johor Bahru', 'MAJBO73990481748461938', 'J3718497301P', 'K3718492038F', '2019-07-01', '0000-00-00', 1),
(2, 'Angel Beh Ta Han', 'angel@hotmail.com', '6367c48dd193d56ea7b0baad25b19455e529f5ee', '01683917482', '1998-12-31', 'Female', 'No 23', 'Jalan Bestari 3/4', 'Taman Bestari 2', 1, 81200, 'Johor Bahru', 'JIFMN56394619F', 'N738433718C', 'H389091840E', '2020-06-01', '0000-00-00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holidayId` int(11) NOT NULL,
  `holidayName` varchar(255) NOT NULL,
  `holidayDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holidayId`, `holidayName`, `holidayDate`) VALUES
(1, 'Christmas Day', '2021-12-25'),
(2, 'Malaysia Independence Day', '2021-09-16'),
(3, 'Prophet Birthday', '2021-10-19'),
(4, 'Malaysia Day', '2021-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `leave_item`
--

CREATE TABLE `leave_item` (
  `leaveItemId` int(11) NOT NULL,
  `leaveTypeId` tinyint(4) DEFAULT NULL,
  `minWorkedYear` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  `leaveItemStartFrom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_item`
--

INSERT INTO `leave_item` (`leaveItemId`, `leaveTypeId`, `minWorkedYear`, `day`, `leaveItemStartFrom`) VALUES
(1, 1, 5, 22, '1955-01-01'),
(2, 1, 2, 18, '1995-01-01'),
(3, 1, 0, 8, '1995-01-01'),
(4, 2, 5, 16, '1955-01-01'),
(5, 2, 2, 12, '1955-01-01'),
(6, 2, 0, 8, '1955-01-01'),
(7, 3, 0, 60, '1995-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `leave_request`
--

CREATE TABLE `leave_request` (
  `leaveId` int(11) NOT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `leaveTypeId` tinyint(4) DEFAULT NULL,
  `leaveDetail` varchar(255) DEFAULT NULL,
  `startLeaveDateTime` datetime DEFAULT NULL,
  `endLeaveDateTime` datetime DEFAULT NULL,
  `leaveFileName` varchar(255) DEFAULT NULL,
  `applyLeaveDateTime` datetime NOT NULL,
  `approveLeaveDateTime` datetime DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `leaveStatus` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_request`
--

INSERT INTO `leave_request` (`leaveId`, `employeeId`, `leaveTypeId`, `leaveDetail`, `startLeaveDateTime`, `endLeaveDateTime`, `leaveFileName`, `applyLeaveDateTime`, `approveLeaveDateTime`, `comment`, `leaveStatus`) VALUES
(1, 1, 1, 'fever', '2021-09-04 00:00:00', '2021-09-04 23:59:00', 'mc.png', '2021-09-05 10:08:54', '2021-09-05 10:08:54', 'drink coconut water more more da~', 1),
(11, 1, 1, '', '2021-09-21 09:00:00', '2021-09-21 17:00:00', 'bbg.png', '2021-09-05 14:02:41', NULL, '', 3),
(13, 2, 1, 'period', '2021-08-01 00:00:00', '2021-08-01 23:59:00', NULL, '2021-09-08 18:57:48', NULL, NULL, 3),
(14, 2, 1, 'period', '2021-08-02 00:00:00', '2021-08-02 23:59:00', NULL, '2021-09-08 18:58:56', '2021-09-08 18:58:56', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `leaveTypeId` tinyint(4) NOT NULL,
  `leaveName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`leaveTypeId`, `leaveName`) VALUES
(1, 'Sick'),
(2, 'Annual'),
(3, 'Matternity'),
(4, 'Personal');

-- --------------------------------------------------------

--
-- Table structure for table `overtime_day_type`
--

CREATE TABLE `overtime_day_type` (
  `dayTypeId` tinyint(4) NOT NULL,
  `dayTypeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `overtime_day_type`
--

INSERT INTO `overtime_day_type` (`dayTypeId`, `dayTypeName`) VALUES
(1, 'Normal Day'),
(2, 'Rest Day'),
(3, 'Public Holiday Day');

-- --------------------------------------------------------

--
-- Table structure for table `overtime_payrate`
--

CREATE TABLE `overtime_payrate` (
  `overtimePayrateId` int(11) NOT NULL,
  `dayTypeId` tinyint(4) DEFAULT NULL,
  `minWorkedHour` decimal(10,2) DEFAULT NULL,
  `payrate` decimal(5,2) DEFAULT NULL,
  `overtimePayrateStartFrom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `overtime_payrate`
--

INSERT INTO `overtime_payrate` (`overtimePayrateId`, `dayTypeId`, `minWorkedHour`, `payrate`, `overtimePayrateStartFrom`) VALUES
(1, 1, '8.00', '1.50', '1955-01-01'),
(2, 1, '0.00', '1.00', '1955-01-01'),
(5, 2, '8.00', '2.00', '1955-01-01'),
(6, 2, '4.00', '1.00', '1955-01-01'),
(7, 2, '0.00', '0.50', '1955-01-01'),
(8, 3, '8.00', '3.00', '1955-01-01'),
(9, 3, '0.00', '2.00', '1955-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `payrollId` int(11) NOT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `month` tinyint(4) NOT NULL,
  `year` int(11) NOT NULL,
  `cheque` varchar(255) DEFAULT NULL,
  `basicPay` decimal(10,2) DEFAULT NULL,
  `deduction` decimal(10,2) DEFAULT NULL,
  `netPay` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`payrollId`, `employeeId`, `month`, `year`, `cheque`, `basicPay`, `deduction`, `netPay`) VALUES
(1, 1, 7, 2021, NULL, '1800.00', '1540.15', '259.85'),
(2, 2, 7, 2021, NULL, '3150.00', '3030.83', '119.17');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_item`
--

CREATE TABLE `payroll_item` (
  `payrollItemId` int(11) NOT NULL,
  `payrollItemTypeId` tinyint(4) DEFAULT NULL,
  `minSalary` int(11) DEFAULT NULL,
  `minAge` tinyint(4) DEFAULT NULL,
  `percentEmployee` decimal(10,4) DEFAULT NULL,
  `percentEmployer` decimal(10,4) DEFAULT NULL,
  `payrollItemStartFrom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll_item`
--

INSERT INTO `payroll_item` (`payrollItemId`, `payrollItemTypeId`, `minSalary`, `minAge`, `percentEmployee`, `percentEmployer`, `payrollItemStartFrom`) VALUES
(1, 1, 0, 0, '0.1100', '0.1300', '1955-01-01'),
(2, 2, 0, 60, '0.0125', '0.0000', '1955-01-01'),
(3, 2, 0, 0, '0.0175', '0.0050', '1955-01-01'),
(4, 3, 4000, 0, '7.9000', '7.9000', '1955-01-01'),
(5, 3, 3000, 0, '5.9000', '5.9000', '1955-01-01'),
(6, 3, 2000, 0, '3.9000', '3.9000', '1955-01-01'),
(7, 3, 1000, 0, '1.9000', '1.9000', '1955-01-01'),
(8, 3, 0, 0, '0.0000', '0.0000', '1955-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_item_type`
--

CREATE TABLE `payroll_item_type` (
  `payrollItemTypeId` tinyint(4) NOT NULL,
  `payrollItemTypeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll_item_type`
--

INSERT INTO `payroll_item_type` (`payrollItemTypeId`, `payrollItemTypeName`) VALUES
(1, 'EPF'),
(2, 'SOCSO'),
(3, 'EIS');

-- --------------------------------------------------------

--
-- Table structure for table `recruitment`
--

CREATE TABLE `recruitment` (
  `recruitmentId` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `positionDetail` varchar(255) DEFAULT NULL,
  `requirement` varchar(255) DEFAULT NULL,
  `salary` int(11) NOT NULL,
  `peopleLimit` int(11) NOT NULL,
  `workDay` int(11) NOT NULL,
  `startJobTime` time NOT NULL,
  `endJobTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recruitment`
--

INSERT INTO `recruitment` (`recruitmentId`, `position`, `positionDetail`, `requirement`, `salary`, `peopleLimit`, `workDay`, `startJobTime`, `endJobTime`) VALUES
(1, 'PA Manager', 'Manage PA System', 'at least 1 year work experience', 1500, 2, 67, '09:00:00', '17:00:00'),
(2, 'Pastor', 'do pastor job', 'at least degree level', 3000, 1, 567, '09:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `state_type`
--

CREATE TABLE `state_type` (
  `stateTypeId` tinyint(4) NOT NULL,
  `stateName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state_type`
--

INSERT INTO `state_type` (`stateTypeId`, `stateName`) VALUES
(1, 'Johor'),
(2, 'Kedah'),
(3, 'Kelantan'),
(4, 'Malacca'),
(5, 'Negeri Sembilan'),
(6, 'Pahang'),
(7, 'Penang'),
(8, 'Perak'),
(9, 'Perlis'),
(10, 'Sabah'),
(11, 'Sarawak'),
(12, 'Selangor'),
(13, 'Terengganu');

-- --------------------------------------------------------

--
-- Table structure for table `status_type`
--

CREATE TABLE `status_type` (
  `statusTypeId` tinyint(4) NOT NULL,
  `statusName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_type`
--

INSERT INTO `status_type` (`statusTypeId`, `statusName`) VALUES
(1, 'Approved'),
(2, 'Rejected'),
(3, 'Pending'),
(4, 'Cancelled'),
(5, 'Prepared'),
(6, 'Taken');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `allowance`
--
ALTER TABLE `allowance`
  ADD PRIMARY KEY (`allowanceId`),
  ADD KEY `recruitmentId` (`recruitmentId`),
  ADD KEY `allowanceTypeId` (`allowanceTypeId`);

--
-- Indexes for table `allowance_type`
--
ALTER TABLE `allowance_type`
  ADD PRIMARY KEY (`allowanceTypeId`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `claim_request`
--
ALTER TABLE `claim_request`
  ADD PRIMARY KEY (`claimId`),
  ADD KEY `employeeId` (`employeeId`),
  ADD KEY `claimTypeId` (`claimTypeId`),
  ADD KEY `claimStatus` (`claimStatus`);

--
-- Indexes for table `claim_type`
--
ALTER TABLE `claim_type`
  ADD PRIMARY KEY (`claimTypeId`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeId`),
  ADD KEY `stateTypeId` (`stateTypeId`),
  ADD KEY `recruitmentId` (`recruitmentId`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holidayId`);

--
-- Indexes for table `leave_item`
--
ALTER TABLE `leave_item`
  ADD PRIMARY KEY (`leaveItemId`),
  ADD KEY `leaveTypeId` (`leaveTypeId`);

--
-- Indexes for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`leaveId`),
  ADD KEY `employeeId` (`employeeId`),
  ADD KEY `leaveTypeId` (`leaveTypeId`),
  ADD KEY `leaveStatus` (`leaveStatus`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`leaveTypeId`);

--
-- Indexes for table `overtime_day_type`
--
ALTER TABLE `overtime_day_type`
  ADD PRIMARY KEY (`dayTypeId`);

--
-- Indexes for table `overtime_payrate`
--
ALTER TABLE `overtime_payrate`
  ADD PRIMARY KEY (`overtimePayrateId`),
  ADD KEY `dayTypeId` (`dayTypeId`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`payrollId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `payroll_item`
--
ALTER TABLE `payroll_item`
  ADD PRIMARY KEY (`payrollItemId`);

--
-- Indexes for table `payroll_item_type`
--
ALTER TABLE `payroll_item_type`
  ADD PRIMARY KEY (`payrollItemTypeId`);

--
-- Indexes for table `recruitment`
--
ALTER TABLE `recruitment`
  ADD PRIMARY KEY (`recruitmentId`);

--
-- Indexes for table `state_type`
--
ALTER TABLE `state_type`
  ADD PRIMARY KEY (`stateTypeId`);

--
-- Indexes for table `status_type`
--
ALTER TABLE `status_type`
  ADD PRIMARY KEY (`statusTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `allowance`
--
ALTER TABLE `allowance`
  MODIFY `allowanceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `allowance_type`
--
ALTER TABLE `allowance_type`
  MODIFY `allowanceTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `claim_request`
--
ALTER TABLE `claim_request`
  MODIFY `claimId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `claim_type`
--
ALTER TABLE `claim_type`
  MODIFY `claimTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holidayId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leave_item`
--
ALTER TABLE `leave_item`
  MODIFY `leaveItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leave_request`
--
ALTER TABLE `leave_request`
  MODIFY `leaveId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `leaveTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `overtime_day_type`
--
ALTER TABLE `overtime_day_type`
  MODIFY `dayTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `overtime_payrate`
--
ALTER TABLE `overtime_payrate`
  MODIFY `overtimePayrateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `payrollId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payroll_item`
--
ALTER TABLE `payroll_item`
  MODIFY `payrollItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payroll_item_type`
--
ALTER TABLE `payroll_item_type`
  MODIFY `payrollItemTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recruitment`
--
ALTER TABLE `recruitment`
  MODIFY `recruitmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `state_type`
--
ALTER TABLE `state_type`
  MODIFY `stateTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `status_type`
--
ALTER TABLE `status_type`
  MODIFY `statusTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allowance`
--
ALTER TABLE `allowance`
  ADD CONSTRAINT `allowance_ibfk_1` FOREIGN KEY (`recruitmentId`) REFERENCES `recruitment` (`recruitmentId`),
  ADD CONSTRAINT `allowance_ibfk_2` FOREIGN KEY (`allowanceTypeId`) REFERENCES `allowance_type` (`allowanceTypeId`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`);

--
-- Constraints for table `claim_request`
--
ALTER TABLE `claim_request`
  ADD CONSTRAINT `claim_request_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`),
  ADD CONSTRAINT `claim_request_ibfk_2` FOREIGN KEY (`claimTypeId`) REFERENCES `claim_type` (`claimTypeId`),
  ADD CONSTRAINT `claim_request_ibfk_3` FOREIGN KEY (`claimStatus`) REFERENCES `status_type` (`statusTypeId`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`stateTypeId`) REFERENCES `state_type` (`stateTypeId`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`recruitmentId`) REFERENCES `recruitment` (`recruitmentId`);

--
-- Constraints for table `leave_item`
--
ALTER TABLE `leave_item`
  ADD CONSTRAINT `leave_item_ibfk_1` FOREIGN KEY (`leaveTypeId`) REFERENCES `leave_type` (`leaveTypeId`);

--
-- Constraints for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD CONSTRAINT `leave_request_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`),
  ADD CONSTRAINT `leave_request_ibfk_2` FOREIGN KEY (`leaveTypeId`) REFERENCES `leave_type` (`leaveTypeId`),
  ADD CONSTRAINT `leave_request_ibfk_3` FOREIGN KEY (`leaveStatus`) REFERENCES `status_type` (`statusTypeId`);

--
-- Constraints for table `overtime_payrate`
--
ALTER TABLE `overtime_payrate`
  ADD CONSTRAINT `overtime_payrate_ibfk_1` FOREIGN KEY (`dayTypeId`) REFERENCES `overtime_day_type` (`dayTypeId`);

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
