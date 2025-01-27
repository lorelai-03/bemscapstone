-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 03:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_student`
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
(2, 'admin@gmail.com', '$2y$10$J0N/kOdBz8JVnaP8oS9UHODjM4YLL6XsWzG4wt96TXJfkKkK0aK3u', '2024-11-11 22:56:38'),
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
(26, 2, '2024-11-13 06:11:23', '2024-11-13 06:12:21', 'login'),
(27, 2, '2024-11-13 06:12:24', '2024-11-13 06:12:56', 'login'),
(28, 2, '2024-11-14 02:09:57', NULL, 'login');

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
  `password` varchar(255) NOT NULL
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_cert`
--
ALTER TABLE `tbl_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_info`
--
ALTER TABLE `tbl_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_off`
--
ALTER TABLE `tbl_off`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tbl_offi`
--
ALTER TABLE `tbl_offi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_resi`
--
ALTER TABLE `tbl_resi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

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
