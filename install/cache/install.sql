-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2017 at 11:01 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `author_name` (`author_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `book_copies` int(50) NOT NULL,
  `book_pub` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `digital_file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `isbn` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isbn_13` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(40) NOT NULL,
  `copyright_year` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `date_receive` date NOT NULL,
  `date_added` datetime NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `custom_fields` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `isbn_2` (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `book_authors`
--

CREATE TABLE IF NOT EXISTS `book_authors` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `book_id` int(100) NOT NULL,
  `author_id` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE IF NOT EXISTS `book_categories` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `book_id` int(100) NOT NULL,
  `category_id` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE IF NOT EXISTS `borrow` (
  `borrow_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(50) NOT NULL,
  `date_borrow` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `due_date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`borrow_id`),
  KEY `borrowerid` (`member_id`),
  KEY `borrowid` (`borrow_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `borrowdetails`
--

CREATE TABLE IF NOT EXISTS `borrowdetails` (
  `borrow_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `borrow_status` enum('pending','returned','lost','') COLLATE utf8_unicode_ci NOT NULL,
  `fine` decimal(6,2) DEFAULT NULL,
  `price_lost_book` decimal(6,2) DEFAULT NULL,
  `date_return` datetime DEFAULT NULL,
  PRIMARY KEY (`borrow_details_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`id`),
  UNIQUE KEY `category_name` (`category_name`),
  KEY `classid` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(5) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `name`, `type_id`) VALUES
(1, 'Class 1', 1),
(2, 'Class 2', 1),
(3, 'Class 3', 1),
(4, 'Class 4', 1),
(5, 'Class 5', 1),
(6, 'Class 6', 1),
(7, 'Class 7', 1),
(8, 'Class 8', 1),
(9, 'Olevel', 1),
(10, 'Alevel', 1),
(11, 'IT', 3),
(12, 'Junior Teacher', 2),
(13, 'Senior Teacher', 2),
(14, 'Accountant', 3),
(15, 'Guest', 4);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `member_types`
--

CREATE TABLE IF NOT EXISTS `member_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `borrowertype` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fine` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `issue_limit_books` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `issue_limit_day` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `member_types`
--

INSERT INTO `member_types` (`type_id`, `borrowertype`, `fine`, `issue_limit_books`, `issue_limit_day`) VALUES
(1, 'Student', '', '10', '10'),
(2, 'Instructional', '', '0', '0'),
(3, 'Management', '', '10', '10'),
(4, 'Guest', '', '10', '10');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `books-index` tinyint(1) DEFAULT '0',
  `books-add` tinyint(1) DEFAULT '0',
  `books-edit` tinyint(1) DEFAULT '0',
  `books-delete` tinyint(1) DEFAULT '0',
  `books-read` tinyint(1) DEFAULT '0',
  `books-getBookDetails` tinyint(1) DEFAULT '0',
  `books-import_csv` tinyint(1) DEFAULT '0',
  `book-print_barcodes` tinyint(1) NOT NULL DEFAULT '0',
  `settings-index` tinyint(1) DEFAULT '0',
  `issued-index` tinyint(1) DEFAULT '0',
  `books-categories` tinyint(1) DEFAULT '0',
  `books-authors` tinyint(1) DEFAULT '0',
  `borrow-index` tinyint(1) DEFAULT '0',
  `borrow-bookreturn` tinyint(1) DEFAULT '0',
  `borrow-borrowed` tinyint(1) DEFAULT '0',
  `settings-sms` tinyint(1) DEFAULT '0',
  `settings-list_db` tinyint(1) DEFAULT '0',
  `settings-backup_db` tinyint(1) DEFAULT '0',
  `settings-restore_db` tinyint(1) DEFAULT '0',
  `settings-remove_db` tinyint(1) DEFAULT '0',
  `auth-index` tinyint(1) DEFAULT '0',
  `auth-create_user` tinyint(1) DEFAULT '0',
  `auth-groups` tinyint(1) DEFAULT '0',
  `auth-edit_group` tinyint(1) DEFAULT '0',
  `auth-member_types` tinyint(1) DEFAULT '0',
  `auth-occupations` tinyint(1) DEFAULT '0',
  `reports-index` tinyint(1) DEFAULT '0',
  `reports-quick_inventory` tinyint(1) DEFAULT '0',
  `delayed-index` tinyint(1) NOT NULL DEFAULT '0',
  `delayed-due_books_json` tinyint(1) NOT NULL DEFAULT '0',
  `delayed-email_templates` tinyint(1) NOT NULL DEFAULT '0',
  `delayed-notify_delayed` tinyint(1) NOT NULL DEFAULT '0',
  `request-index` tinyint(1) NOT NULL,
  `request-add_requested_books` tinyint(1) NOT NULL,
  `request-delete_request` tinyint(1) NOT NULL,
  `request-edit_request` tinyint(1) NOT NULL,
  `requested_books-index` tinyint(1) NOT NULL,
  `requested_books-email_templates` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group_id`, `books-index`, `books-add`, `books-edit`, `books-delete`, `books-read`, `books-getBookDetails`, `books-import_csv`, `book-print_barcodes`, `settings-index`, `issued-index`, `books-categories`, `books-authors`, `borrow-index`, `borrow-bookreturn`, `borrow-borrowed`, `settings-sms`, `settings-list_db`, `settings-backup_db`, `settings-restore_db`, `settings-remove_db`, `auth-index`, `auth-create_user`, `auth-groups`, `auth-edit_group`, `auth-member_types`, `auth-occupations`, `reports-index`, `reports-quick_inventory`, `delayed-index`, `delayed-due_books_json`, `delayed-email_templates`, `delayed-notify_delayed`, `request-index`, `request-add_requested_books`, `request-delete_request`, `request-edit_request`, `requested_books-index`, `requested_books-email_templates`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1),
(2, 2, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requested_books`
--

CREATE TABLE IF NOT EXISTS `requested_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_title` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `author_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `remarks` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `section_id` int(50) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'G'),
(8, 'H'),
(9, 'I'),
(10, 'J'),
(11, 'K'),
(12, 'L'),
(13, 'M'),
(14, 'N'),
(15, 'O'),
(16, 'P'),
(17, 'Q'),
(18, 'R'),
(19, 'S'),
(20, 'T'),
(21, 'U'),
(22, 'V'),
(23, 'W'),
(24, 'X'),
(25, 'Y'),
(26, 'Z');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `issue_conf` int(1) NOT NULL COMMENT 'By Member Types: 2, System-Wide:1',
  `fine` int(10) NOT NULL,
  `issue_limit_days` int(10) NOT NULL,
  `issue_limit_books` int(10) NOT NULL,
  `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `toggle_rtl` tinyint(1) NOT NULL DEFAULT '0',
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `favicon` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title_small` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `terms_conditions` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `books_custom_fields` longtext COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '25',
  `version` decimal(6,2) DEFAULT NULL,
  `issue_limit_days_extendable` tinyint(1) NOT NULL,
  `notify_delayed_no_days_limit_toggle` tinyint(1) NOT NULL,
  `email_request` tinyint(1) NOT NULL,
  `sms_request` tinyint(1) NOT NULL,
  `front_per_page` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `issue_conf`, `fine`, `issue_limit_days`, `issue_limit_books`, `language`, `toggle_rtl`, `currency`, `email`, `logo`, `favicon`, `address`, `phone`, `title_small`, `terms_conditions`, `books_custom_fields`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `version`, `issue_limit_days_extendable`, `notify_delayed_no_days_limit_toggle`, `email_request`, `sms_request`, `front_per_page`) VALUES
(1, 'Open Library Management System', 2, 50, 10, 10, 'english', 0, 'USD', 'uskhan099@gmail.com', '0c3b1741b8fdb5abe04dd94ed84d0ca1.png', '2645b06c18cb7089f7fa63b8de49e127.ico', '1-A1, Gulberg III, Lahore', '123467890', 'LMS', '<ul>\r\n <li><strong>All copyright, trade marks, design rights,</strong> patents and other intellectual property rights (registered and unregistered) in and on LMS Online Services and LMS Content belong to the LMS and/or third parties (which may include you or other users.)</li>\r\n <li>The LMS reserves all of its rights in LMS Content and LMS Online Services. Nothing in the Terms grants you a right or licence to use any trade mark, design right or copyright owned or controlled by the LMS or any other third party except as expressly provided in the Terms.</li>\r\n</ul>', 'Book Pages', 'ssl://smtp.gmail.com', '2312456789@gmail.com', 'password', '465', 2.30, 1, 0, 1, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE IF NOT EXISTS `sms_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_gateway` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auth_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auth_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `api_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `sms_gateway`, `auth_id`, `auth_token`, `api_id`, `phone_number`) VALUES
(1, 'nexmo', '2132456', '2345', '12345', '+123245');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Other','') COLLATE utf8_unicode_ci NOT NULL,
  `member_unique_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `gender`, `member_unique_id`, `type_id`, `class_id`, `section`, `image`, `address`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1485018643, 1, 'Admin', 'Admin', 'ADMIN', '0', 'Male', '14707643131136', 1, 1, 'A', 'no_image.png', 'afs'),
(2, '10.0.2.2', 'member', '$2y$08$m/U9GokO/ucb2zR1qolGvOHJ9rZBPerD67Bry/WGCDT3E5uCPvp92', NULL, 'member@member.com', NULL, NULL, NULL, NULL, 1470680101, 1485014852, 1, 'Student', '2', 'OTS', '09876543', 'Male', '14719715091102', 1, 2, '', 'be4bcb5a784d2b831dfaae08bca4071f.jpg', 'Canada, Pak');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
