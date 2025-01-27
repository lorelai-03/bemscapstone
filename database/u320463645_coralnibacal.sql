-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2024 at 11:16 AM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u320463645_coralnibacal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`) VALUES
(2, 'admin@gmail.com', '$2y$10$cM0LoIikGoRfEZD.RFLeoeBr0/HgcjdjsSM7VGm7E9thau9n5y5Ci', '2024-11-11 22:56:38'),
(3, 'secretary@gmail.com', '$2y$10$FnMQL3FbuAPky6R06X5mPuokcg2XPJO9XBTCAcQtFGadp7Oi3gw/.', '2024-11-12 12:52:10');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `date`, `description`, `purok`) VALUES
(16, 'raffle for all purok', '2024-11-12', 'fill up lang ng form sa office', ''),
(17, 'Meeting', '2024-11-17', 'Sa barangay hall', ''),
(18, 'Senior Citizen Party', '2024-12-03', 'Ilista lahat ng senior by purok ng lalahok sa event', ''),
(19, 'Ayuda', '2024-11-17', 'Punta sa barangay hall ng 8am para mabigyan ng ayuda', ''),
(20, 'Ayuda', '2024-11-20', 'Punta s bhall ng 8am para mabigyan ng ayuda', ''),
(21, 'event', '2024-11-19', 'barangay hall', ''),
(22, 'Brgy. Assembly ', '2024-11-21', 'Announcement 📌 What: Brgy. Assembly When: November 21, 2024 (Today) 1:00pm Where: Coral ni Bacal Covered Court', ''),
(23, 'Brgy. Assembly ', '2024-11-20', 'Ang lahat po ay inaanyayahang dumalo What: Brgy. Assembly When: November 20, 2024 (Today) 1:00pm Where: Coral ni Bacal Covered Court', ''),
(24, 'ayuda', '2024-11-23', '@barangay hall', ''),
(25, 'Ayuda', '2024-11-24', 'sa barangay hall', ''),
(26, 'Health care', '2024-11-30', 'Sa court', ''),
(27, 'Ayuda', '2024-11-29', 'Barangay hall', '');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL,
  `action` enum('login','logout') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `admin_id`, `login_time`, `logout_time`, `action`) VALUES
(45, 2, '2024-11-15 08:31:33', '2024-11-15 08:31:40', 'login'),
(46, 2, '2024-11-15 09:56:00', '2024-11-15 09:56:31', 'login'),
(47, 2, '2024-11-15 09:56:20', '2024-11-15 09:56:31', 'login'),
(48, 3, '2024-11-15 09:57:23', '2024-11-15 09:57:37', 'login'),
(49, 2, '2024-11-15 10:18:36', '2024-11-15 10:38:45', 'login'),
(50, 2, '2024-11-15 10:18:39', '2024-11-15 10:38:45', 'login'),
(51, 2, '2024-11-15 10:19:06', '2024-11-15 10:38:45', 'login'),
(52, 2, '2024-11-15 10:24:27', '2024-11-15 10:38:45', 'login'),
(53, 2, '2024-11-15 10:54:08', '2024-11-15 10:56:36', 'login'),
(54, 2, '2024-11-15 10:58:06', '2024-11-15 12:15:10', 'login'),
(55, 2, '2024-11-15 11:34:27', '2024-11-15 12:15:10', 'login'),
(56, 2, '2024-11-15 11:35:59', '2024-11-15 12:15:10', 'login'),
(57, 2, '2024-11-15 11:49:28', '2024-11-15 12:15:10', 'login'),
(58, 2, '2024-11-15 12:13:07', '2024-11-15 12:15:10', 'login'),
(59, 3, '2024-11-15 12:17:47', '2024-11-15 12:17:59', 'login'),
(60, 2, '2024-11-15 12:24:16', '2024-11-15 13:14:36', 'login'),
(61, 2, '2024-11-15 12:42:30', '2024-11-15 13:14:36', 'login'),
(62, 2, '2024-11-15 12:44:19', '2024-11-15 13:14:36', 'login'),
(63, 2, '2024-11-15 13:07:31', '2024-11-15 13:14:36', 'login'),
(64, 2, '2024-11-15 13:09:18', '2024-11-15 13:14:36', 'login'),
(65, 2, '2024-11-15 13:10:29', '2024-11-15 13:14:36', 'login'),
(66, 2, '2024-11-15 13:26:35', '2024-11-15 13:45:28', 'login'),
(67, 2, '2024-11-15 13:44:00', '2024-11-15 13:45:28', 'login'),
(68, 2, '2024-11-15 13:46:21', '2024-11-15 13:47:57', 'login'),
(69, 2, '2024-11-15 14:54:59', '2024-11-15 21:01:35', 'login'),
(70, 2, '2024-11-15 20:35:49', '2024-11-15 21:01:35', 'login'),
(71, 2, '2024-11-15 21:02:43', '2024-11-16 12:54:53', 'login'),
(72, 2, '2024-11-15 21:45:16', '2024-11-16 12:54:53', 'login'),
(73, 2, '2024-11-15 21:58:51', '2024-11-16 12:54:53', 'login'),
(74, 2, '2024-11-15 22:02:03', '2024-11-16 12:54:53', 'login'),
(75, 2, '2024-11-15 22:11:14', '2024-11-16 12:54:53', 'login'),
(76, 2, '2024-11-16 01:17:27', '2024-11-16 12:54:53', 'login'),
(77, 2, '2024-11-16 02:01:41', '2024-11-16 12:54:53', 'login'),
(78, 2, '2024-11-16 12:44:24', '2024-11-16 12:54:53', 'login'),
(79, 2, '2024-11-16 12:51:12', '2024-11-16 12:54:53', 'login'),
(80, 2, '2024-11-16 12:57:56', '2024-11-16 13:27:03', 'login'),
(81, 2, '2024-11-16 13:26:35', '2024-11-16 13:27:03', 'login'),
(82, 2, '2024-11-16 13:43:07', '2024-11-16 13:43:59', 'login'),
(83, 2, '2024-11-16 14:06:01', '2024-11-16 14:07:22', 'login'),
(84, 3, '2024-11-16 14:08:03', '2024-11-16 14:08:37', 'login'),
(85, 2, '2024-11-16 14:11:59', '2024-11-17 03:57:09', 'login'),
(86, 2, '2024-11-16 14:15:38', '2024-11-17 03:57:09', 'login'),
(87, 2, '2024-11-17 01:07:29', '2024-11-17 03:57:09', 'login'),
(88, 2, '2024-11-17 03:51:28', '2024-11-17 03:57:09', 'login'),
(89, 2, '2024-11-17 03:51:38', '2024-11-17 03:57:09', 'login'),
(90, 2, '2024-11-17 12:19:52', '2024-11-17 13:29:58', 'login'),
(91, 2, '2024-11-17 13:27:02', '2024-11-17 13:29:58', 'login'),
(92, 2, '2024-11-18 03:28:03', '2024-11-18 03:30:05', 'login'),
(93, 2, '2024-11-18 08:13:06', '2024-11-18 08:35:20', 'login'),
(94, 2, '2024-11-18 08:33:14', '2024-11-18 08:35:20', 'login'),
(95, 2, '2024-11-18 09:32:52', '2024-11-18 09:34:12', 'login'),
(96, 3, '2024-11-18 20:03:02', '2024-11-19 13:44:55', 'login'),
(97, 2, '2024-11-19 05:17:34', '2024-11-19 05:18:36', 'login'),
(98, 2, '2024-11-19 12:54:17', '2024-11-19 13:44:01', 'login'),
(99, 2, '2024-11-19 13:41:27', '2024-11-19 13:44:01', 'login'),
(100, 2, '2024-11-19 13:42:29', '2024-11-19 13:44:01', 'login'),
(101, 3, '2024-11-19 13:44:32', '2024-11-19 13:44:55', 'login'),
(102, 2, '2024-11-19 13:47:34', '2024-11-22 11:08:47', 'login'),
(103, 2, '2024-11-21 14:01:42', '2024-11-22 11:08:47', 'login'),
(104, 2, '2024-11-22 10:21:54', '2024-11-22 11:08:47', 'login'),
(105, 3, '2024-11-22 11:09:35', '2024-11-22 11:15:54', 'login'),
(106, 2, '2024-11-22 11:16:06', NULL, 'login'),
(107, 3, '2024-11-22 12:24:54', '2024-11-28 12:32:24', 'login'),
(108, 2, '2024-11-24 07:45:47', NULL, 'login'),
(109, 2, '2024-11-25 04:15:27', NULL, 'login'),
(110, 2, '2024-11-26 02:51:09', NULL, 'login'),
(111, 2, '2024-11-26 04:22:40', NULL, 'login'),
(112, 2, '2024-11-27 12:55:19', NULL, 'login'),
(113, 3, '2024-11-28 12:30:10', '2024-11-28 12:32:24', 'login'),
(114, 2, '2024-11-28 12:32:40', NULL, 'login'),
(115, 2, '2024-11-29 09:14:14', NULL, 'login');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cert`
--

CREATE TABLE `tbl_cert` (
  `id` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `ctype` varchar(50) NOT NULL,
  `purpose` text NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `daterequest` datetime DEFAULT current_timestamp(),
  `dateapprove` datetime DEFAULT NULL,
  `resident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cert`
--

INSERT INTO `tbl_cert` (`id`, `rname`, `ctype`, `purpose`, `status`, `daterequest`, `dateapprove`, `resident_id`) VALUES
(26, 'Eugene ', 'Barangay Pig Permit', 'None', 'Pending', '2024-11-27 12:58:28', NULL, 364);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_certificates`
--

CREATE TABLE `tbl_certificates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `certificate_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_certificates`
--

INSERT INTO `tbl_certificates` (`id`, `name`, `file_path`, `created_at`, `certificate_name`) VALUES
(10, 'Eugene A Pilac', 'uploads/certificates/certificate_6739efc8f0d994.18703922.docx', '2024-11-17 13:29:44', 'Eugene Andrei B Pilac ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_info`
--

CREATE TABLE `tbl_info` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_info`
--

INSERT INTO `tbl_info` (`id`, `type`, `date`, `time`, `message`, `image`) VALUES
(30, 'Water Supply', '2024-11-17', '04:36:00', 'Bhall', 'uploads/events/1731704587_Screenshot_20241115-193211_Brave.jpg'),
(31, 'health care', '2024-11-12', '11:54:00', 'nuby', NULL),
(32, 'Ayuda', '2024-11-18', '16:34:00', 'Barangay hall', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_off`
--

CREATE TABLE `tbl_off` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `middle` varchar(255) NOT NULL,
  `last` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offi`
--

CREATE TABLE `tbl_offi` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_offi`
--

INSERT INTO `tbl_offi` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'secretary11', '$2y$10$EO9NRdw90P4XSVQmMTqAOu3I4bD4pAFsj6oUcusR9EQkAsEs69uBm', 'admin@gmail.com', '2024-10-14 14:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resi`
--

CREATE TABLE `tbl_resi` (
  `id` int(255) NOT NULL,
  `firstn` varchar(255) NOT NULL,
  `lastn` varchar(255) NOT NULL,
  `middlei` varchar(50) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approval_status` enum('pending','approved') NOT NULL,
  `pending` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_resi`
--

INSERT INTO `tbl_resi` (`id`, `firstn`, `lastn`, `middlei`, `gender`, `contact`, `purok`, `imagePath`, `username`, `password`, `approval_status`, `pending`) VALUES
(364, 'Eugene', 'Pilac', 'A', 'Male', '09480177039', 'Purok 7', 'uploads/1731666222_17316661133108171428238804442286.jpg', 'Eugene01', '$2y$10$3bYbgZqADFMJavxV8UCZHOUtdiY4/Mvzf1mOOUHKBA0n8cRHzvSN2', 'approved', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_cert`
--
ALTER TABLE `tbl_cert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_info`
--
ALTER TABLE `tbl_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_off`
--
ALTER TABLE `tbl_off`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_offi`
--
ALTER TABLE `tbl_offi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_resi`
--
ALTER TABLE `tbl_resi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_cert`
--
ALTER TABLE `tbl_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_info`
--
ALTER TABLE `tbl_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_off`
--
ALTER TABLE `tbl_off`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_offi`
--
ALTER TABLE `tbl_offi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_resi`
--
ALTER TABLE `tbl_resi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
