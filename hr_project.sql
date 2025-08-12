-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 01, 2025 at 03:47 AM
-- Server version: 8.0.42
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `attendance_date` date NOT NULL,
  `employee_id` int NOT NULL,
  `status` varchar(20) NOT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `attendance_date`, `employee_id`, `status`, `recorded_at`) VALUES
(1, '2025-07-20', 1, 'Present', '2025-07-31 08:54:39'),
(2, '2025-07-20', 2, 'Present', '2025-07-31 08:54:39'),
(3, '2025-07-20', 3, 'Absent', '2025-07-31 08:54:39'),
(4, '2025-07-20', 4, 'Present', '2025-07-31 08:54:39'),
(5, '2025-07-20', 5, 'Present', '2025-07-31 08:54:39'),
(6, '2025-07-20', 6, 'Present', '2025-07-31 08:54:39'),
(7, '2025-07-20', 7, 'Absent', '2025-07-31 08:54:39'),
(8, '2025-07-20', 8, 'Present', '2025-07-31 08:54:39'),
(9, '2025-07-20', 9, 'Absent', '2025-07-31 08:54:39'),
(10, '2025-07-20', 10, 'Present', '2025-07-31 08:54:39'),
(11, '2025-07-21', 1, 'Present', '2025-07-31 08:54:39'),
(12, '2025-07-21', 2, 'Absent', '2025-07-31 08:54:39'),
(13, '2025-07-21', 3, 'Present', '2025-07-31 08:54:39'),
(14, '2025-07-21', 4, 'Present', '2025-07-31 08:54:39'),
(15, '2025-07-21', 5, 'Absent', '2025-07-31 08:54:39'),
(16, '2025-07-21', 6, 'Present', '2025-07-31 08:54:39'),
(17, '2025-07-21', 7, 'Present', '2025-07-31 08:54:39'),
(18, '2025-07-21', 8, 'Present', '2025-07-31 08:54:39'),
(19, '2025-07-21', 9, 'Present', '2025-07-31 08:54:39'),
(20, '2025-07-21', 10, 'Present', '2025-07-31 08:54:39'),
(21, '2025-07-22', 1, 'Present', '2025-07-31 08:54:39'),
(22, '2025-07-22', 2, 'Present', '2025-07-31 08:54:39'),
(23, '2025-07-22', 3, 'Present', '2025-07-31 08:54:39'),
(24, '2025-07-22', 4, 'Present', '2025-07-31 08:54:39'),
(25, '2025-07-22', 5, 'Present', '2025-07-31 08:54:39'),
(26, '2025-07-22', 6, 'Present', '2025-07-31 08:54:39'),
(27, '2025-07-22', 7, 'Present', '2025-07-31 08:54:39'),
(28, '2025-07-22', 8, 'Present', '2025-07-31 08:54:39'),
(29, '2025-07-22', 9, 'Present', '2025-07-31 08:54:39'),
(30, '2025-07-22', 10, 'Present', '2025-07-31 08:54:39'),
(31, '2025-07-23', 1, 'Present', '2025-07-31 08:54:39'),
(32, '2025-07-23', 2, 'Present', '2025-07-31 08:54:39'),
(33, '2025-07-23', 3, 'Present', '2025-07-31 08:54:39'),
(34, '2025-07-23', 4, 'Present', '2025-07-31 08:54:39'),
(35, '2025-07-23', 5, 'Absent', '2025-07-31 08:54:39'),
(36, '2025-07-23', 6, 'Absent', '2025-07-31 08:54:39'),
(37, '2025-07-23', 7, 'Present', '2025-07-31 08:54:39'),
(38, '2025-07-23', 8, 'Present', '2025-07-31 08:54:39'),
(39, '2025-07-23', 9, 'Present', '2025-07-31 08:54:39'),
(40, '2025-07-23', 10, 'Present', '2025-07-31 08:54:39'),
(41, '2025-07-24', 1, 'Present', '2025-07-31 08:54:39'),
(42, '2025-07-24', 2, 'Present', '2025-07-31 08:54:39'),
(43, '2025-07-24', 3, 'Present', '2025-07-31 08:54:39'),
(44, '2025-07-24', 4, 'Present', '2025-07-31 08:54:39'),
(45, '2025-07-24', 5, 'Present', '2025-07-31 08:54:39'),
(46, '2025-07-24', 6, 'Absent', '2025-07-31 08:54:39'),
(47, '2025-07-24', 7, 'Present', '2025-07-31 08:54:39'),
(48, '2025-07-24', 8, 'Present', '2025-07-31 08:54:39'),
(49, '2025-07-24', 9, 'Present', '2025-07-31 08:54:39'),
(50, '2025-07-24', 10, 'Present', '2025-07-31 08:54:39'),
(51, '2025-07-25', 1, 'Present', '2025-07-31 08:54:39'),
(52, '2025-07-25', 2, 'Present', '2025-07-31 08:54:39'),
(53, '2025-07-25', 3, 'Absent', '2025-07-31 08:54:39'),
(54, '2025-07-25', 4, 'Present', '2025-07-31 08:54:39'),
(55, '2025-07-25', 5, 'Present', '2025-07-31 08:54:39'),
(56, '2025-07-25', 6, 'Present', '2025-07-31 08:54:39'),
(57, '2025-07-25', 7, 'Present', '2025-07-31 08:54:39'),
(58, '2025-07-25', 8, 'Absent', '2025-07-31 08:54:39'),
(59, '2025-07-25', 9, 'Present', '2025-07-31 08:54:39'),
(60, '2025-07-25', 10, 'Present', '2025-07-31 08:54:39'),
(61, '2025-07-26', 1, 'Present', '2025-07-31 08:54:39'),
(62, '2025-07-26', 2, 'Present', '2025-07-31 08:54:39'),
(63, '2025-07-26', 3, 'Absent', '2025-07-31 08:54:39'),
(64, '2025-07-26', 4, 'Present', '2025-07-31 08:54:39'),
(65, '2025-07-26', 5, 'Present', '2025-07-31 08:54:39'),
(66, '2025-07-26', 6, 'Present', '2025-07-31 08:54:39'),
(67, '2025-07-26', 7, 'Present', '2025-07-31 08:54:39'),
(68, '2025-07-26', 8, 'Present', '2025-07-31 08:54:39'),
(69, '2025-07-26', 9, 'Absent', '2025-07-31 08:54:39'),
(70, '2025-07-26', 10, 'Present', '2025-07-31 08:54:39'),
(71, '2025-07-27', 1, 'Present', '2025-07-31 08:54:39'),
(72, '2025-07-27', 2, 'Present', '2025-07-31 08:54:39'),
(73, '2025-07-27', 3, 'Absent', '2025-07-31 08:54:39'),
(74, '2025-07-27', 4, 'Present', '2025-07-31 08:54:39'),
(75, '2025-07-27', 5, 'Present', '2025-07-31 08:54:39'),
(76, '2025-07-27', 6, 'Present', '2025-07-31 08:54:39'),
(77, '2025-07-27', 7, 'Present', '2025-07-31 08:54:39'),
(78, '2025-07-27', 8, 'Present', '2025-07-31 08:54:39'),
(79, '2025-07-27', 9, 'Absent', '2025-07-31 08:54:39'),
(80, '2025-07-27', 10, 'Present', '2025-07-31 08:54:39'),
(81, '2025-07-28', 1, 'Present', '2025-07-31 08:54:39'),
(82, '2025-07-28', 2, 'Present', '2025-07-31 08:54:39'),
(83, '2025-07-28', 3, 'Absent', '2025-07-31 08:54:39'),
(84, '2025-07-28', 4, 'Present', '2025-07-31 08:54:39'),
(85, '2025-07-28', 5, 'Present', '2025-07-31 08:54:39'),
(86, '2025-07-28', 6, 'Absent', '2025-07-31 08:54:39'),
(87, '2025-07-28', 7, 'Absent', '2025-07-31 08:54:39'),
(88, '2025-07-28', 8, 'Present', '2025-07-31 08:54:39'),
(89, '2025-07-28', 9, 'Present', '2025-07-31 08:54:39'),
(90, '2025-07-28', 10, 'Present', '2025-07-31 08:54:39'),
(91, '2025-07-29', 1, 'Present', '2025-07-31 08:54:39'),
(92, '2025-07-29', 2, 'Present', '2025-07-31 08:54:39'),
(93, '2025-07-29', 3, 'Present', '2025-07-31 08:54:39'),
(94, '2025-07-29', 4, 'Present', '2025-07-31 08:54:39'),
(95, '2025-07-29', 5, 'Present', '2025-07-31 08:54:39'),
(96, '2025-07-29', 6, 'Present', '2025-07-31 08:54:39'),
(97, '2025-07-29', 7, 'Absent', '2025-07-31 08:54:39'),
(98, '2025-07-29', 8, 'Present', '2025-07-31 08:54:39'),
(99, '2025-07-29', 9, 'Absent', '2025-07-31 08:54:39'),
(100, '2025-07-29', 10, 'Present', '2025-07-31 08:54:39'),
(101, '2025-07-30', 1, 'Present', '2025-07-31 08:54:39'),
(102, '2025-07-30', 2, 'Present', '2025-07-31 08:54:39'),
(103, '2025-07-30', 3, 'Present', '2025-07-31 08:54:39'),
(104, '2025-07-30', 4, 'Present', '2025-07-31 08:54:39'),
(105, '2025-07-30', 5, 'Present', '2025-07-31 08:54:39'),
(106, '2025-07-30', 6, 'Absent', '2025-07-31 08:54:39'),
(107, '2025-07-30', 7, 'Present', '2025-07-31 08:54:39'),
(108, '2025-07-30', 8, 'Present', '2025-07-31 08:54:39'),
(109, '2025-07-30', 9, 'Present', '2025-07-31 08:54:39'),
(110, '2025-07-30', 10, 'Present', '2025-07-31 08:54:39'),
(111, '2025-07-31', 1, 'Absent', '2025-07-31 08:54:39'),
(112, '2025-07-31', 2, 'Present', '2025-07-31 08:54:39'),
(113, '2025-07-31', 3, 'Present', '2025-07-31 08:54:39'),
(114, '2025-07-31', 4, 'Present', '2025-07-31 08:54:39'),
(115, '2025-07-31', 5, 'Present', '2025-07-31 08:54:39'),
(116, '2025-07-31', 6, 'Present', '2025-07-31 08:54:39'),
(117, '2025-07-31', 7, 'Present', '2025-07-31 08:54:39'),
(118, '2025-07-31', 8, 'Present', '2025-07-31 08:54:39'),
(119, '2025-07-31', 9, 'Absent', '2025-07-31 08:54:39'),
(120, '2025-07-31', 10, 'Present', '2025-07-31 08:54:39'),
(121, '2025-08-01', 1, 'Present', '2025-07-31 08:54:39'),
(122, '2025-08-01', 2, 'Absent', '2025-07-31 08:54:39'),
(123, '2025-08-01', 3, 'Present', '2025-07-31 08:54:39'),
(124, '2025-08-01', 4, 'Present', '2025-07-31 08:54:39'),
(125, '2025-08-01', 5, 'Present', '2025-07-31 08:54:39'),
(126, '2025-08-01', 6, 'Absent', '2025-07-31 08:54:39'),
(127, '2025-08-01', 7, 'Present', '2025-07-31 08:54:39'),
(128, '2025-08-01', 8, 'Present', '2025-07-31 08:54:39'),
(129, '2025-08-01', 9, 'Present', '2025-07-31 08:54:39'),
(130, '2025-08-01', 10, 'Present', '2025-07-31 08:54:39'),
(131, '2025-08-02', 1, 'Absent', '2025-07-31 08:54:39'),
(132, '2025-08-02', 2, 'Absent', '2025-07-31 08:54:39'),
(133, '2025-08-02', 3, 'Present', '2025-07-31 08:54:39'),
(134, '2025-08-02', 4, 'Present', '2025-07-31 08:54:39'),
(135, '2025-08-02', 5, 'Present', '2025-07-31 08:54:39'),
(136, '2025-08-02', 6, 'Absent', '2025-07-31 08:54:39'),
(137, '2025-08-02', 7, 'Present', '2025-07-31 08:54:39'),
(138, '2025-08-02', 8, 'Present', '2025-07-31 08:54:39'),
(139, '2025-08-02', 9, 'Present', '2025-07-31 08:54:39'),
(140, '2025-08-02', 10, 'Present', '2025-07-31 08:54:39'),
(141, '2025-08-03', 1, 'Present', '2025-07-31 08:54:39'),
(142, '2025-08-03', 2, 'Present', '2025-07-31 08:54:39'),
(143, '2025-08-03', 3, 'Present', '2025-07-31 08:54:39'),
(144, '2025-08-03', 4, 'Present', '2025-07-31 08:54:39'),
(145, '2025-08-03', 5, 'Present', '2025-07-31 08:54:39'),
(146, '2025-08-03', 6, 'Present', '2025-07-31 08:54:39'),
(147, '2025-08-03', 7, 'Absent', '2025-07-31 08:54:39'),
(148, '2025-08-03', 8, 'Present', '2025-07-31 08:54:39'),
(149, '2025-08-03', 9, 'Present', '2025-07-31 08:54:39'),
(150, '2025-08-03', 10, 'Present', '2025-07-31 08:54:39'),
(151, '2025-08-04', 1, 'Present', '2025-07-31 08:54:39'),
(153, '2025-08-04', 2, 'Present', '2025-07-31 08:54:39'),
(154, '2025-08-04', 3, 'Absent', '2025-07-31 08:54:39'),
(155, '2025-08-04', 4, 'Present', '2025-07-31 08:54:39'),
(156, '2025-08-04', 5, 'Present', '2025-07-31 08:54:39'),
(157, '2025-08-04', 6, 'Present', '2025-07-31 08:54:39'),
(158, '2025-08-04', 7, 'Absent', '2025-07-31 08:54:39'),
(159, '2025-08-04', 8, 'Present', '2025-07-31 08:54:39'),
(160, '2025-08-04', 9, 'Absent', '2025-07-31 08:54:39'),
(161, '2025-08-04', 10, 'Present', '2025-07-31 08:54:39'),
(162, '2025-08-05', 1, 'Present', '2025-07-31 08:54:39'),
(163, '2025-08-05', 2, 'Absent', '2025-07-31 08:54:39'),
(164, '2025-08-05', 3, 'Present', '2025-07-31 08:54:39'),
(165, '2025-08-05', 4, 'Present', '2025-07-31 08:54:39'),
(166, '2025-08-05', 5, 'Absent', '2025-07-31 08:54:39'),
(167, '2025-08-05', 6, 'Present', '2025-07-31 08:54:39'),
(168, '2025-08-05', 7, 'Present', '2025-07-31 08:54:39'),
(169, '2025-08-05', 8, 'Present', '2025-07-31 08:54:39'),
(170, '2025-08-05', 9, 'Present', '2025-07-31 08:54:39'),
(171, '2025-08-05', 10, 'Present', '2025-07-31 08:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int NOT NULL,
  `department_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Development'),
(2, 'HR'),
(3, 'Quality assurance'),
(4, 'Sales'),
(5, 'Marketing'),
(6, 'Design'),
(7, 'IT'),
(8, 'Finance'),
(9, 'Support');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int NOT NULL,
  `employee_name` varchar(150) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `employment_history` text,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `username`, `password`, `department_id`, `position`, `salary`, `employment_history`, `email`) VALUES
(1, 'Sibongile Nkosi', 'snkosi', '$2y$10$DARVPfZOJSAURNf.ONCgVehV9080XFlo1HWZNtMyPFVSBBwRqPS4.', 1, 'Software Engineer', 70000.00, 'Joined in 2015, promoted to Senior in 2018', 'sibongile.nkosi@moderntech.com'),
(2, 'Lungile Moyo', 'lmoyo', '$2y$10$JcAXEFbUN3ggZ4xqdDRC/uO3lachoJ7kxU.BcKrW9jls6rXHyMLTG', 2, 'HR Manager', 80000.00, 'Joined in 2013, promoted to Manager in 2017', 'lungile.moyo@moderntech.com'),
(3, 'Thabo Molefe', 'tmolefe', '$2y$10$cIATtwynN97YEQ.qXk506.EvBtFF9uE2XKQcDO7ZdflK37LJe4lVq', 3, 'Quality Analyst', 55000.00, 'Joined in 2018', 'thabo.molefe@moderntech.com'),
(4, 'Keshav Naidoo', 'knaidoo', '$2y$10$1dL0EIWX5QPWQSPQCAtDAeGgF3DDJhpDXpF/Dqjupm6ppcM3CuGhK', 4, 'Sales Representative', 60000.00, 'Joined in 2020', 'keshav.naidoo@moderntech.com'),
(5, 'Zanele Khumalo', 'zkhumalo', '$2y$10$mYn4EynsQJYTnUZAAB/PeO12t.iHmGYQ/Gg4XItRl6rhjdd47Toqi', 5, 'Marketing Specialist', 58000.00, 'Joined in 2019', 'zanele.khumalo@moderntech.com'),
(6, 'Sipho Zulu', 'szulu', '$2y$10$7D7EhfyLbtOyqemGRFHJyOeAHlGDnZEcmyPp.OxJopOPBjohX.7s.', 6, 'UI/UX Designer', 65000.00, 'Joined in 2016', 'sipho.zulu@moderntech.com'),
(7, 'Naledi Moeketsi', 'nmoeketsi', '$2y$10$4zjdvC9/4NKvPva73ydTLOGVrL.R9.bKSD.Mn0Y1hcYOH1G7tj2H6', 7, 'DevOps Engineer', 72000.00, 'Joined in 2017', 'naledi.moeketsi@moderntech.com'),
(8, 'Farai Gumbo', 'fgumbo', '$2y$10$KBweTI6vK8ic0JIXw87ADu42oZ8d6uelKNw1kUjnYoX9R/vjdBT3i', 5, 'Content Strategist', 56000.00, 'Joined in 2021', 'farai.gumbo@moderntech.com'),
(9, 'Karabo Dlamini', 'kdlamini', '$2y$10$lekcP1llX1e6fIAAnzhcFeCOpZJcFYK33ADHxcZBEx2eNtqFVdP.a', 8, 'Accountant', 62000.00, 'Joined in 2018', 'karabo.dlamini@moderntech.com'),
(10, 'Fatima Patel', 'fpatel', '$2y$10$2rkmfKLA/eflymq6GrfoUecv1T4hiPLrS13oNNXjgnVcqcbVHBNgK', 9, 'Customer Support Lead', 58000.00, 'Joined in 2016', 'fatima.patel@moderntech.com');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `detail_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`detail_id`, `employee_id`, `dob`, `gender`, `marital_status`, `phone`, `address`) VALUES
(1, 1, '2004-08-26', 'Female', 'In a relationship', '0789342773', '50 NY 56 Gugulethu 7750'),
(4, 6, '1991-06-20', 'Male', 'Single', '4565774324', '230 j nontulo str new cross roads 7750');

-- --------------------------------------------------------

--
-- Table structure for table `leaverequest`
--

CREATE TABLE `leaverequest` (
  `employee_id` int NOT NULL,
  `leave_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` enum('Approved','Pending','Denied') NOT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leaverequest`
--

INSERT INTO `leaverequest` (`employee_id`, `leave_date`, `reason`, `status`, `recorded_at`) VALUES
(1, '2024-12-01', 'Personal', 'Pending', '2025-07-26 17:34:10'),
(1, '2025-07-22', 'Sick Leave', 'Approved', '2025-07-26 17:34:10'),
(2, '2024-12-02', 'Vacation', 'Approved', '2025-07-26 17:34:10'),
(2, '2025-07-15', 'Family Responsibility', 'Denied', '2025-07-26 17:34:10'),
(3, '2024-12-05', 'Personal', 'Pending', '2025-07-26 17:34:10'),
(3, '2025-07-10', 'Medical Appointment', 'Approved', '2025-07-26 17:34:10'),
(4, '2025-07-20', 'Bereavement', 'Approved', '2025-07-26 17:34:10'),
(5, '2024-12-01', 'Childcare', 'Pending', '2025-07-26 17:34:10'),
(6, '2025-07-18', 'Sick Leave', 'Approved', '2025-07-26 17:34:10'),
(7, '2025-07-22', 'Vacation', 'Pending', '2025-07-26 17:34:10'),
(8, '2024-12-02', 'Medical Appointment', 'Approved', '2025-07-26 17:34:10'),
(9, '2025-07-19', 'Childcare', 'Denied', '2025-07-26 17:34:10'),
(10, '2024-12-03', 'Vacation', 'Pending', '2025-07-26 17:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `leave_history`
--

CREATE TABLE `leave_history` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `leave_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text,
  `status` enum('Approved','Denied') NOT NULL,
  `processed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_history`
--

INSERT INTO `leave_history` (`id`, `employee_id`, `leave_date`, `end_date`, `reason`, `status`, `processed_at`) VALUES
(1, 3, '2025-07-30', '2025-08-08', 'Im just tired boss.', 'Approved', '2025-07-31 08:51:15'),
(2, 3, '2025-07-24', '2025-07-30', 'ckxidlfi;', 'Denied', '2025-07-31 08:54:34'),
(3, 12, '2025-07-24', '2025-07-28', 'giuuxyu', 'Denied', '2025-07-31 08:54:35'),
(4, 1, '2025-07-16', '2025-07-22', 'uyfdif', 'Denied', '2025-07-31 08:54:36'),
(5, 1, '2025-07-31', '2025-08-04', 'eer', 'Denied', '2025-07-31 09:31:15'),
(6, 3, '2025-07-25', '2025-08-07', 'funu lala', 'Denied', '2025-07-31 13:42:20');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `leave_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Approved','Pending','Denied') DEFAULT 'Pending',
  `recorded_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_date`, `end_date`, `reason`, `status`, `recorded_at`) VALUES
(3, 3, '2025-07-22', '2025-07-29', 'just for the vibes yk', 'Approved', NULL),
(7, 3, '2025-07-02', '2025-07-09', 'ukifu', 'Approved', NULL),
(9, 4, '2025-07-31', '2025-08-04', 'vvuvvvuvu', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `employee_id` int NOT NULL,
  `hours_worked` int DEFAULT NULL,
  `leave_deductions` int DEFAULT NULL,
  `final_salary` decimal(10,2) DEFAULT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`employee_id`, `hours_worked`, `leave_deductions`, `final_salary`, `recorded_at`) VALUES
(1, 160, 8, 69500.00, '2025-07-26 17:34:10'),
(2, 150, 10, 79000.00, '2025-07-26 17:34:10'),
(3, 170, 4, 54800.00, '2025-07-26 17:34:10'),
(4, 165, 6, 59700.00, '2025-07-26 17:34:10'),
(5, 158, 5, 57850.00, '2025-07-26 17:34:10'),
(6, 168, 2, 64800.00, '2025-07-26 17:34:10'),
(7, 175, 3, 71800.00, '2025-07-26 17:34:10'),
(8, 160, 0, 56000.00, '2025-07-26 17:34:10'),
(9, 155, 5, 61500.00, '2025-07-26 17:34:10'),
(10, 162, 4, 57750.00, '2025-07-26 17:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `performance_reviews`
--

CREATE TABLE `performance_reviews` (
  `employee_id` int NOT NULL,
  `punctuality` int DEFAULT NULL,
  `task_completion` int DEFAULT NULL,
  `teamwork` int DEFAULT NULL,
  `comments` text,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `performance_reviews`
--

INSERT INTO `performance_reviews` (`employee_id`, `punctuality`, `task_completion`, `teamwork`, `comments`, `recorded_at`) VALUES
(1, 9, 8, 7, 'Consistently meets expectations and works well under pressure.', '2025-07-28 12:12:04'),
(2, 10, 9, 9, 'Outstanding contributor with great team spirit.', '2025-07-28 12:12:04'),
(3, 6, 7, 8, 'Needs improvement in time management.', '2025-07-28 12:12:04'),
(4, 8, 7, 6, 'Occasionally works in isolation; encouraged to engage more with the team.', '2025-07-28 12:12:04'),
(5, 6, 7, 9, 'A reliable team player who supports colleagues and contributes positively to group efforts.', '2025-07-28 12:12:04'),
(6, 5, 7, 7, 'Lacks initiative; should work on being more self-driven.', '2025-07-28 12:12:04'),
(7, 5, 7, 6, 'Needs to be more proactive in sharing updates and seeking clarification when needed.', '2025-07-28 12:12:04'),
(8, 7, 8, 9, 'Communicates clearly and effectively with team members and clients.', '2025-07-28 12:12:04'),
(9, 8, 7, 8, 'Meets expectations but occasionally requires supervision to maintain quality.', '2025-07-28 12:12:04'),
(10, 6, 7, 9, 'Consistently delivers high-quality work with attention to detail.', '2025-07-28 12:12:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `leaverequest`
--
ALTER TABLE `leaverequest`
  ADD PRIMARY KEY (`employee_id`,`leave_date`);

--
-- Indexes for table `leave_history`
--
ALTER TABLE `leave_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee` (`employee_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD PRIMARY KEY (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leave_history`
--
ALTER TABLE `leave_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `employee_details_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE;

--
-- Constraints for table `leaverequest`
--
ALTER TABLE `leaverequest`
  ADD CONSTRAINT `leaverequest_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD CONSTRAINT `performance_reviews_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
