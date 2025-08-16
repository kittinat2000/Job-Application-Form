-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2025 at 03:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jaf_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`) VALUES
(1, 'สาขาที่ 1 - อ่อนนุช'),
(2, 'สาขาที่ 2 - บางนา'),
(3, 'สาขาที่ 3 - สาธุ');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `work_permit_path` varchar(255) DEFAULT NULL,
  `passport_path` varchar(255) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `wp_book_path` varchar(255) DEFAULT NULL,
  `work_accept_path` varchar(255) DEFAULT NULL,
  `notice_file_path55` varchar(255) DEFAULT NULL,
  `notice_file_path52` varchar(255) DEFAULT NULL,
  `pink_card_front_path` varchar(255) DEFAULT NULL,
  `pink_card_back_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nationality` enum('Thai','Foreign') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `branch_id`, `action_type`, `emp_code`, `first_name`, `last_name`, `photo_path`, `work_permit_path`, `passport_path`, `receipt_path`, `wp_book_path`, `work_accept_path`, `notice_file_path55`, `notice_file_path52`, `pink_card_front_path`, `pink_card_back_path`, `created_at`, `nationality`) VALUES
(1, 2, 'MOU', '456456', 'กกกก', 'กกกกกก', '1755193073_S__4546597.jpg', '../uploads/1755193073_miracleplanet-transparent-white.png', '20250814_200720-456456-3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '20250814_200812-456456-10.jpg', '2025-08-14 17:37:53', 'Thai'),
(2, 1, '', '4646888', 'กกกกกกฟ', 'ฟหกหฟกฟกหฟ', '20250814_214859-4646888-1.jpg', '20250814_214859-4646888-2.jpg', '20250814_214859-4646888-3.jpg', '20250814_214859-4646888-4.jpg', '20250814_214859-4646888-5.jpg', NULL, NULL, NULL, NULL, NULL, '2025-08-14 19:48:59', 'Thai'),
(3, 1, 'หัวหน้า', '5646889', 'กิตตินัฐ', 'กองาม', '20250816_135844-5646889-1.jpg', '20250816_135844-5646889-2.jpg', '20250816_135844-5646889-3.png', '20250816_135844-5646889-4.png', '20250816_135844-5646889-5.jpg', NULL, NULL, NULL, NULL, NULL, '2025-08-16 11:58:44', 'Thai'),
(4, 3, 'เปลี่ยนนายจ้าง', '6878768', 'Kittinat', 'Kor-ngam', '20250816_140234-6878768-1.jpg', '20250816_140234-6878768-2.jpg', '20250816_140234-6878768-3.jpg', '20250816_140234-6878768-4.jpg', '20250816_140234-6878768-5.jpg', '20250816_140234-6878768-6.jpg', '20250816_140234-6878768-7.jpg', '20250816_140234-6878768-8.jpg', '20250816_140234-6878768-9.jpg', '20250816_140234-6878768-10.jpg', '2025-08-16 12:02:34', 'Foreign');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `action_desc` text NOT NULL,
  `done_by` varchar(100) NOT NULL,
  `done_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'admin', '$2y$10$s9DMj7z1pqwA2Tzfk9ILB.fOpCrULdAFLRqfo2CbWgIiOJCNRBhYC', 'admin', '2025-08-14 16:54:06'),
(3, 'user', '$2y$10$fxVx21vXmy2fWe35haGRe.wlQTHHOgSdw8EoH.JR6JAH/20PCCqMy', 'user', '2025-08-14 16:54:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_name` (`branch_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
