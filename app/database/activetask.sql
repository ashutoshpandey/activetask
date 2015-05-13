-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.20 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-05-06 09:11:49
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for activetask
CREATE DATABASE IF NOT EXISTS `activetask` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `activetask`;


-- Dumping structure for table activetask.group_members
CREATE TABLE IF NOT EXISTS `group_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `group_members_user_id_foreign` (`user_id`),
  KEY `group_members_group_id_foreign` (`group_id`),
  CONSTRAINT `group_members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.group_members: ~1 rows (approximately)
/*!40000 ALTER TABLE `group_members` DISABLE KEYS */;
INSERT INTO `group_members` (`id`, `group_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 14, 'pending', '2015-05-05 01:41:52', '2015-05-05 02:18:23');
/*!40000 ALTER TABLE `group_members` ENABLE KEYS */;


-- Dumping structure for table activetask.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.migrations: ~6 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2015_04_03_050040_create_user_table', 1),
	('2015_04_07_051038_create_usergroup_table', 1),
	('2015_05_03_045229_create_tasks_table', 1),
	('2015_05_03_045421_create_taskitem_table', 1),
	('2015_05_03_045437_create_taskcomment_table', 1),
	('2015_05_03_052354_create_groupmembers_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Dumping structure for table activetask.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `task_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `others_can_add` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tasks_user_id_foreign` (`user_id`),
  KEY `tasks_group_id_foreign` (`group_id`),
  CONSTRAINT `tasks_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.tasks: ~2 rows (approximately)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `user_id`, `group_id`, `name`, `task_type`, `others_can_add`, `description`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
	(5, 14, NULL, '22-22', 'fixed', 'n', 'abc', '2015-05-03 09:00:00', '2015-05-05 09:00:00', 'active', '2015-05-03 15:36:02', '2015-05-03 15:36:02'),
	(6, 14, NULL, '2255', 'fixed', 'n', 'abcde', '2015-05-03 09:00:00', '2015-05-05 09:00:00', 'active', '2015-05-03 15:36:12', '2015-05-03 15:39:50');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;


-- Dumping structure for table activetask.task_comments
CREATE TABLE IF NOT EXISTS `task_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `task_comments_user_id_foreign` (`user_id`),
  CONSTRAINT `task_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.task_comments: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_comments` ENABLE KEYS */;


-- Dumping structure for table activetask.task_items
CREATE TABLE IF NOT EXISTS `task_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT 'assigned to',
  `content` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `assigned_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assigned_to_id` int(11) DEFAULT NULL COMMENT 'if user from list is selected',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `task_items_task_id_foreign` (`task_id`),
  KEY `task_items_user_id_foreign` (`user_id`),
  CONSTRAINT `task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.task_items: ~1 rows (approximately)
/*!40000 ALTER TABLE `task_items` DISABLE KEYS */;
INSERT INTO `task_items` (`id`, `task_id`, `user_id`, `content`, `assigned_to`, `assigned_to_id`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
	(11, 5, 14, 'abc', 'self', NULL, '2015-01-01 02:30:00', '2015-03-03 02:30:00', 'active', '2015-05-04 01:19:08', '2015-05-04 01:19:08');
/*!40000 ALTER TABLE `task_items` ENABLE KEYS */;


-- Dumping structure for table activetask.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `activation_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `display_name`, `email`, `phone`, `password`, `gender`, `country`, `status`, `activation_code`, `created_at`, `updated_at`) VALUES
	(14, 'Ashutosh', 'Pandey', 'a', 'ashutosh.options4u@gmail.com', '', 'a', 'male', 'India', 'active', 'AT1430666693214', '2015-05-03 03:24:53', '2015-05-03 03:24:53');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table activetask.user_groups
CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_groups_user_id_foreign` (`user_id`),
  CONSTRAINT `user_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table activetask.user_groups: ~1 rows (approximately)
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` (`id`, `user_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
	(1, 14, 'abc', 'active', '2015-05-04 17:27:46', '2015-05-04 17:27:46');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
