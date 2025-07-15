-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for check_stock
CREATE DATABASE IF NOT EXISTS `check_stock` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `check_stock`;

-- Dumping structure for table check_stock.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.cache: ~0 rows (approximately)
DELETE FROM `cache`;

-- Dumping structure for table check_stock.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table check_stock.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table check_stock.fg
CREATE TABLE IF NOT EXISTS `fg` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pallet` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `box_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `checked` bit(1) DEFAULT b'0',
  `month_stock` int DEFAULT NULL,
  `year_stock` int DEFAULT NULL,
  `date_checked` datetime DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=718 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.fg: ~22 rows (approximately)
DELETE FROM `fg`;
INSERT INTO `fg` (`id`, `pallet`, `box_no`, `part`, `description`, `bin`, `qty`, `checked`, `month_stock`, `year_stock`, `date_checked`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(676, 'A240627049', 'A2406140360', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:24:55', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:24:55'),
	(677, 'A240627050', 'A2406140371', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'E12', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(678, 'A240705001', 'A24071400003', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D6', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(679, 'A240705001', 'A24071400004', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D6', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(680, 'A240705001', 'A24071400005', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D6', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(681, 'A240705001', 'A24071400006', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D6', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(682, 'A240705001', 'A24071400007', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D6', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(683, 'A240705001', 'A24071400008', 'FG-A40BL40SR-42THN', 'COUNT 40 BL 40 ENDS (S)', 'D6', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(684, 'A240627051', 'A2406140380', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:25:04', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:25:04'),
	(685, 'A240627051', 'A2406140381', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:30:26', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:30:26'),
	(686, 'A240627051', 'A2406140382', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:34:41', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:34:41'),
	(687, 'A240627051', 'A2406140383', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:34:54', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:34:54'),
	(688, 'A240627051', 'A2406140384', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:35:29', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:35:29'),
	(689, 'A240627051', 'A2406140385', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'1', 7, 2024, '2024-11-18 15:37:23', 'watcharaphong', 'watcharaphong', '2024-11-18 08:24:28', '2024-11-18 15:37:23'),
	(690, 'A240627051', 'A2406140386', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(691, 'A240627051', 'A2406140387', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(692, 'A240627051', 'A2406140388', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(693, 'A240627051', 'A2406140389', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(694, 'A240627051', 'A2406140390', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(695, 'A240627051', 'A2406140392', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(696, 'A240627051', 'A2406140394', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(697, 'A240627051', 'A2406140395', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(698, 'A240627051', 'A2406140397', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(699, 'A240627053', 'A2406140422', 'FG-A44BL40SR-42THN', 'COUNT 44 BL 40 ENDS (S)', 'D7', 42, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(700, 'A240702060', 'A24070300649', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(701, 'A240702060', 'A24070300650', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(702, 'A240702060', 'A24070300651', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(703, 'A240702060', 'A24070300652', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(704, 'A240702060', 'A24070300653', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(705, 'A240702060', 'A24070300654', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(706, 'A240702060', 'A24070300655', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(707, 'A240702060', 'A24070300656', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(708, 'A240702060', 'A24070300657', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(709, 'A240702060', 'A24070300658', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(710, 'A240702060', 'A24070300659', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(711, 'A240702060', 'A24070300660', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(712, 'A240702060', 'A24070300661', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(713, 'A240702060', 'A24070300662', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(714, 'A240702060', 'A24070300663', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(715, 'A240702060', 'A24070300664', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(716, 'A240702060', 'A24070300665', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL),
	(717, 'A240702060', 'A24070300666', 'FG-A55SW48MD-44HVN', 'COUNT 55 SW 48 ENDS (H)', 'D6', 44, b'0', 7, 2024, NULL, 'watcharaphong', NULL, '2024-11-18 08:24:28', NULL);

-- Dumping structure for table check_stock.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table check_stock.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table check_stock.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1);

-- Dumping structure for table check_stock.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table check_stock.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.sessions: ~1 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('L3CxebSdaO9DPcfj416oGI2G3NgEOSNuQD1cjCOe', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTTF4aTRZNVVjZ0o3b0QwYkZUTXl2VDdZUHBOeEgzWGJjTFZXYndWOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3Q6OTk5OS9jaGVja19zdG9jay9wdWJsaWMvZm9ybV9zY2FuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo0OiJ1c2VyIjthOjc6e3M6ODoidXNlcm5hbWUiO3M6MTM6IndhdGNoYXJhcGhvbmciO3M6NToiZW1wbm8iO3M6NDoiMzA5MSI7czo0OiJuYW1lIjtzOjEzOiJXYXRjaGFyYXBob25nIjtzOjc6InN1cm5hbWUiO3M6MTE6IlBoaW1waGF0aGFtIjtzOjg6IjFzdXJuYW1lIjtzOjI6IlAuIjtzOjEwOiJkZXBhcnRtZW50IjtzOjQ6IkQwMDUiO3M6NToibGV2ZWwiO3M6NToiQWRtaW4iO31zOjEwOiJkZXBhcnRtZW50IjthOjE6e3M6MTU6ImRlcGFydG1lbnRfbmFtZSI7czo1MToi4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Liq4Liy4Lij4Liq4LiZ4LmA4LiX4LioIjt9fQ==', 1731919493);

-- Dumping structure for table check_stock.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table check_stock.users: ~0 rows (approximately)
DELETE FROM `users`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
