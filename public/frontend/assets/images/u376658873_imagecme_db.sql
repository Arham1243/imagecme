-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2025 at 05:00 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u376658873_imagecme_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@imagecme.com', '$2y$12$PjCqAMsAgthFmOkV47/SeuctSnKpVMUpfMzVtcNMX7RBAvoariJBC', '2024-12-19 06:45:33', '2024-12-19 06:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `case_type` varchar(191) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_quality` varchar(191) DEFAULT NULL,
  `diagnosis_title` varchar(191) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `diagnosed_disease` varchar(191) DEFAULT NULL,
  `ease_of_diagnosis` varchar(191) DEFAULT NULL,
  `certainty` varchar(191) DEFAULT NULL,
  `ethnicity` varchar(191) DEFAULT NULL,
  `segment` varchar(191) DEFAULT NULL,
  `clinical_examination` text DEFAULT NULL,
  `patient_age` varchar(191) DEFAULT NULL,
  `patient_gender` varchar(191) DEFAULT NULL,
  `patient_socio_economic` varchar(191) DEFAULT NULL,
  `patient_concomitant` varchar(191) DEFAULT NULL,
  `patient_others` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `authors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`authors`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ai_conversation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ai_conversation`)),
  `publish_ai_conversation` tinyint(1) DEFAULT 0,
  `mcq_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`mcq_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `user_id`, `case_type`, `content`, `image_quality`, `diagnosis_title`, `title`, `slug`, `diagnosed_disease`, `ease_of_diagnosis`, `certainty`, `ethnicity`, `segment`, `clinical_examination`, `patient_age`, `patient_gender`, `patient_socio_economic`, `patient_concomitant`, `patient_others`, `status`, `authors`, `created_at`, `updated_at`, `deleted_at`, `ai_conversation`, `publish_ai_conversation`, `mcq_data`) VALUES
(14, 7, 'challenge_image_diagnosis', NULL, 'Medium', 'Tomography', 'Tomography', 'tomography', 'Neurology', 'Difficult', 'Uncertain', 'Asian', 'Adult Male', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '[{\"name\":null,\"doi\":null,\"article_link\":null}]', '2025-01-12 08:42:08', '2025-01-12 08:42:08', NULL, NULL, 0, '[{\"question\":\"Dianose\",\"answers\":[\"abc\",\"xyz\"]}]'),
(15, 8, 'share_image_diagnosis', NULL, 'Medium', 'Pneumonia', 'Chest and Brain', 'chest-and-brain', 'Pulmonology', 'Easy', 'Almost Certain', 'African American', 'Adult Male', NULL, '28', 'Male', NULL, NULL, NULL, 'active', '[{\"name\":null,\"doi\":null,\"article_link\":null}]', '2025-01-13 18:18:49', '2025-01-13 18:18:49', NULL, NULL, 0, NULL),
(16, 8, 'challenge_image_diagnosis', NULL, 'High', 'Pneumonia', 'Challenge Chest and Brain', 'challenge-chest-and-brain', 'Pulmonology', 'Very Difficult', 'Almost Certain', 'Asian', 'Child', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '[{\"name\":\"Xyz\",\"doi\":null,\"article_link\":null}]', '2025-01-13 18:37:50', '2025-01-13 18:37:50', NULL, NULL, 0, '[{\"question\":\"Diagnose chest x ray\",\"answers\":[\"abc\",\"xyz\"]}]'),
(17, 8, 'ask_image_diagnosis', NULL, 'Low', NULL, 'Help me in diagnose', 'help-me-in-diagnose', 'Neurology', 'Very Difficult', NULL, 'Asian', 'Adult Female', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '[{\"name\":null,\"doi\":null,\"article_link\":null}]', '2025-01-13 18:39:13', '2025-01-13 18:39:13', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `case_comments`
--

CREATE TABLE `case_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `selected_answer` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_comment_replies`
--

CREATE TABLE `case_comment_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reply_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_reply_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_images`
--

CREATE TABLE `case_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `path` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_images`
--

INSERT INTO `case_images` (`id`, `case_id`, `name`, `path`, `created_at`, `updated_at`, `type`) VALUES
(42, 16, 'front x ray', 'uploads/User/8/Case/16/images//c13bfe58-b518-434d-b0ea-0949c4fd41c3.jfif', '2025-01-13 18:37:50', '2025-01-13 18:37:50', 1),
(43, 17, 'Brain', 'uploads/User/8/Case/17/images//c2f54892-1aff-40c3-b26d-28d8c17becab.jfif', '2025-01-13 18:39:13', '2025-01-13 18:39:13', 6),
(44, 15, 'chest', 'uploads/User/8/Case/15/images//1f15c145-3f44-413b-a828-2c2426d77054.PNG', '2025-01-14 11:44:37', '2025-01-14 11:44:37', 1),
(45, 16, 'eye', 'uploads/User/8/Case/16/images//c2a70734-7591-4a92-9063-30df25c158fe.jpg', '2025-01-14 11:47:52', '2025-01-14 11:47:52', 14);

-- --------------------------------------------------------

--
-- Table structure for table `case_likes`
--

CREATE TABLE `case_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_likes`
--

INSERT INTO `case_likes` (`id`, `case_id`, `user_id`, `created_at`, `updated_at`) VALUES
(15, 16, 8, '2025-01-14 12:04:39', '2025-01-14 12:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `case_views`
--

CREATE TABLE `case_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_views`
--

INSERT INTO `case_views` (`id`, `case_id`, `user_id`, `created_at`, `updated_at`) VALUES
(7, 16, 8, '2025-01-14 12:04:29', '2025-01-14 12:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flag_type` varchar(191) DEFAULT NULL,
  `flag_value` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `flag_type`, `flag_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '_method', 'POST', 1, '2024-12-19 06:50:55', '2024-12-19 06:50:55'),
(2, 'FACEBOOK', 'https://www.facebook.com/', 1, '2024-12-19 06:50:55', '2024-12-19 06:50:55'),
(3, 'INSTAGRAM', 'https://www.instagram.com/', 1, '2024-12-19 06:50:55', '2024-12-19 06:50:55'),
(4, 'TWITTER', 'https://twitter.com/', 1, '2024-12-19 06:50:55', '2024-12-19 06:50:55'),
(5, 'COMPANYPHONE', '(832) 660-1111', 1, '2024-12-19 06:50:55', '2024-12-19 06:50:55'),
(6, 'COMPANYEMAIL', 'info@imagecme.com', 1, '2024-12-19 06:50:55', '2024-12-19 06:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) DEFAULT NULL,
  `path` varchar(191) DEFAULT NULL,
  `alt_text` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `type`, `path`, `alt_text`, `status`, `created_at`, `updated_at`) VALUES
(1, 'logo', 'uploads/Admin/Logo/633b0684-088c-4efb-8448-a7e7d3d6eca5.png', NULL, 'active', '2024-12-19 09:33:37', '2024-12-19 09:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `image_types`
--

CREATE TABLE `image_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image_types`
--

INSERT INTO `image_types` (`id`, `name`, `slug`, `content`, `featured_image`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'X Ray', 'x-ray', '<p>X Ray</p>', 'uploads/Image-types/Featured-images/cf315f91-ae70-4e7e-a0c6-77cdd35bbe8b.png', 'active', 1, '2025-01-07 08:45:40', '2025-01-07 08:45:40'),
(2, 'CT Scan', 'ct-scan', '<p>CT Scan</p>', 'uploads/Image-types/Featured-images/f1b0fc00-836a-4f14-a547-7733a4a074c2.png', 'active', 1, '2025-01-07 08:45:59', '2025-01-07 08:45:59'),
(3, 'MRI', 'mri', '<p>MRI</p>', 'uploads/Image-types/Featured-images/364d4e52-03fe-42f8-a5a4-2685e2e4f403.png', 'active', 1, '2025-01-07 08:46:14', '2025-01-07 08:46:14'),
(4, 'Ultrasound, Diagnostic', 'ultrasound-diagnostic', '<p>Ultrasound, Diagnostic</p>', 'uploads/Image-types/Featured-images/c01c59a7-4813-48b2-aee9-6293999fde95.png', 'active', 1, '2025-01-07 08:46:32', '2025-01-07 08:46:32'),
(5, 'Mammography', 'mammography', '<p>Mammography</p>', 'uploads/Image-types/Featured-images/553918c3-f7bf-47e6-99db-ae56d4ba9085.jpg', 'active', 1, '2025-01-07 08:46:50', '2025-01-07 08:46:50'),
(6, 'PET Scan', 'pet-scan', '<p>PET Scan</p>', 'uploads/Image-types/Featured-images/2682fa0f-d887-4a29-a9ae-c34fbb1910b9.png', 'active', 1, '2025-01-07 08:47:16', '2025-01-07 08:47:16'),
(7, 'Optical imaging', 'optical-imaging', '<p>Optical imaging</p>', NULL, 'active', 0, '2025-01-07 08:50:18', '2025-01-07 08:50:18'),
(8, 'Fluoroscopy', 'fluoroscopy', '<p>Fluoroscopy</p>', NULL, 'active', 0, '2025-01-07 08:50:28', '2025-01-07 08:50:28'),
(9, 'Ultrasound, Pregnancy', 'ultrasound-pregnancy', '<p>Ultrasound, Pregnancy</p>', NULL, 'active', 0, '2025-01-07 08:50:39', '2025-01-07 08:50:39'),
(10, 'Retinography', 'retinography', '<p>Retinography</p>', NULL, 'active', 0, '2025-01-07 08:50:46', '2025-01-07 08:50:46'),
(11, 'Arthrogram', 'arthrogram', '<p>Arthrogram</p>', NULL, 'active', 0, '2025-01-07 08:50:54', '2025-01-07 08:50:54'),
(12, 'Interventional imaging', 'interventional-imaging', '<p>Interventional imaging</p>', NULL, 'active', 0, '2025-01-07 08:51:05', '2025-01-07 08:51:05'),
(13, 'Histopathology', 'histopathology', '<p>Histopathology</p>', NULL, 'active', 0, '2025-01-07 08:51:14', '2025-01-07 08:51:14'),
(14, '2D', '2d', '<p>2D</p>', 'uploads/Image-types/Featured-images/86a104e3-70bc-4ad7-9e70-b5e9c3d78514.PNG', 'active', 1, '2025-01-07 08:51:21', '2025-01-14 11:52:52'),
(15, '3D', '3d', '<p>3D</p>', NULL, 'active', 0, '2025-01-07 08:51:28', '2025-01-07 08:51:28'),
(16, '4D', '4d', '<p>4D</p>', NULL, 'active', 0, '2025-01-07 08:51:37', '2025-01-07 08:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_07_19_213225_create_admins_table', 1),
(2, '2024_07_19_225803_create_imagetables_table', 1),
(3, '2024_07_20_223400_create_sessions_table', 1),
(4, '2024_07_28_191457_create_configs_table', 1),
(5, '2024_12_17_073142_create_users_table', 1),
(9, '2024_12_18_153046_create_diagnostic_cases_table', 2),
(10, '2024_12_24_025206_create_cases_table', 2),
(11, '2024_12_26_211636_add_user_id_to_cases_table', 3),
(12, '2024_12_26_224605_create_comments_table', 3),
(13, '2024_12_27_200039_add_ai_conversation_to_cases_table', 4),
(14, '2024_12_29_033705_create_password_resets_table', 5),
(15, '2025_01_02_204602_add_mcq_data_to_cases_table', 6),
(16, '2025_01_03_203656_create_user_mcq_answers_table', 6),
(17, '2025_01_06_161451_add_selected_answer_to_comments_table', 6),
(20, '2025_01_06_135722_create_image_types_table', 7),
(21, '2025_01_06_175557_update_case_images_type_column', 7),
(22, '2025_01_06_192415_create_comment_replies_table', 8),
(23, '2025_01_06_194409_add_parent_reply_to_comment_replies', 8),
(24, '2025_01_07_154826_create_case_likes_table', 9),
(25, '2025_01_07_175656_create_case_views_table', 9),
(26, '2025_01_12_233039_add_title_to_cases_table', 10),
(27, '2025_01_12_233950_rename_comments_and_replies_tables', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('john@gmail.com', '$2y$12$eEmR6MJjbOvhPUWVAkDn4ur0mPZtUiWxrQCKoCI0cZqsc52bFSg7S', '2025-01-08 14:59:50'),
('lmdfidsaxys@yahoo.com', '$2y$12$w1bO3IBVdgilDPwALgUcAeAGz.Wc5I6slZLBfWecQwdpNbOBrnfyG', '2025-01-11 23:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `role` varchar(191) DEFAULT NULL,
  `speciality` varchar(191) DEFAULT NULL,
  `institution_name` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `speciality`, `institution_name`, `country`, `city`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Arham', 'Khan', 'arham404khan@gmail.com', '3349221868', '$2y$12$L37nBv/pHc6Cms1n.a3EUe6SKTtvKuvrFj/py3ZCtufz0E50CuxHC', 'Educationist', 'Endocrinology', 'My Institution', 'Pakistan', 'Minus est sit commo', 'active', '2024-12-27 10:35:25', '2025-01-08 15:00:58'),
(6, 'KSlNSJltvh', 'KuMDcGCkuSoBQNH', 'lmdfidsaxys@yahoo.com', '3065276074', '$2y$12$/GkYsvCb/YAAviU6uWiJKOb9VagSoqovADkSnPFPuoIjzALY0EuWq', 'Other', 'Urology', 'RIsSHRTqsOBLuqJ', 'koCdxgxzfE', 'aeQaKNeZzPLZKt', 'active', '2025-01-11 23:46:24', '2025-01-11 23:46:24'),
(7, 'Sadia', 'Noreen', 'sadianoreen560@gmail.com', '4676787985', '$2y$12$AgUJyF/O1AaCVZIMNmVv4.tI.xDrBSWGNLMc7BGbKG6vhkZUyQqLu', 'Educationist', 'Endocrinology', '0', 'Hungary', 'Karachi', 'active', '2025-01-12 08:13:33', '2025-01-12 08:37:22'),
(8, 'Sadia', 'Noreen', 'sadianoreen301@gmail.com', '4676787985', '$2y$12$lYgoLQFsNxPq.LBd9Bc6FO/3Gtwc6pNGe/uGK0PB/xUVLUjZxId76', 'Student', 'Gastroenterology', '0', 'Sierra Leone', 'Karachi', 'active', '2025-01-13 18:03:06', '2025-01-13 18:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_mcq_answers`
--

CREATE TABLE `user_mcq_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_mcq_answers`
--

INSERT INTO `user_mcq_answers` (`id`, `user_id`, `case_id`, `answer`, `created_at`, `updated_at`) VALUES
(5, 8, 16, 'abc', '2025-01-14 12:04:46', '2025-01-14 12:04:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cases_user_id_foreign` (`user_id`);

--
-- Indexes for table `case_comments`
--
ALTER TABLE `case_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_case_id_foreign` (`case_id`),
  ADD KEY `comments_selected_answer_foreign` (`selected_answer`);

--
-- Indexes for table `case_comment_replies`
--
ALTER TABLE `case_comment_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_replies_case_id_foreign` (`case_id`),
  ADD KEY `comment_replies_comment_id_foreign` (`comment_id`),
  ADD KEY `comment_replies_user_id_foreign` (`user_id`),
  ADD KEY `comment_replies_parent_reply_id_foreign` (`parent_reply_id`);

--
-- Indexes for table `case_images`
--
ALTER TABLE `case_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_images_case_id_foreign` (`case_id`),
  ADD KEY `case_images_type_foreign` (`type`);

--
-- Indexes for table `case_likes`
--
ALTER TABLE `case_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `case_likes_case_id_user_id_unique` (`case_id`,`user_id`),
  ADD KEY `case_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `case_views`
--
ALTER TABLE `case_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_views_case_id_foreign` (`case_id`),
  ADD KEY `case_views_user_id_foreign` (`user_id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_types`
--
ALTER TABLE `image_types`
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
  ADD KEY `password_reset_tokens_email_index` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_mcq_answers`
--
ALTER TABLE `user_mcq_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_mcq_answers_user_id_foreign` (`user_id`),
  ADD KEY `user_mcq_answers_case_id_foreign` (`case_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `case_comments`
--
ALTER TABLE `case_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `case_comment_replies`
--
ALTER TABLE `case_comment_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `case_images`
--
ALTER TABLE `case_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `case_likes`
--
ALTER TABLE `case_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `case_views`
--
ALTER TABLE `case_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `image_types`
--
ALTER TABLE `image_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_mcq_answers`
--
ALTER TABLE `user_mcq_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `case_comments`
--
ALTER TABLE `case_comments`
  ADD CONSTRAINT `comments_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comments_selected_answer_foreign` FOREIGN KEY (`selected_answer`) REFERENCES `user_mcq_answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `case_comment_replies`
--
ALTER TABLE `case_comment_replies`
  ADD CONSTRAINT `comment_replies_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_replies_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `case_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_replies_parent_reply_id_foreign` FOREIGN KEY (`parent_reply_id`) REFERENCES `case_comment_replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_images`
--
ALTER TABLE `case_images`
  ADD CONSTRAINT `case_images_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `case_images_type_foreign` FOREIGN KEY (`type`) REFERENCES `image_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_likes`
--
ALTER TABLE `case_likes`
  ADD CONSTRAINT `case_likes_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `case_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_views`
--
ALTER TABLE `case_views`
  ADD CONSTRAINT `case_views_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `case_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_mcq_answers`
--
ALTER TABLE `user_mcq_answers`
  ADD CONSTRAINT `user_mcq_answers_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_mcq_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
