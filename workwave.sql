-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 01:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workwave`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `name`, `parent_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Finance & Accounting', NULL, 'Handles all financial operations.', '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(2, 'Human Resources', NULL, 'Responsible for workforce management.', '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(3, 'Information Technology', NULL, 'Manages the organization\'s technology.', '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(4, 'Marketing & Communications', NULL, 'Develops and implements strategies to promote the organization.', '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(5, 'PHP Developer', 3, 'Designing and building web applications.', '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(6, 'Mobile Marketing', 4, 'Handles mobile marketing for the operation.', '2025-04-09 20:53:23', '2025-04-09 20:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/profile_pictures/default.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `user_id`, `department_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `position`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'Nevin', 'Guni', 'nevinguni@yahoo.com', '0693414567', 'Ali Demi,Tirane', 'Intern', 'uploads/profile_pictures/67f82b45984a0.jpg', '2025-04-09 20:53:23', '2025-04-10 18:34:13'),
(2, 3, 1, 'Kevin', 'Dushku', 'kevindushku@gmail.com', '0683131845', 'Komuna Parisit,Tirane', 'Financial Analyst', 'uploads/profile_pictures/67f82b377082f.jpg', '2025-04-09 20:53:23', '2025-04-10 18:33:59'),
(3, 4, 4, 'Antonio', 'Agolli', 'antoniagolli@gmail.com', '0682131345', 'Don Bosko,Tirane', 'Marketing Manager', 'uploads/profile_pictures/67f82b4f4ecfb.jpg', '2025-04-09 20:53:23', '2025-04-10 18:34:23'),
(4, 5, 2, 'Sara', 'Komani', 'sarakomani@gmail.com', '0681313567', 'Astir,Tirane', 'HR Manager', 'uploads/profile_pictures/67f82b59e6ecd.jpg', '2025-04-09 20:53:23', '2025-04-10 18:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `message`, `timestamp`) VALUES
(1, 1, 'abc', '2025-04-11 21:46:12'),
(2, 1, 'hey', '2025-04-11 21:46:23'),
(3, 1, 'heyhe', '2025-04-11 21:46:26'),
(4, 1, 'hey', '2025-04-11 21:46:31'),
(5, 1, 'hey', '2025-04-11 21:46:34'),
(6, 1, 'hey', '2025-04-11 21:46:35'),
(7, 1, 'hey', '2025-04-11 21:46:36'),
(8, 1, 'hey', '2025-04-11 21:46:37'),
(9, 1, 'hey', '2025-04-11 21:46:38'),
(10, 1, 'hey', '2025-04-11 21:46:39'),
(11, 1, 'hey', '2025-04-11 21:46:40'),
(12, 1, 'hey', '2025-04-11 21:46:40'),
(13, 1, 'hey', '2025-04-11 21:46:49'),
(14, 1, 'hey', '2025-04-11 21:46:50'),
(15, 1, 'hey', '2025-04-11 21:46:51'),
(16, 1, 'hey', '2025-04-11 21:46:52'),
(17, 1, 'hey', '2025-04-11 21:46:52'),
(18, 1, 'hey', '2025-04-11 21:46:57'),
(19, 1, 'hey', '2025-04-11 21:46:58'),
(20, 1, 'hey', '2025-04-11 21:46:59'),
(21, 1, 'hey', '2025-04-11 21:47:03'),
(22, 1, 'hey', '2025-04-11 21:50:07'),
(23, 1, '\\', '2025-04-11 21:57:28'),
(24, 2, 'hey', '2025-04-11 22:12:27'),
(25, 2, 'ab', '2025-04-11 22:12:29'),
(26, 2, 'hey', '2025-04-11 22:15:45'),
(27, 2, 'hey', '2025-04-11 22:19:25'),
(28, 2, 'he', '2025-04-11 22:20:59'),
(29, 2, 'adada', '2025-04-11 22:22:33'),
(30, 2, 'hey', '2025-04-11 22:35:08'),
(31, 2, 'ye', '2025-04-11 22:52:08'),
(32, 1, 'hey', '2025-04-12 15:25:22'),
(33, 1, 'hello', '2025-04-12 15:28:24'),
(34, 1, 'hey', '2025-04-12 15:28:32'),
(35, 1, 'hey', '2025-04-12 15:29:19'),
(36, 1, 'hey', '2025-04-12 15:33:15'),
(37, 1, 'hey', '2025-04-12 15:33:27'),
(38, 1, 'hey', '2025-04-12 15:33:45'),
(39, 1, 'hey', '2025-04-12 15:37:21'),
(40, 1, 'aaacacac', '2025-04-12 15:37:33'),
(41, 1, 'acacaca', '2025-04-12 15:37:35'),
(42, 1, 'cacacaca', '2025-04-12 15:37:37'),
(43, 1, 'acaca', '2025-04-12 15:38:11'),
(44, 1, 'cacac', '2025-04-12 15:38:13'),
(45, 1, 'caca', '2025-04-12 15:38:14'),
(46, 1, 'acacacaca', '2025-04-12 15:38:16'),
(47, 1, 'cacaca', '2025-04-12 15:38:25'),
(48, 1, 'caacaca', '2025-04-12 15:38:27'),
(49, 1, 'cacacacac', '2025-04-12 15:38:28'),
(50, 1, 'cacacacaca', '2025-04-12 15:38:30'),
(51, 1, 'caca', '2025-04-12 15:40:00'),
(52, 1, 'adada', '2025-04-12 15:42:31'),
(53, 1, 'aaaaa', '2025-04-12 15:42:39'),
(54, 1, 'aaaaaaaaa', '2025-04-12 15:42:40'),
(55, 1, 'aaaaaaaaaaa', '2025-04-12 15:42:42'),
(56, 1, 'aaaaaaaaaaaaaaaaaaaaaa', '2025-04-12 15:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employee','admin') NOT NULL DEFAULT 'employee',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin1234', 'admin', NULL, '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(2, 'nevin.guni', 'Welcome123', 'employee', NULL, '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(3, 'kevin.dushku', 'kevin123', 'employee', NULL, '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(4, 'antonio.agolli', 'Welcome123', 'employee', NULL, '2025-04-09 20:53:23', '2025-04-09 20:53:23'),
(5, 'sara.komani', 'Welcome123', 'employee', NULL, '2025-04-09 20:53:23', '2025-04-09 20:53:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `departments_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
