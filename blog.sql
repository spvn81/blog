-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2022 at 09:37 AM
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
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` text DEFAULT NULL,
  `properties` text DEFAULT NULL,
  `causer_id` varchar(255) DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `album_thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `menu_id`, `name`, `slug`, `link`, `description`, `album_thumbnail`, `created_at`, `updated_at`) VALUES
(14, 91, 'hello gallery', 'hello gallery', 'hello-gallery', 'hello gallery', 'gallery/s5LQNLAMsRgJvxhGa16RVuDZWwqie2ukYjJhXna7.jpg', '2022-06-19 07:34:43', '2022-06-19 07:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `app_infos`
--

CREATE TABLE `app_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_title` tinyint(1) DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_logo` tinyint(1) DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_page_ink` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_map` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_infos`
--

INSERT INTO `app_infos` (`id`, `app_name`, `title`, `show_title`, `sub_title`, `app_url`, `logo`, `show_logo`, `favicon`, `created_at`, `updated_at`, `description`, `about_page_ink`, `keywords`, `google_map`, `address`, `email`, `phone`) VALUES
(1, 'blog', 'my blog', 1, NULL, 'https://www.example.com', 'appInfo/yuHIiUkcf5NBjbbofjS2lFn9zG1m0eHZLueOloy9.png', NULL, 'appInfo/EL4SoLZbyo1DZMQtEgwGsa6RBmxyAmbFXNebkCcL.png', '2022-02-04 17:39:19', '2022-06-19 07:19:49', 'Description', 'https://example.com/about-me', 'Keywords', NULL, '<li><span class=\"icon fa fa-map-marker\"></span><span class=\"text\">Address</span></li>', 'info@email.com', '0000000000');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `categories` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_home` tinyint(1) DEFAULT 0,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `categories`, `categories_slug`, `link`, `category_image`, `description`, `keywords`, `is_home`, `type`, `status`, `created_at`, `updated_at`) VALUES
(90, 134, 'category one', 'category one', 'category-one', NULL, 'about yourself', 'about yourself', 1, 'post', 1, '2022-05-03 04:01:03', '2022-06-19 07:13:57'),
(91, 134, 'gallery', 'gallery', 'gallery', NULL, NULL, NULL, NULL, 'gallery', 1, '2022-05-03 05:55:28', '2022-05-11 06:12:51'),
(92, 134, 'about us', 'about us', 'about-us', NULL, NULL, NULL, NULL, 'post', 1, '2022-05-04 05:36:14', '2022-05-11 06:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `category_has_posts`
--

CREATE TABLE `category_has_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_has_posts`
--

INSERT INTO `category_has_posts` (`id`, `category_id`, `post_id`, `updated_at`, `created_at`) VALUES
(232, 90, 54, '2022-06-19 07:21:33', '2022-06-19 07:21:33'),
(233, 90, 55, '2022-06-19 07:22:20', '2022-06-19 07:22:20'),
(234, 92, 55, '2022-06-19 07:22:20', '2022-06-19 07:22:20'),
(235, 90, 56, '2022-06-19 07:23:29', '2022-06-19 07:23:29'),
(236, 90, 57, '2022-06-19 07:24:21', '2022-06-19 07:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `category_types`
--

CREATE TABLE `category_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_types`
--

INSERT INTO `category_types` (`id`, `category_type`, `created_at`, `updated_at`) VALUES
(1, 'main_menu', '2022-05-11 06:27:49', '2022-05-11 06:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) DEFAULT NULL,
  `read_status` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_configurations`
--

CREATE TABLE `email_configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encryption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_configurations`
--

INSERT INTO `email_configurations` (`id`, `user_id`, `driver`, `host`, `port`, `encryption`, `user_name`, `password`, `sender_name`, `sender_email`, `created_at`, `updated_at`) VALUES
(1, 134, 'SMTP', 'smtp.gmail.com', '465', 'SSL', 'user@gmail.com', 'password', 'sender name', 'senderemail@gmail.com', '2022-03-06 13:51:07', '2022-06-19 07:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `footers`
--

CREATE TABLE `footers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `footer_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footers`
--

INSERT INTO `footers` (`id`, `footer_description`, `copyright_message`, `created_at`, `updated_at`) VALUES
(1, 'About', 'All rights reserved | Developed by<a href=\"\" target=\"_blank\" style=\"\"> spvn81</a>', '2022-03-11 07:26:57', '2022-06-19 07:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_links_title`
--

CREATE TABLE `footer_links_title` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links_title`
--

INSERT INTO `footer_links_title` (`id`, `title`, `created_at`, `updated_at`) VALUES
(5, 'link ine', '2022-03-12 05:00:01', '2022-03-12 05:00:01'),
(6, 'Recent Courses', '2022-03-12 05:07:48', '2022-03-12 05:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `home_banners`
--

CREATE TABLE `home_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '_self',
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_banners`
--

INSERT INTO `home_banners` (`id`, `description`, `banner`, `alt_name`, `link`, `target`, `status`, `created_at`, `updated_at`) VALUES
(12, '<span style=\"font-family: &quot;EB Garamond&quot;, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; text-transform: none;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.</span>', 'banners/JJyzT1vmLYz1PTyWPK0ZrRTyXfrpP0kRT7EOoEAK.jpg', NULL, NULL, '_blank', 1, '2022-06-19 07:33:44', '2022-06-19 07:33:44'),
(13, '<span style=\"font-family: &quot;EB Garamond&quot;, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; text-transform: none;\">ll the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</span>', 'banners/N8FLZsr5dB8U0v3tLkGt5bNr09yQAIS3yC1siMGj.jpg', NULL, NULL, '_blank', 1, '2022-06-19 07:34:05', '2022-06-19 07:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `title`, `description`, `button_name`, `link`, `order`, `created_at`, `updated_at`) VALUES
(2, 'Lorem ipsum is placeholder text commonly', '<h2 class=\"mb-4\" style=\"font-weight: 600; line-height: 1.4; font-size: 34px; font-family: Poppins, Arial, sans-serif; text-transform: none;\"><em style=\'-webkit-tap-highlight-color: rgba(0, 0, 0, 0); color: rgb(255, 255, 255); font-family: \"Quarto A\", \"Quarto B\", Georgia, Times, \"Times New Roman\", \"Microsoft YaHei New\", \"Microsoft Yahei\", &aring;&frac34;&reg;&egrave;&frac12;&macr;&eacute;&#155;&#133;&eacute;&raquo;&#145;, &aring;&reg;&#139;&auml;&frac12;&#147;, SimSun, STXihei, &aring;&#141;&#142;&aelig;&#150;&#135;&ccedil;&raquo;&#134;&eacute;&raquo;&#145;, serif; font-size: 47px; letter-spacing: 1.175px; background-color: rgb(85, 98, 113);\'>Lorem ipsum</em><span style=\'color: rgb(255, 255, 255); font-family: \"Quarto A\", \"Quarto B\", Georgia, Times, \"Times New Roman\", \"Microsoft YaHei New\", \"Microsoft Yahei\", &aring;&frac34;&reg;&egrave;&frac12;&macr;&eacute;&#155;&#133;&eacute;&raquo;&#145;, &aring;&reg;&#139;&auml;&frac12;&#147;, SimSun, STXihei, &aring;&#141;&#142;&aelig;&#150;&#135;&ccedil;&raquo;&#134;&eacute;&raquo;&#145;, serif; font-size: 47px; letter-spacing: 1.175px; background-color: rgb(85, 98, 113);\'>&nbsp;is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups</span><p style=\"color: rgb(153, 153, 153); font-family: Poppins, Arial, sans-serif; text-transform: none; line-height: 1;\"><span style=\'color: rgb(123, 136, 152); font-family: \"Mercury SSm A\", \"Mercury SSm B\", Georgia, Times, \"Times New Roman\", \"Microsoft YaHei New\", \"Microsoft Yahei\", &aring;&frac34;&reg;&egrave;&frac12;&macr;&eacute;&#155;&#133;&eacute;&raquo;&#145;, &aring;&reg;&#139;&auml;&frac12;&#147;, SimSun, STXihei, &aring;&#141;&#142;&aelig;&#150;&#135;&ccedil;&raquo;&#134;&eacute;&raquo;&#145;, serif; font-size: 26px; font-weight: 400; background-color: rgb(85, 98, 113);\'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br></p></h2>\n', NULL, NULL, 1, '2022-03-11 06:09:34', '2022-06-19 07:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `media_files`
--

CREATE TABLE `media_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `album_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_dir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_files`
--

INSERT INTO `media_files` (`id`, `album_id`, `file_name`, `file_dir`, `file_type`, `video_thumbnail`, `alt_name`, `created_at`, `updated_at`) VALUES
(210, 14, 'gallery/s5LQNLAMsRgJvxhGa16RVuDZWwqie2ukYjJhXna7.jpg', NULL, 'image', NULL, 'abstract-series-13-1529920', '2022-06-19 07:34:51', '2022-06-19 07:34:51'),
(211, 14, 'gallery/2u5mPiHF4yHMBwZWNvKCKVZwl2vVmjiVZkUFQzEc.jpg', NULL, 'image', NULL, 'colorful-umbrella-1176220', '2022-06-19 07:34:52', '2022-06-19 07:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE `menuitems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`id`, `title`, `name`, `slug`, `type`, `target`, `menu_id`, `created_at`, `updated_at`) VALUES
(7, 'culture', NULL, 'culture', 'category', NULL, 3, '2022-04-26 08:58:15', NULL),
(8, 'business', NULL, 'business data', 'category', NULL, 3, '2022-04-26 08:58:15', NULL),
(9, 'lifestyle', NULL, 'lifestyle', 'category', NULL, 3, '2022-04-26 08:58:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `menu_type` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `location`, `content`, `menu_type`, `status`, `created_at`, `updated_at`) VALUES
(3, 'head', NULL, NULL, NULL, NULL, '2022-04-26 08:57:36', '2022-04-26 08:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2022_04_23_163628_create_comments_table', 1),
(4, '2017_08_11_073824_create_menus_wp_table', 2),
(5, '2017_08_11_074006_create_menu_items_wp_table', 2),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(7, '2022_04_25_150615_create_replays_table', 3),
(8, '2022_04_27_131042_create_views_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 100),
(3, 'App\\Models\\User', 134),
(9, 'App\\Models\\User', 92),
(9, 'App\\Models\\User', 98),
(9, 'App\\Models\\User', 99),
(9, 'App\\Models\\User', 101),
(9, 'App\\Models\\User', 102),
(9, 'App\\Models\\User', 103),
(9, 'App\\Models\\User', 104),
(9, 'App\\Models\\User', 106),
(9, 'App\\Models\\User', 115),
(9, 'App\\Models\\User', 118),
(9, 'App\\Models\\User', 119),
(9, 'App\\Models\\User', 120),
(9, 'App\\Models\\User', 121),
(9, 'App\\Models\\User', 124);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_device` int(11) NOT NULL COMMENT '1=mobile_number,2=email',
  `otp_expired` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'dashboard', 'web', '2022-02-09 22:47:47', '2022-02-09 22:47:47'),
(19, 'categories', 'web', '2022-02-10 05:29:40', '2022-02-10 05:29:40'),
(20, 'edit_categories', 'web', '2022-02-10 05:30:02', '2022-02-10 05:30:02'),
(21, 'delete_categories', 'web', '2022-02-10 05:30:22', '2022-02-10 05:30:22'),
(22, 'categories_update_status', 'web', '2022-02-10 05:30:55', '2022-02-10 05:30:55'),
(24, 'create_class', 'web', '2022-02-10 05:52:23', '2022-02-10 05:52:23'),
(25, 'online_classes_edit', 'web', '2022-02-10 05:52:59', '2022-02-10 05:52:59'),
(28, 'users', 'web', '2022-02-10 05:54:31', '2022-02-10 05:54:31'),
(29, 'create_users', 'web', '2022-02-10 05:54:49', '2022-02-10 05:54:49'),
(30, 'update_user', 'web', '2022-02-10 05:54:59', '2022-02-10 05:54:59'),
(31, 'delete_user', 'web', '2022-02-10 05:55:11', '2022-02-10 05:55:11'),
(32, 'roles_and_permissions', 'web', '2022-02-10 05:56:06', '2022-02-10 05:56:06'),
(33, 'create_roles', 'web', '2022-02-10 05:56:37', '2022-02-11 17:06:25'),
(34, 'permissions', 'web', '2022-02-10 05:56:53', '2022-02-10 05:56:53'),
(35, 'edit_permissions', 'web', '2022-02-10 05:59:15', '2022-02-10 05:59:15'),
(36, 'delete_permissions', 'web', '2022-02-10 05:59:22', '2022-02-10 05:59:22'),
(37, 'update_permissions', 'web', '2022-02-10 05:59:35', '2022-02-10 05:59:35'),
(38, 'edit_roles', 'web', '2022-02-10 06:00:16', '2022-02-11 16:54:32'),
(39, 'delete_roles', 'web', '2022-02-10 06:00:36', '2022-02-11 16:55:32'),
(40, 'top_navigation_part', 'web', '2022-02-11 09:17:10', '2022-02-11 09:17:10'),
(41, 'left_side_navigation', 'web', '2022-02-11 09:17:51', '2022-02-11 09:17:51'),
(42, 'footer', 'web', '2022-02-11 09:18:05', '2022-02-11 09:18:05'),
(44, 'web_site', 'web', '2022-02-12 11:40:45', '2022-02-12 11:42:36'),
(55, 'upload_media', 'web', '2022-02-16 12:20:14', '2022-02-16 12:20:14'),
(56, 'create_page', 'web', '2022-02-23 06:23:18', '2022-02-23 06:23:18'),
(57, 'create_menu', 'web', '2022-02-23 06:24:28', '2022-02-23 06:24:28'),
(58, 'menu', 'web', '2022-02-23 06:38:11', '2022-02-23 06:38:11'),
(59, 'edit_menu', 'web', '2022-02-23 06:52:48', '2022-02-23 06:52:48'),
(60, 'delete_menu', 'web', '2022-02-23 07:40:42', '2022-02-23 07:40:42'),
(72, 'manage_page', 'web', '2022-03-04 03:17:46', '2022-03-04 03:17:46'),
(73, 'manage_banner', 'web', '2022-03-05 08:45:05', '2022-03-05 08:45:05'),
(74, 'settings', 'web', '2022-03-06 08:48:55', '2022-03-06 08:48:55'),
(75, 'app_settings', 'web', '2022-03-06 08:51:31', '2022-03-06 08:51:31'),
(76, 'email_configs', 'web', '2022-03-06 11:01:45', '2022-03-06 11:01:45'),
(78, 'manage_home', 'web', '2022-03-11 04:54:39', '2022-03-11 04:54:39'),
(79, 'manage_footer', 'web', '2022-03-11 06:50:34', '2022-03-11 06:50:34'),
(90, 'user_comments', 'web', '2022-04-25 10:53:38', '2022-04-25 10:53:38'),
(91, 'file_manager', 'web', '2022-05-11 04:37:48', '2022-05-11 04:37:48');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_view_counts`
--

CREATE TABLE `post_view_counts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `count` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `replays`
--

CREATE TABLE `replays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'super_admin', 'web', '2022-02-11 07:10:42', '2022-02-11 07:10:42'),
(9, 'user', 'web', '2022-02-11 14:43:48', '2022-02-11 14:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 3),
(19, 3),
(19, 9),
(20, 3),
(21, 3),
(22, 3),
(24, 3),
(25, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(40, 9),
(41, 3),
(42, 3),
(42, 9),
(43, 9),
(44, 3),
(50, 9),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(68, 9),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(78, 3),
(79, 3),
(90, 3),
(91, 3);

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fount_awesome_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `fount_awesome_class`, `link`, `created_at`, `updated_at`) VALUES
(2, 'bi bi-facebook', 'https://facebook.com', '2022-03-13 11:24:36', '2022-04-26 11:36:41'),
(3, 'bi bi-instagram', 'https://www.instagram.com/?hl=en', '2022-03-13 11:25:18', '2022-05-04 04:42:28'),
(5, 'bi bi-youtube', 'https://youtube.com', '2022-03-13 11:26:23', '2022-04-26 11:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `static_menus`
--

CREATE TABLE `static_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_parent_id` int(11) DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_data` int(1) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `static_menus`
--

INSERT INTO `static_menus` (`id`, `menu_name`, `menu_slug`, `menu_parent_id`, `link`, `menu_type`, `user_id`, `is_data`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'Home', NULL, '/', 'main_menu', 134, 1, NULL, 1, '2022-05-11 05:11:27', '2022-05-11 10:44:35'),
(3, 'gallery', 'gallery', NULL, 'gallery', 'main_menu', 134, 1, NULL, 1, '2022-05-11 06:29:31', '2022-05-11 06:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `is_email_verified` int(1) DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` int(11) DEFAULT NULL COMMENT '1=active 2=deactivated 3=block',
  `update_email_req` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `social_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `mobile_number`, `email_verified_at`, `mobile_verified_at`, `is_email_verified`, `user_type`, `password`, `remember_token`, `user_status`, `update_email_req`, `created_at`, `updated_at`, `social_id`, `social_type`, `about`) VALUES
(134, 'test author', 'users/i274cltJw9UKQHyYp6JkfWwHyNXbbxwWSztF29N9.jpg', 'superadmin@gmail.com', '9123456780', '2022-06-19 07:17:10', NULL, 1, 'super_admin', '$2y$10$FJ2ip4a4Wlt/8MuXG69DxeSNg7LpIa9WN77dzWFey7hQOM9/xCGHG', NULL, 1, NULL, '2022-04-28 09:50:38', '2022-06-19 07:17:10', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_create_data`
--

CREATE TABLE `user_create_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id_created_by` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_request` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_create_data`
--

INSERT INTO `user_create_data` (`id`, `user_id_created_by`, `role`, `email_request`, `created_user_id`, `created_at`, `updated_at`) VALUES
(1, 'self', '3', NULL, 70, '2022-02-08 07:16:02', '2022-02-08 07:16:02'),
(2, 'self', '3', NULL, 71, '2022-02-08 09:00:17', '2022-02-08 09:00:17'),
(3, 'self', '3', NULL, 72, '2022-02-08 09:55:32', '2022-02-08 09:55:32'),
(4, '1', '0', 'no', 73, '2022-02-08 10:03:33', '2022-02-08 10:03:33'),
(5, '1', '0', 'no', 74, '2022-02-08 10:06:19', '2022-02-08 10:06:19'),
(6, '1', '1', NULL, 75, '2022-02-08 10:17:42', '2022-02-08 10:17:42'),
(7, 'self', '3', NULL, 76, '2022-02-08 10:19:52', '2022-02-08 10:19:52'),
(8, 'self', '3', NULL, 77, '2022-02-08 10:27:34', '2022-02-08 10:27:34'),
(9, 'self', '3', NULL, 78, '2022-02-08 10:28:51', '2022-02-08 10:28:51'),
(10, 'self', '3', NULL, 79, '2022-02-08 10:29:41', '2022-02-08 10:29:41'),
(11, 'self', '3', NULL, 80, '2022-02-08 10:30:26', '2022-02-08 10:30:26'),
(12, 'self', '3', NULL, 81, '2022-02-08 10:31:48', '2022-02-08 10:31:48'),
(13, 'self', '3', NULL, 82, '2022-02-08 10:32:21', '2022-02-08 10:32:21'),
(14, 'self', '3', NULL, 83, '2022-02-08 10:33:31', '2022-02-08 10:33:31'),
(15, 'self', '3', NULL, 84, '2022-02-08 10:34:34', '2022-02-08 10:34:34'),
(16, 'self', '3', NULL, 85, '2022-02-08 10:40:12', '2022-02-08 10:40:12'),
(17, 'self', '3', NULL, 86, '2022-02-08 10:43:04', '2022-02-08 10:43:04'),
(18, 'self', '3', NULL, 87, '2022-02-08 10:44:05', '2022-02-08 10:44:05'),
(19, 'self', '3', NULL, 88, '2022-02-08 10:45:41', '2022-02-08 10:45:41'),
(20, 'self', '3', NULL, 89, '2022-02-08 10:47:00', '2022-02-08 10:47:00'),
(21, '1', '1', NULL, 90, '2022-02-08 10:54:13', '2022-02-08 10:54:13'),
(22, '1', '1', NULL, 91, '2022-02-08 10:55:58', '2022-02-08 10:55:58'),
(23, '1', '1', 'no', 92, '2022-02-08 10:59:47', '2022-02-08 10:59:47'),
(24, '1', '1', NULL, 93, '2022-02-08 11:38:27', '2022-02-08 11:38:27'),
(25, '1', '1', 'no', 94, '2022-02-08 17:54:25', '2022-02-08 17:54:25'),
(26, '1', '1', NULL, 94, '2022-02-08 18:08:50', '2022-02-08 18:08:50'),
(27, '1', '1', 'no', 94, '2022-02-08 18:10:03', '2022-02-08 18:10:03'),
(28, '1', '2', 'no', 93, '2022-02-09 04:40:47', '2022-02-09 04:40:47'),
(29, '1', '2', 'no', 93, '2022-02-09 04:40:58', '2022-02-09 04:40:58'),
(30, '1', '1', 'no', 91, '2022-02-09 05:04:41', '2022-02-09 05:04:41'),
(31, '1', '2', 'no', 93, '2022-02-09 05:05:07', '2022-02-09 05:05:07'),
(32, '1', '1', 'no', 1, '2022-02-09 05:08:48', '2022-02-09 05:08:48'),
(33, 'self', '3', NULL, 95, '2022-02-09 05:10:11', '2022-02-09 05:10:11'),
(34, 'self', '3', NULL, 96, '2022-02-09 05:32:07', '2022-02-09 05:32:07'),
(35, 'self', '3', NULL, 97, '2022-02-09 06:14:39', '2022-02-09 06:14:39'),
(36, 'self', '3', NULL, 98, '2022-02-09 09:03:56', '2022-02-09 09:03:56'),
(37, '1', 'super_adminss', 'no', 1, '2022-02-11 08:40:03', '2022-02-11 08:40:03'),
(38, '1', 'super_admin', 'no', 1, '2022-02-11 08:44:22', '2022-02-11 08:44:22'),
(39, '1', 'writer', 'no', 97, '2022-02-11 08:46:27', '2022-02-11 08:46:27'),
(40, '1', 'writer', 'no', 97, '2022-02-11 08:46:42', '2022-02-11 08:46:42'),
(41, '1', 'user', 'no', 97, '2022-02-11 09:12:10', '2022-02-11 09:12:10'),
(42, '1', 'user', 'no', 92, '2022-02-11 11:41:03', '2022-02-11 11:41:03'),
(43, '1', 'user', 'no', 97, '2022-02-11 11:43:31', '2022-02-11 11:43:31'),
(44, '1', 'user', 'no', 99, '2022-02-11 14:44:34', '2022-02-11 14:44:34'),
(45, '1', 'super_admin', 'no', 100, '2022-02-11 16:38:09', '2022-02-11 16:38:09'),
(46, '1', 'user', 'no', 98, '2022-02-11 16:41:17', '2022-02-11 16:41:17'),
(47, '98', 'user', 'no', 97, '2022-02-11 16:42:44', '2022-02-11 16:42:44'),
(48, '98', 'user', 'no', 99, '2022-02-11 16:43:23', '2022-02-11 16:43:23'),
(49, '98', 'user', 'no', 99, '2022-02-11 16:43:41', '2022-02-11 16:43:41'),
(50, '1', 'user', 'no', 98, '2022-02-11 17:14:26', '2022-02-11 17:14:26'),
(51, '98', 'user', 'no', 99, '2022-02-11 17:16:21', '2022-02-11 17:16:21'),
(52, 'self', 'user', NULL, 101, '2022-02-12 09:34:44', '2022-02-12 09:34:44'),
(53, 'self', 'user', NULL, 102, '2022-02-12 09:40:30', '2022-02-12 09:40:30'),
(54, 'self', 'user', NULL, 103, '2022-02-12 09:59:28', '2022-02-12 09:59:28'),
(55, 'self', 'user', NULL, 104, '2022-02-12 10:03:13', '2022-02-12 10:03:13'),
(56, '1', 'super_admin', 'no', 1, '2022-02-13 13:03:16', '2022-02-13 13:03:16'),
(57, '1', 'user', 'no', 92, '2022-02-13 13:03:47', '2022-02-13 13:03:47'),
(58, '1', 'user', 'no', 92, '2022-02-13 13:20:56', '2022-02-13 13:20:56'),
(59, '1', 'user', 'no', 92, '2022-02-13 13:22:23', '2022-02-13 13:22:23'),
(60, '1', 'user', 'no', 97, '2022-02-13 13:26:04', '2022-02-13 13:26:04'),
(61, '1', 'user', 'no', 92, '2022-02-13 13:28:01', '2022-02-13 13:28:01'),
(62, '1', 'user', 'no', 92, '2022-02-13 14:28:49', '2022-02-13 14:28:49'),
(63, '1', 'user', 'no', 92, '2022-02-13 14:30:41', '2022-02-13 14:30:41'),
(64, '1', 'user', 'no', 92, '2022-02-13 14:31:23', '2022-02-13 14:31:23'),
(65, '1', 'user', 'no', 92, '2022-02-13 14:31:44', '2022-02-13 14:31:44'),
(66, '1', 'user', 'no', 92, '2022-02-13 14:33:38', '2022-02-13 14:33:38'),
(67, '1', 'user', 'no', 92, '2022-02-13 14:35:49', '2022-02-13 14:35:49'),
(68, '1', 'super_admin', 'no', 1, '2022-02-14 10:16:35', '2022-02-14 10:16:35'),
(69, '1', 'super_admin', 'no', 1, '2022-02-14 10:51:41', '2022-02-14 10:51:41'),
(70, '1', 'super_admin', 'no', 1, '2022-02-14 17:25:44', '2022-02-14 17:25:44'),
(71, '1', 'super_admin', 'no', 1, '2022-02-14 17:35:36', '2022-02-14 17:35:36'),
(72, '1', 'user', 'no', 103, '2022-02-16 08:02:36', '2022-02-16 08:02:36'),
(73, '1', 'super_admin', 'no', 1, '2022-02-16 08:04:32', '2022-02-16 08:04:32'),
(74, '1', 'super_admin', 'no', 1, '2022-02-16 08:06:53', '2022-02-16 08:06:53'),
(75, 'self', 'user', NULL, 105, '2022-02-25 11:09:27', '2022-02-25 11:09:27'),
(76, 'self', 'user', NULL, 106, '2022-02-25 11:39:32', '2022-02-25 11:39:32'),
(77, 'self', 'user', NULL, 107, '2022-02-25 11:53:46', '2022-02-25 11:53:46'),
(78, 'self', 'user', NULL, 115, '2022-02-26 06:06:51', '2022-02-26 06:06:51'),
(79, '1', 'user', 'no', 119, '2022-02-26 07:36:00', '2022-02-26 07:36:00'),
(80, '1', 'user', 'no', 118, '2022-02-26 07:36:45', '2022-02-26 07:36:45'),
(81, 'self', 'user', NULL, 124, '2022-02-26 10:35:35', '2022-02-26 10:35:35'),
(82, 'self', 'user', NULL, 125, '2022-02-26 10:38:50', '2022-02-26 10:38:50'),
(83, '123', 'super_admin', 'no', 123, '2022-02-28 09:41:30', '2022-02-28 09:41:30'),
(84, '123', 'super_admin', 'no', 123, '2022-02-28 10:04:44', '2022-02-28 10:04:44'),
(85, 'self', 'user', NULL, 130, '2022-03-07 09:50:38', '2022-03-07 09:50:38'),
(86, '123', 'super_admin', 'no', 97, '2022-03-10 05:17:04', '2022-03-10 05:17:04'),
(87, '123', 'super_admin', 'no', 123, '2022-03-10 05:19:08', '2022-03-10 05:19:08'),
(88, '123', 'super_admin', 'no', 97, '2022-03-10 06:20:17', '2022-03-10 06:20:17'),
(89, 'updated_by_user', 'user', NULL, 105, '2022-03-10 06:28:53', '2022-03-10 06:28:53'),
(90, 'self', 'user', NULL, 128, '2022-03-12 06:49:57', '2022-03-12 06:49:57'),
(91, '123', 'super_admin', 'no', 128, '2022-03-12 06:51:35', '2022-03-12 06:51:35'),
(92, 'self', 'user', NULL, 129, '2022-03-12 08:39:34', '2022-03-12 08:39:34'),
(93, '123', 'user', 'no', 127, '2022-03-17 04:06:52', '2022-03-17 04:06:52'),
(94, '123', 'super_admin', 'no', 131, '2022-03-22 10:41:50', '2022-03-22 10:41:50'),
(95, '123', 'user', 'no', 131, '2022-03-30 07:31:47', '2022-03-30 07:31:47'),
(96, '123', 'user', 'no', 131, '2022-03-30 07:32:06', '2022-03-30 07:32:06'),
(97, '123', 'super_admin', 'no', 131, '2022-03-30 11:42:40', '2022-03-30 11:42:40'),
(98, '123', 'user', 'no', 131, '2022-03-30 11:42:55', '2022-03-30 11:42:55'),
(99, '123', 'user', 'no', 131, '2022-03-30 11:44:25', '2022-03-30 11:44:25'),
(100, '123', 'super_admin', 'no', 131, '2022-03-30 11:44:40', '2022-03-30 11:44:40'),
(101, '123', 'user', 'no', 131, '2022-03-30 11:45:00', '2022-03-30 11:45:00'),
(102, '123', 'user', 'no', 131, '2022-03-30 11:47:47', '2022-03-30 11:47:47'),
(103, '123', 'user', 'no', 131, '2022-03-30 11:48:07', '2022-03-30 11:48:07'),
(104, '123', 'user', 'no', 131, '2022-03-30 11:48:22', '2022-03-30 11:48:22'),
(105, '123', 'user', 'no', 131, '2022-03-30 11:52:19', '2022-03-30 11:52:19'),
(106, '123', 'user', 'no', 131, '2022-03-30 11:57:20', '2022-03-30 11:57:20'),
(107, '123', 'user', 'no', 131, '2022-03-30 11:59:44', '2022-03-30 11:59:44'),
(108, '123', 'super_admin', 'no', 131, '2022-03-30 12:00:08', '2022-03-30 12:00:08'),
(109, '123', 'super_admin', 'no', 131, '2022-03-30 12:07:43', '2022-03-30 12:07:43'),
(110, '123', 'user', 'no', 131, '2022-03-30 12:08:07', '2022-03-30 12:08:07'),
(111, '123', 'super_admin', 'no', 128, '2022-04-27 07:24:48', '2022-04-27 07:24:48'),
(112, '123', 'super_admin', NULL, 123, '2022-04-28 07:24:29', '2022-04-28 07:24:29'),
(113, '123', 'super_admin', NULL, 123, '2022-04-28 07:24:32', '2022-04-28 07:24:32'),
(114, '123', 'super_admin', 'no', 123, '2022-04-28 07:24:36', '2022-04-28 07:24:36'),
(115, '123', 'super_admin', 'no', 134, '2022-04-28 09:50:38', '2022-04-28 09:50:38'),
(116, '123', 'super_admin', 'no', 123, '2022-05-03 03:58:12', '2022-05-03 03:58:12'),
(117, '123', 'super_admin', 'no', 123, '2022-05-03 04:21:24', '2022-05-03 04:21:24'),
(118, '123', 'super_admin', 'no', 134, '2022-05-03 05:35:23', '2022-05-03 05:35:23'),
(119, '134', 'super_admin', 'no', 134, '2022-06-19 07:17:10', '2022-06-19 07:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `viewable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewable_id` bigint(20) UNSIGNED NOT NULL,
  `visitor` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `viewable_type`, `viewable_id`, `visitor`, `collection`, `viewed_at`) VALUES
(420, 'App\\Models\\webPage', 55, 'N6EPa32AwjEnr6z7CHNT8Sded0BCQAihk5cJLm3R3TywtbtJHAU0cnFK7M2VCGgmX34eUAMoTyn87cnT', NULL, '2022-06-19 07:22:38'),
(421, 'App\\Models\\webPage', 57, 'N6EPa32AwjEnr6z7CHNT8Sded0BCQAihk5cJLm3R3TywtbtJHAU0cnFK7M2VCGgmX34eUAMoTyn87cnT', NULL, '2022-06-19 07:29:23'),
(422, 'App\\Models\\webPage', 57, 'N6EPa32AwjEnr6z7CHNT8Sded0BCQAihk5cJLm3R3TywtbtJHAU0cnFK7M2VCGgmX34eUAMoTyn87cnT', NULL, '2022-06-19 07:29:23');

-- --------------------------------------------------------

--
-- Table structure for table `web_pages`
--

CREATE TABLE `web_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `page_name` text NOT NULL,
  `slug` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `page_title` text NOT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `page_description` longtext NOT NULL,
  `small_description` text NOT NULL,
  `post_keywords` text DEFAULT NULL,
  `published_author_id` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `post_views_count` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_pages`
--

INSERT INTO `web_pages` (`id`, `user_id`, `category_id`, `page_name`, `slug`, `link`, `page_title`, `main_image`, `page_description`, `small_description`, `post_keywords`, `published_author_id`, `status`, `post_views_count`, `is_deleted`, `created_at`, `updated_at`) VALUES
(54, 134, NULL, 'What is Lorem Ipsum?', 'What is Lorem Ipsum', 'what-is-lorem-ipsum', 'What is Lorem Ipsum?', NULL, '<h1>What is Lorem Ipsum?</h1><p><br><strong>Lorem Ipsum</strong><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it', 134, 1, NULL, NULL, '2022-06-19 07:21:33', '2022-06-19 07:21:33'),
(55, 134, NULL, 'Why do we use it?', 'Why do we use it', 'why-do-we-use-it', 'Why do we use it?', NULL, '<h1>Why do we use it?</h1><p style=\"text-align:justify;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><br>&nbsp;</p>', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 134, 1, NULL, NULL, '2022-06-19 07:22:20', '2022-06-19 07:22:20'),
(56, 134, NULL, 'Where does it come from?', 'Where does it come from', 'where-does-it-come-from', 'Where does it come from?', NULL, '<h1>Where does it come from?</h1><p><br>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p><br>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><br>&nbsp;</p>', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 134, 1, NULL, NULL, '2022-06-19 07:23:29', '2022-06-19 07:23:29'),
(57, 134, NULL, 'Where can I get some?', 'Where can I get some', 'where-can-i-get-some', 'Where can I get some?', NULL, '<h1>Where can I get some?</h1><p><br>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><p><br>&nbsp;</p>', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a', 134, 1, NULL, NULL, '2022-06-19 07:24:21', '2022-06-19 07:24:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_infos`
--
ALTER TABLE `app_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category_has_posts`
--
ALTER TABLE `category_has_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `category_types`
--
ALTER TABLE `category_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `email_configurations`
--
ALTER TABLE `email_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `footers`
--
ALTER TABLE `footers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_links_ibfk_1` (`title_id`);

--
-- Indexes for table `footer_links_title`
--
ALTER TABLE `footer_links_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_banners`
--
ALTER TABLE `home_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`) USING BTREE;

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`) USING BTREE;

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`);

--
-- Indexes for table `post_view_counts`
--
ALTER TABLE `post_view_counts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replays`
--
ALTER TABLE `replays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_menus`
--
ALTER TABLE `static_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_create_data`
--
ALTER TABLE `user_create_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_pages`
--
ALTER TABLE `web_pages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `app_infos`
--
ALTER TABLE `app_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `category_has_posts`
--
ALTER TABLE `category_has_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `category_types`
--
ALTER TABLE `category_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `email_configurations`
--
ALTER TABLE `email_configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `footers`
--
ALTER TABLE `footers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_links_title`
--
ALTER TABLE `footer_links_title`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `home_banners`
--
ALTER TABLE `home_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_view_counts`
--
ALTER TABLE `post_view_counts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `replays`
--
ALTER TABLE `replays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `static_menus`
--
ALTER TABLE `static_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `user_create_data`
--
ALTER TABLE `user_create_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT for table `web_pages`
--
ALTER TABLE `web_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_has_posts`
--
ALTER TABLE `category_has_posts`
  ADD CONSTRAINT `category_has_posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_has_posts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `web_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `web_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD CONSTRAINT `footer_links_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `footer_links_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `replays`
--
ALTER TABLE `replays`
  ADD CONSTRAINT `replays_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
