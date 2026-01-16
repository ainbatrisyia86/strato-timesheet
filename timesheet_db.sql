-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 09:42 AM
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
-- Database: `timesheet_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_26_075033_create_timesheets_table', 1),
(5, '2025_12_05_031126_create_timesheet_rows_table', 1),
(6, '2025_12_10_085328_update_timesheets_table', 1),
(7, '2025_12_10_085631_create_timesheet_rows_table', 1),
(8, '2025_12_19_030500_add_remember_token_to_users_table', 1),
(9, '2025_12_19_031221_add_remember_token_to_users_table', 1),
(10, '2025_12_23_040144_add_start_and_end_date_to_timesheets_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('alissa.mazlan@tresdata.net', '$2y$12$bpOdFS0AhAs2chfr7I8wue4pyhnip3wcxdlIHlv8RXNmGZjh5Zg76', '2025-12-23 20:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Project A', '2026-01-10 15:14:20', '2026-01-10 15:28:45'),
(2, 'Project B', '2026-01-10 15:14:20', '2026-01-10 15:28:54'),
(3, 'Project C', '2026-01-10 15:14:20', '2026-01-10 15:28:59'),
(4, 'Project GIS', '2026-01-10 15:24:30', '2026-01-10 15:29:05'),
(5, 'Others', '2026-01-10 15:26:48', '2026-01-10 15:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YgNeuFdXIwuU2PphMIoBKCxf0eYHtsCy8YLsUrYN', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic2kzSjhyT09RMjVwanF3VHh2VWV3dE45cHZ2Q3E1cVNsd2JNTlNUNSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdGltZXNoZWV0cyI7czo1OiJyb3V0ZSI7czoxNToidGltZXNoZWV0LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1768537195);

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `week` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `submitted_at` datetime DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `user_id`, `start_date`, `end_date`, `week`, `month`, `year`, `status`, `submitted_at`, `project_id`) VALUES
(1, 1, '2025-12-22', '2025-12-26', 52, '12', 2025, 'open', NULL, NULL),
(2, 2, '2025-12-22', '2025-12-26', 52, '12', 2025, 'open', NULL, NULL),
(3, 4, '2025-12-22', '2025-12-26', 52, '12', 2025, 'open', NULL, NULL),
(4, 5, '2025-12-22', '2025-12-26', 52, '12', 2025, 'open', NULL, NULL),
(7, 1, '2025-12-29', '2026-01-02', 1, '12', 2025, 'open', NULL, NULL),
(8, 5, '2025-12-29', '2026-01-02', 1, '12', 2025, 'open', NULL, NULL),
(9, 1, '2026-01-05', '2026-01-09', 2, '1', 2026, 'open', NULL, NULL),
(15, 12, '2025-12-29', '2026-01-02', 1, 'December', 2025, 'submitted', '2026-01-10 14:50:59', NULL),
(19, 12, '2026-01-05', '2026-01-11', 2, 'January', 2026, 'submitted', '2026-01-10 14:47:10', NULL),
(20, 12, '2025-12-22', '2025-12-28', 52, 'December', 2026, 'submitted', '2026-01-12 02:09:29', NULL),
(23, 12, '2026-01-12', '2026-01-18', 3, 'January', 2026, 'open', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timesheet_rows`
--

CREATE TABLE `timesheet_rows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timesheet_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `project` varchar(255) NOT NULL,
  `task` text NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_hours` decimal(5,2) DEFAULT 0.00,
  `project_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheet_rows`
--

INSERT INTO `timesheet_rows` (`id`, `timesheet_id`, `date`, `project`, `task`, `start_time`, `end_time`, `total_hours`, `project_id`) VALUES
(2, 4, '2025-12-22', 'Project A', 'website', '08:44:00', '23:44:00', 0.00, NULL),
(9, 7, '2025-12-29', 'Project A', 'Continued coding for the Timesheet System', '08:58:00', '18:03:00', 0.00, NULL),
(10, 7, '2025-12-30', 'Project B', 'coding', '08:27:00', '18:00:00', 0.00, NULL),
(11, 7, '2025-12-30', 'Project C', 'coding', '09:28:00', '18:28:00', 0.00, NULL),
(23, 9, '2026-01-05', 'Project A', 'website', '09:00:00', '14:00:00', 5.00, NULL),
(24, 9, '2026-01-05', 'Project B', 'apps', '14:00:00', '18:00:00', 4.00, NULL),
(25, 9, '2026-01-06', 'Project B', 'coding', '09:00:00', '11:00:00', 2.00, NULL),
(26, 9, '2026-01-05', 'Project A', 'figma', '23:00:00', '15:00:00', 0.00, NULL),
(27, 9, '2026-01-05', 'Project C', 'design', '15:00:00', '18:00:00', 3.00, NULL),
(95, 19, '2026-01-05', 'Project A', 'test status', '14:44:00', '18:44:00', 4.00, NULL),
(96, 15, '2025-12-29', 'Project A', 'input mysql', '09:39:33', '17:39:33', 8.00, NULL),
(108, 20, '2025-12-22', 'Project B', 'c', '17:19:00', '18:19:00', 1.00, NULL),
(109, 20, '2025-12-23', 'Project B', 'x', '12:21:00', '13:21:00', 1.00, NULL),
(110, 20, '2025-12-24', 'Project B', 'e', '23:46:00', '17:41:00', 0.00, NULL),
(515, 23, '2026-01-12', 'Project A', 'testing #1', '05:26:00', '17:26:00', 12.00, NULL),
(516, 23, '2026-01-12', 'Project B', 'testing #4', '16:33:00', '18:33:00', 2.00, NULL),
(517, 23, '2026-01-12', 'Project GIS', 'test baru #1', '19:44:00', '21:44:00', 2.00, NULL),
(518, 23, '2026-01-13', 'Project A', 'testing #2', '14:31:00', '17:31:00', 3.00, NULL),
(519, 23, '2026-01-14', 'Project GIS', 'testing #3', '16:31:00', '17:31:00', 1.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'staff',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `department`, `position`, `role`, `email_verified_at`, `password`, `remember_token`) VALUES
(1, 'Alissa', 'alissa@strato.com', 'IT', 'Intern', 'staff', NULL, '$2y$12$TNYcZ5MrMCs2m8B5vgfnj.gJWd4KTIbdDbAUDxZIaP72F1QbQRPga', 'hV7o66f0oarJR4UmniyuMlymNHNBmVH8fY6haRl5Ev45ibJU29uOZYU7aYCc'),
(2, 'amira', 'amira@strato.com', 'HR', 'Recruiter', 'staff', NULL, '$2y$12$735g0x3A6bDoOpmJVcBULOORCaNq6yqlEgBClDiHaS9TOUls3dZY6', 'fx1Bc8Qno6bjyMSqqpkDyAChBZdHCIDl3hCQbJyxriccWgIGnfbzHCvxkaTN'),
(3, 'aiman', 'aiman@strato.com', 'Finance', 'Executive', 'staff', NULL, '$2y$12$xUZ148wWrcCaXWS7KgENjO1FeV9qRb8igaDAQ3sFQlPLjh57nGSsy', NULL),
(4, 'Puteri Alissa', 'alissa.mazlan@tresdata.net', NULL, NULL, 'staff', NULL, '$2y$12$5SBfsMLqLqRWtuG5jMVmCe1GlO62mAs2QKB9EifBeqUC.Nxg16biq', NULL),
(5, 'Puteri', 'puterialissamazlan@gmail.com', 'IT', 'Manager', 'staff', NULL, '$2y$12$BIZNI9S3Kqs06k6QUylJ1er.v0Ew83Nk0Sl8m838dU4iohuJb1Cie', 'DNSP6VSnrBNRyWmTHLkyFCNs0gdRBldxLlfvpQ9DS08sXG67pQiTCvq9oOuX'),
(12, 'ain', 'ain@strato.com', 'IT', 'IT Intern', 'staff', NULL, '$2y$12$E0mkLr5lY.vCfPAVe9.8MOhxuv/MkFqeBqNUw8UleS/yg6HQobNjO', NULL),
(14, 'batrisyia', 'naureyein@gmail.com', NULL, NULL, 'staff', NULL, '$2y$12$kpwsVu2b5nSMNUGH3bM2V.I72DIm/s4mPZLXKkR7uG1ftA3O8u/Iq', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timesheets_user_id_foreign` (`user_id`),
  ADD KEY `fk_project` (`project_id`);

--
-- Indexes for table `timesheet_rows`
--
ALTER TABLE `timesheet_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timesheet_id` (`timesheet_id`),
  ADD KEY `fk_project` (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `timesheet_rows`
--
ALTER TABLE `timesheet_rows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `timesheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timesheet_rows`
--
ALTER TABLE `timesheet_rows`
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `timesheet_rows_ibfk_1` FOREIGN KEY (`timesheet_id`) REFERENCES `timesheets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
