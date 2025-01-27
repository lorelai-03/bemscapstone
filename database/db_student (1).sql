-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 05:07 PM
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
(106, 2, '2024-11-22 11:16:06', '2025-01-01 02:45:50', 'login'),
(107, 3, '2024-11-22 12:24:54', '2024-11-28 12:32:24', 'login'),
(108, 2, '2024-11-24 07:45:47', '2025-01-01 02:45:50', 'login'),
(109, 2, '2024-11-25 04:15:27', '2025-01-01 02:45:50', 'login'),
(110, 2, '2024-11-26 02:51:09', '2025-01-01 02:45:50', 'login'),
(111, 2, '2024-11-26 04:22:40', '2025-01-01 02:45:50', 'login'),
(112, 2, '2024-11-27 12:55:19', '2025-01-01 02:45:50', 'login'),
(113, 3, '2024-11-28 12:30:10', '2024-11-28 12:32:24', 'login'),
(114, 2, '2024-11-28 12:32:40', '2025-01-01 02:45:50', 'login'),
(115, 2, '2024-11-29 09:14:14', '2025-01-01 02:45:50', 'login'),
(116, 2, '2025-01-01 02:16:17', '2025-01-01 02:45:50', 'login'),
(117, 2, '2025-01-01 02:45:54', '2025-01-01 04:23:54', 'login'),
(118, 2, '2025-01-01 03:28:06', '2025-01-01 04:23:54', 'login'),
(119, 2, '2025-01-01 04:30:08', '2025-01-01 07:12:53', 'login'),
(120, 2, '2025-01-01 04:32:53', '2025-01-01 07:12:53', 'login'),
(121, 2, '2025-01-01 07:14:49', '2025-01-01 07:15:14', 'login'),
(122, 2, '2025-01-01 12:59:59', '2025-01-01 13:21:55', 'login'),
(123, 2, '2025-01-01 13:21:58', '2025-01-01 13:22:57', 'login'),
(124, 2, '2025-01-01 13:23:00', '2025-01-01 13:50:13', 'login'),
(125, 2, '2025-01-01 14:09:18', '2025-01-01 14:46:16', 'login'),
(126, 2, '2025-01-01 15:14:50', '2025-01-03 11:43:59', 'login'),
(127, 2, '2025-01-03 11:32:57', '2025-01-03 11:43:59', 'login'),
(128, 2, '2025-01-03 11:44:15', '2025-01-03 11:44:42', 'login'),
(129, 2, '2025-01-03 11:46:22', '2025-01-03 11:55:49', 'login'),
(130, 2, '2025-01-03 12:28:39', NULL, 'login'),
(131, 2, '2025-01-04 15:42:30', NULL, 'login');

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
(37, 'Julius Paul Marcial', 'Barangay Clearance', 'For Employment', 'viewed', '2025-01-04 23:42:22', NULL, 380),
(42, 'JuliusPaul C Marcial', 'account approval.', 'Thank you.', 'viewed', '2025-01-04 00:00:00', NULL, 0);

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
(57, 'Bagong taon bagong buhay sa barangay coral na bacal', '2025-01-03', '07:42:00', 'Bagong taon bagong buhay sa barangay coral na bacal', 'uploads/events/wallpaperflare.com_wallpaper.jpg'),
(58, 'New year party', '2025-01-13', '10:45:00', 'New year party', 'uploads/events/wallpaperflare.com_wallpaper.jpg');

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

--
-- Dumping data for table `tbl_off`
--

INSERT INTO `tbl_off` (`id`, `name`, `middle`, `last`, `status`, `gender`, `position`, `start`, `image`, `username`, `password`, `contact`) VALUES
(117, 'Julius Paul', 'wd', 'Marcial', 'active', 'Male', 'kapitan', '', 'uploads/wallpaperflare.com_wallpaper.jpg', 'juju123', '$2y$10$wRj7V826pw4/7OFryb3Bau/5OLAtGLwatar3vqV72qbnJmvziOmSe', '09663367020');

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
  `pending` varchar(255) NOT NULL,
  `household_residents` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_resi`
--

INSERT INTO `tbl_resi` (`id`, `firstn`, `lastn`, `middlei`, `gender`, `contact`, `purok`, `imagePath`, `username`, `password`, `approval_status`, `pending`, `household_residents`, `created_at`) VALUES
(364, 'Eugene', 'Pilac', 'A', 'Male', '09480177039', 'Purok 7', 'uploads/1731666222_17316661133108171428238804442286.jpg', 'Eugene01', '$2y$10$3bYbgZqADFMJavxV8UCZHOUtdiY4/Mvzf1mOOUHKBA0n8cRHzvSN2', 'approved', '', NULL, '2025-01-04 15:44:59'),
(380, 'Julius Paul', 'Marcial', 'C', 'male', '09663367020', 'Purok 3', 'uploads/wallpaperflare.com_wallpaper.jpg', 'juju', '$2y$10$31IMIEM0F7pJL55nNbwVFOT05X9y.p2QEtyvEDwSYC1Z0hy2PWPbG', 'approved', '', 'Japjap', '2025-01-04 15:44:59'),
(381, 'Julius Paul', 'Marcial', 'C', 'male', '09297064431', 'Purok 5', 'uploads/wallpaperflare.com_wallpaper.jpg', 'juju1', '$2y$10$EIz.VBJ72Zd/rpQnQj.3HOPmNXvZzPdveSPxPsy/85dO2DFsdS9XS', 'approved', '', 'japjap', '2025-01-04 15:44:59'),
(389, 'JuliusPaul', 'Marcial', 'C', 'Female', '09663367020323', 'Purok 3', 'uploads/1736006539_CamScanner 02-08-2024 11.31_3.jpg', 'jujuju', '$2y$10$cfDpWyH/279X6uhyw4D64eqU5XQOy7tnltmBT0R7fzQfUmbdJFdPG', 'pending', '', 'dwqd', '2025-01-04 16:02:19'),
(390, 'JuliusPaul', 'Marcial', 'ddwd', 'Female', '09663367020123', 'Purok 4', 'uploads/1736006752_CamScanner 02-08-2024 11.31_2.jpg', 'jujuj', '$2y$10$4DJSo7aOBbjXQQG/XdGae.gu9svRS9zdQF/Qwk7ecdlmNYT1067i.', 'pending', '', 'dwd', '2025-01-04 16:05:52'),
(391, 'JuliusPaul', 'Marcial', 'C', 'Female', '09663367020232', 'Purok 2', 'uploads/1736006806_wallpaperflare.com_wallpaper.jpg', 'admin2', '$2y$10$6gJCpLs3qmOEdFAfddhVdOkYTvdVL2jekrGNNjSU7moiclzZnd/Fu', 'pending', '', 'wqdqw', '2025-01-04 16:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms`
--

CREATE TABLE `tbl_sms` (
  `id` int(11) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `send_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sms`
--

INSERT INTO `tbl_sms` (`id`, `contact`, `message`, `send_time`, `created_at`) VALUES
(10, '09480177039', 'New Event: Bagong taon bagong buhay on 2025-01-08 at 07:36 PM. Details: Dumalo lahat', '2025-01-03 12:33:26', '2025-01-03 11:33:27'),
(11, '09480177039', 'New Event: Bagong taon bagong buhay on 2025-01-14 at 07:37 PM. Details: salamat mga kabarangay', '2025-01-03 12:34:57', '2025-01-03 11:34:58'),
(12, '09480177039', 'New Event: Bagong taon bagong buhay on 2025-01-08 at 07:40 PM. Details: salamat mga kabarangay', '2025-01-03 12:37:56', '2025-01-03 11:37:57'),
(13, '09663367020', 'New Event: Bagong taon bagong buhay on 2025-01-08 at 07:40 PM. Details: salamat mga kabarangay', '2025-01-03 12:37:57', '2025-01-03 11:37:58'),
(14, '09480177039', 'New Event: Bagong taon bagong buhay on 2025-01-08 at 07:40 PM. Details: salamat mga kabarangay', '2025-01-03 12:38:02', '2025-01-03 11:38:02'),
(15, '09663367020', 'New Event: Bagong taon bagong buhay on 2025-01-08 at 07:40 PM. Details: salamat mga kabarangay', '2025-01-03 12:38:02', '2025-01-03 11:38:02'),
(16, '09480177039', 'New Event: Bagong taon bagong buhay on 2025-01-14 at 07:42 PM. Details: Bagong taon bagong buhay', '2025-01-03 12:40:46', '2025-01-03 11:40:47'),
(17, '09663367020', 'New Event: Bagong taon bagong buhay on 2025-01-14 at 07:42 PM. Details: Bagong taon bagong buhay', '2025-01-03 12:40:47', '2025-01-03 11:40:48'),
(18, '09480177039', 'New Event: Bagong taon bagong buhay sa barangay coral na bacal on 2025-01-03 at 07:42 PM. Details: Bagong taon bagong buhay sa barangay coral na bacal', '2025-01-03 12:42:48', '2025-01-03 11:42:48'),
(19, '09663367020', 'New Event: Bagong taon bagong buhay sa barangay coral na bacal on 2025-01-03 at 07:42 PM. Details: Bagong taon bagong buhay sa barangay coral na bacal', '2025-01-03 12:42:48', '2025-01-03 11:42:49'),
(20, '09297064431', 'New Event: Bagong taon bagong buhay sa barangay coral na bacal on 2025-01-03 at 07:42 PM. Details: Bagong taon bagong buhay sa barangay coral na bacal', '2025-01-03 12:42:49', '2025-01-03 11:42:49'),
(21, '09480177039', 'New Event: New year party on 2025-01-13 at 10:45 PM. Details: New year party', '2025-01-03 12:45:09', '2025-01-03 11:45:09'),
(22, '09663367020', 'New Event: New year party on 2025-01-13 at 10:45 PM. Details: New year party', '2025-01-03 12:45:09', '2025-01-03 11:45:10'),
(23, '09297064431', 'New Event: New year party on 2025-01-13 at 10:45 PM. Details: New year party', '2025-01-03 12:45:10', '2025-01-03 11:45:10'),
(24, '09663367020', 'Request Certificate Update: Certificate of Indigency, Date: 2025-01-03, Time: 12:50 PM, Messages: For employment.', '2025-01-03 12:50:25', '2025-01-03 11:50:25'),
(25, '09297064431', 'Request Certificate Update: Certificate of Indigency, Date: 2025-01-03, Time: 07:52 PM, Messages: Pick up at brgy hall.', '2025-01-03 19:52:37', '2025-01-03 11:52:37'),
(26, '09480177039', 'Request Certificate Update: Check time, Date: 2025-01-03, Time: 07:54 PM, Messages: Hi Eugene, if the timezone is accurate can you give it a feedback on groupchat. Thank you..', '2025-01-03 19:54:03', '2025-01-03 11:54:03'),
(27, '09663367020', 'Request Certificate Update: Barangay Clearance, Date: 2025-01-03, Time: 07:54 PM, Messages: Pick up at brgy hall thank you.', '2025-01-03 19:54:24', '2025-01-03 11:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_admin`
--

CREATE TABLE `tbl_sms_admin` (
  `id` int(11) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `send_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_resi`
--

CREATE TABLE `tbl_sms_resi` (
  `id` int(11) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `send_time` datetime DEFAULT NULL,
  `resident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sms_resi`
--

INSERT INTO `tbl_sms_resi` (`id`, `contact`, `message`, `send_time`, `resident_id`) VALUES
(5, '09663367020', 'Information: Certificate Request, Date: 2025-01-04, Description: A new certificate request has been submitted by Julius Paul Marcial for the purpose of For Employment..', '2025-01-04 16:42:22', 380);

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
-- Indexes for table `tbl_sms`
--
ALTER TABLE `tbl_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sms_admin`
--
ALTER TABLE `tbl_sms_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sms_resi`
--
ALTER TABLE `tbl_sms_resi`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `tbl_cert`
--
ALTER TABLE `tbl_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_certificates`
--
ALTER TABLE `tbl_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_info`
--
ALTER TABLE `tbl_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbl_off`
--
ALTER TABLE `tbl_off`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `tbl_offi`
--
ALTER TABLE `tbl_offi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_resi`
--
ALTER TABLE `tbl_resi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=392;

--
-- AUTO_INCREMENT for table `tbl_sms`
--
ALTER TABLE `tbl_sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_sms_admin`
--
ALTER TABLE `tbl_sms_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_sms_resi`
--
ALTER TABLE `tbl_sms_resi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
