-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.4.3 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk davibardb
CREATE DATABASE IF NOT EXISTS `davibardb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `davibardb`;

-- membuang struktur untuk table davibardb.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.failed_jobs: ~0 rows (lebih kurang)

-- membuang struktur untuk table davibardb.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.migrations: ~28 rows (lebih kurang)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_08_19_000000_create_failed_jobs_table', 1),
	(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(3, '2022_10_31_061811_create_menu_table', 1),
	(4, '2022_11_01_041110_create_table_role', 1),
	(5, '2022_11_01_083314_create_table_user', 1),
	(6, '2022_11_03_023905_create_table_submenu', 1),
	(7, '2022_11_03_064417_create_tbl_akses', 1),
	(8, '2022_11_08_024215_create_tbl_web', 1),
	(9, '2022_11_15_131148_create_tbl_jenisbarang', 1),
	(10, '2022_11_15_173700_create_tbl_satuan', 1),
	(11, '2022_11_15_180434_create_tbl_merk', 1),
	(12, '2022_11_16_120018_create_tbl_appreance', 1),
	(13, '2022_11_25_141731_create_tbl_barang', 1),
	(14, '2022_11_26_011349_create_tbl_customer', 1),
	(15, '2022_11_28_151108_create_tbl_barangmasuk', 1),
	(16, '2022_11_30_115904_create_tbl_barangkeluar', 1),
	(17, '2024_02_25_101258_create_pesan_models_table', 2),
	(18, '2024_02_25_112835_create_rincian_orders_table', 2),
	(19, '2024_02_26_090130_create_log_activity_table', 3),
	(20, '2024_02_26_101354_create_tbl_pesan_table', 4),
	(21, '2024_03_03_115114_create_tbl_pesan', 5),
	(22, '2024_03_03_115029_create_table_tbl_pesan', 6),
	(23, '2024_03_03_170312_create_tbl_status_order', 6),
	(24, '2024_03_04_164359_create_tbl_status_order', 7),
	(25, '2024_09_05_140248_add_bukti_bayar_to_tbl_status_order', 8),
	(26, '2024_09_05_211045_add_metode_bayar_to_tbl_status_order', 8),
	(27, '2024_09_06_013311_add_bca_to_tbl_web', 8),
	(28, '2024_09_06_023812_add_an_to_tbl_web', 8);

-- membuang struktur untuk table davibardb.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.personal_access_tokens: ~0 rows (lebih kurang)

-- membuang struktur untuk table davibardb.tbl_akses
CREATE TABLE IF NOT EXISTS `tbl_akses` (
  `akses_id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submenu_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othermenu_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `akses_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`akses_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2077 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_akses: ~282 rows (lebih kurang)
INSERT INTO `tbl_akses` (`akses_id`, `menu_id`, `submenu_id`, `othermenu_id`, `role_id`, `akses_type`, `created_at`, `updated_at`) VALUES
	(1012, '1667444041', NULL, NULL, '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1017, '1708489505', NULL, NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1018, '1708489505', NULL, NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1019, '1708489505', NULL, NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1020, '1668509889', NULL, NULL, '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1021, '1668509889', NULL, NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1022, '1668509889', NULL, NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1023, '1668509889', NULL, NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1025, '1669390641', NULL, NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1026, '1669390641', NULL, NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1027, '1669390641', NULL, NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1033, '1668510568', NULL, NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1034, '1668510568', NULL, NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1035, '1668510568', NULL, NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1040, NULL, '21', NULL, '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1041, NULL, '21', NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1042, NULL, '21', NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1043, NULL, '21', NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1045, NULL, '28', NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1046, NULL, '28', NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1047, NULL, '28', NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1052, NULL, '22', NULL, '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1053, NULL, '22', NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1054, NULL, '22', NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1055, NULL, '22', NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1057, NULL, '29', NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1058, NULL, '29', NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1059, NULL, '29', NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1060, NULL, '23', NULL, '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1061, NULL, '23', NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1062, NULL, '23', NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1063, NULL, '23', NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1065, NULL, '30', NULL, '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1066, NULL, '30', NULL, '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1067, NULL, '30', NULL, '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1068, NULL, '31', NULL, '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1073, NULL, NULL, '2', '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1074, NULL, NULL, '3', '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1075, NULL, NULL, '4', '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1076, NULL, NULL, '5', '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1077, NULL, NULL, '6', '3', 'view', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1078, NULL, NULL, '1', '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1079, NULL, NULL, '2', '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1080, NULL, NULL, '3', '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1081, NULL, NULL, '4', '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1082, NULL, NULL, '5', '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1083, NULL, NULL, '6', '3', 'create', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1084, NULL, NULL, '1', '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1085, NULL, NULL, '2', '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1086, NULL, NULL, '3', '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1087, NULL, NULL, '4', '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1088, NULL, NULL, '5', '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1089, NULL, NULL, '6', '3', 'update', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1090, NULL, NULL, '1', '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1091, NULL, NULL, '2', '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1092, NULL, NULL, '3', '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1093, NULL, NULL, '4', '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1094, NULL, NULL, '5', '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1095, NULL, NULL, '6', '3', 'delete', '2024-02-20 22:10:25', '2024-02-20 22:10:25'),
	(1353, '1667444041', NULL, NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1357, '1708489505', NULL, NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1358, '1708489505', NULL, NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1359, '1708489505', NULL, NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1360, '1708489505', NULL, NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1361, '1668509889', NULL, NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1362, '1668509889', NULL, NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1363, '1668509889', NULL, NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1364, '1668509889', NULL, NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1365, '1669390641', NULL, NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1366, '1669390641', NULL, NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1367, '1669390641', NULL, NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1368, '1669390641', NULL, NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1373, '1668510568', NULL, NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1374, '1668510568', NULL, NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1375, '1668510568', NULL, NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1376, '1668510568', NULL, NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1377, NULL, '21', NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1382, NULL, '28', NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1383, NULL, '28', NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1384, NULL, '28', NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1389, NULL, '22', NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1394, NULL, '29', NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1395, NULL, '29', NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1396, NULL, '29', NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1401, NULL, '23', NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1406, NULL, '30', NULL, '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1407, NULL, '30', NULL, '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1408, NULL, '30', NULL, '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1409, NULL, '31', NULL, '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1414, NULL, NULL, '2', '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1415, NULL, NULL, '3', '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1416, NULL, NULL, '4', '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1417, NULL, NULL, '5', '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1418, NULL, NULL, '6', '2', 'view', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1419, NULL, NULL, '1', '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1420, NULL, NULL, '2', '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1421, NULL, NULL, '3', '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1422, NULL, NULL, '4', '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1423, NULL, NULL, '5', '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1424, NULL, NULL, '6', '2', 'create', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1425, NULL, NULL, '1', '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1426, NULL, NULL, '2', '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1427, NULL, NULL, '3', '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1428, NULL, NULL, '4', '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1429, NULL, NULL, '5', '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1430, NULL, NULL, '6', '2', 'update', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1431, NULL, NULL, '1', '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1432, NULL, NULL, '2', '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1433, NULL, NULL, '3', '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1434, NULL, NULL, '4', '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1435, NULL, NULL, '5', '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1436, NULL, NULL, '6', '2', 'delete', '2024-02-20 22:59:29', '2024-02-20 22:59:29'),
	(1705, '1667444041', NULL, NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1706, '1667444041', NULL, NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1707, '1667444041', NULL, NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1708, '1667444041', NULL, NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1710, '1708489505', NULL, NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1711, '1708489505', NULL, NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1712, '1708489505', NULL, NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1714, '1669390641', NULL, NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1715, '1669390641', NULL, NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1716, '1669390641', NULL, NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1721, '1668509889', NULL, NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1722, '1668509889', NULL, NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1723, '1668509889', NULL, NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1724, '1668509889', NULL, NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1725, '1708497496', NULL, NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1726, '1708497496', NULL, NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1727, '1708497496', NULL, NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1728, '1708497496', NULL, NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1730, '1668510568', NULL, NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1731, '1668510568', NULL, NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1732, '1668510568', NULL, NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1734, NULL, '21', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1735, NULL, '21', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1736, NULL, '21', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1737, NULL, '28', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1738, NULL, '28', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1739, NULL, '28', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1740, NULL, '28', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1741, NULL, '40', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1742, NULL, '40', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1743, NULL, '40', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1744, NULL, '40', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1746, NULL, '22', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1747, NULL, '22', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1748, NULL, '22', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1749, NULL, '29', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1750, NULL, '29', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1751, NULL, '29', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1752, NULL, '29', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1753, NULL, '41', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1754, NULL, '41', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1755, NULL, '41', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1756, NULL, '41', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1757, NULL, '23', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1761, NULL, '30', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1762, NULL, '30', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1763, NULL, '30', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1764, NULL, '30', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1765, NULL, '31', NULL, '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1766, NULL, '31', NULL, '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1767, NULL, '31', NULL, '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1768, NULL, '31', NULL, '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1770, NULL, NULL, '2', '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1771, NULL, NULL, '3', '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1772, NULL, NULL, '4', '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1773, NULL, NULL, '5', '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1774, NULL, NULL, '6', '1', 'view', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1775, NULL, NULL, '1', '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1776, NULL, NULL, '2', '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1777, NULL, NULL, '3', '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1778, NULL, NULL, '4', '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1779, NULL, NULL, '5', '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1780, NULL, NULL, '6', '1', 'create', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1781, NULL, NULL, '1', '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1782, NULL, NULL, '2', '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1783, NULL, NULL, '3', '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1784, NULL, NULL, '4', '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1785, NULL, NULL, '5', '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1786, NULL, NULL, '6', '1', 'update', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1787, NULL, NULL, '1', '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1788, NULL, NULL, '2', '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1789, NULL, NULL, '3', '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1790, NULL, NULL, '4', '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1791, NULL, NULL, '5', '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1792, NULL, NULL, '6', '1', 'delete', '2024-02-20 23:41:40', '2024-02-20 23:41:40'),
	(1881, '1668510568', NULL, NULL, '1', 'view', '2024-02-20 23:44:02', '2024-02-20 23:44:02'),
	(1887, '1708489505', NULL, NULL, '3', 'view', '2024-02-20 23:54:57', '2024-02-20 23:54:57'),
	(1978, '1709484339', NULL, NULL, '2', 'view', '2024-03-03 09:46:14', '2024-03-03 09:46:14'),
	(1979, '1709484339', NULL, NULL, '2', 'create', '2024-03-03 09:46:16', '2024-03-03 09:46:16'),
	(1980, '1709484339', NULL, NULL, '2', 'update', '2024-03-03 09:46:17', '2024-03-03 09:46:17'),
	(1981, '1709484339', NULL, NULL, '2', 'delete', '2024-03-03 09:46:17', '2024-03-03 09:46:17'),
	(1982, '1709484339', NULL, NULL, '3', 'view', '2024-03-03 09:46:45', '2024-03-03 09:46:45'),
	(1989, '1667444041', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1990, '1667444041', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1991, '1667444041', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1992, '1667444041', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1993, '1708489505', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1994, '1708489505', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1995, '1708489505', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1996, '1708489505', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1997, '1709484339', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1998, '1709484339', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(1999, '1709484339', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2000, '1709484339', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2001, '1669390641', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2002, '1669390641', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2003, '1669390641', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2004, '1669390641', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2005, '1668509889', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2006, '1668509889', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2007, '1668509889', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2008, '1668509889', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2009, '1708497496', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2010, '1708497496', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2011, '1708497496', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2012, '1708497496', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2013, '1668510568', NULL, NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2014, '1668510568', NULL, NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2015, '1668510568', NULL, NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2016, '1668510568', NULL, NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2017, NULL, '21', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2018, NULL, '21', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2019, NULL, '21', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2020, NULL, '21', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2021, NULL, '28', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2022, NULL, '28', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2023, NULL, '28', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2024, NULL, '28', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2025, NULL, '40', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2026, NULL, '40', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2027, NULL, '40', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2028, NULL, '40', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2029, NULL, '22', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2030, NULL, '22', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2031, NULL, '22', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2032, NULL, '22', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2033, NULL, '29', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2034, NULL, '29', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2035, NULL, '29', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2036, NULL, '29', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2037, NULL, '41', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2038, NULL, '41', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2039, NULL, '41', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2040, NULL, '41', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2041, NULL, '23', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2042, NULL, '23', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2043, NULL, '23', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2044, NULL, '23', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2045, NULL, '30', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2046, NULL, '30', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2047, NULL, '30', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2048, NULL, '30', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2049, NULL, '31', NULL, '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2050, NULL, '31', NULL, '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2051, NULL, '31', NULL, '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2052, NULL, '31', NULL, '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2053, NULL, NULL, '1', '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2054, NULL, NULL, '2', '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2055, NULL, NULL, '3', '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2056, NULL, NULL, '4', '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2057, NULL, NULL, '5', '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2058, NULL, NULL, '6', '4', 'view', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2059, NULL, NULL, '1', '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2060, NULL, NULL, '2', '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2061, NULL, NULL, '3', '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2062, NULL, NULL, '4', '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2063, NULL, NULL, '5', '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2064, NULL, NULL, '6', '4', 'create', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2065, NULL, NULL, '1', '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2066, NULL, NULL, '2', '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2067, NULL, NULL, '3', '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2068, NULL, NULL, '4', '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2069, NULL, NULL, '5', '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2070, NULL, NULL, '6', '4', 'update', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2071, NULL, NULL, '1', '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2072, NULL, NULL, '2', '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2073, NULL, NULL, '3', '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2074, NULL, NULL, '4', '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2075, NULL, NULL, '5', '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03'),
	(2076, NULL, NULL, '6', '4', 'delete', '2024-03-03 14:11:03', '2024-03-03 14:11:03');

-- membuang struktur untuk table davibardb.tbl_appreance
CREATE TABLE IF NOT EXISTS `tbl_appreance` (
  `appreance_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appreance_layout` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appreance_theme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appreance_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appreance_header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appreance_sidestyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`appreance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_appreance: ~2 rows (lebih kurang)
INSERT INTO `tbl_appreance` (`appreance_id`, `user_id`, `appreance_layout`, `appreance_theme`, `appreance_menu`, `appreance_header`, `appreance_sidestyle`, `created_at`, `updated_at`) VALUES
	(2, '1', 'sidebar-mini', 'dark-mode', 'dark-menu', 'dark-header', 'default-menu', '2022-11-22 02:45:47', '2024-02-20 21:27:32'),
	(3, '4', 'sidebar-mini', 'dark-mode', 'dark-menu', 'dark-header', 'default-menu', '2024-02-20 23:48:58', '2024-03-04 01:12:16');

-- membuang struktur untuk table davibardb.tbl_barang
CREATE TABLE IF NOT EXISTS `tbl_barang` (
  `barang_id` int unsigned NOT NULL AUTO_INCREMENT,
  `jenisbarang_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barang_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_stok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`barang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_barang: ~10 rows (lebih kurang)
INSERT INTO `tbl_barang` (`barang_id`, `jenisbarang_id`, `satuan_id`, `merk_id`, `barang_kode`, `barang_nama`, `barang_slug`, `barang_harga`, `barang_stok`, `barang_gambar`, `created_at`, `updated_at`) VALUES
	(12, '15', '9', '8', 'BRG-1708586204453', 'Bawang Merah Goreng (Large)', 'bawang-merah-goreng-large-', '80000', '10', 'image.png', '2024-02-21 23:17:32', '2024-02-22 03:02:52'),
	(13, '15', '9', '8', 'BRG-1708586260188', 'Bawang Merah Goreng (Medium)', 'bawang-merah-goreng-medium-', '17000', '100', 'image.png', '2024-02-21 23:18:45', '2024-02-22 03:04:11'),
	(14, '15', '9', '8', 'BRG-1708586840329', 'Bawang Merah Goreng (Small)', 'bawang-merah-goreng-small-', '5000', '100', 'image.png', '2024-02-21 23:27:43', '2024-02-22 03:03:56'),
	(15, '16', '9', '8', 'BRG-1708587025134', 'Bawang Putih Goreng (Large)', 'bawang-putih-goreng-large-', '80000', '10', 'image.png', '2024-02-21 23:31:14', '2024-02-22 03:03:37'),
	(16, '16', '9', '8', 'BRG-1708590452798', 'Bawang Putih Goreng (Medium)', 'bawang-putih-goreng-medium-', '17000', '100', 'image.png', '2024-02-22 00:28:09', '2024-02-22 03:03:21'),
	(17, '16', '9', '8', 'BRG-1708590570372', 'Bawang Putih Goreng (Small)', 'bawang-putih-goreng-small-', '5000', '100', 'image.png', '2024-02-22 00:30:47', '2024-02-22 03:00:48'),
	(18, '15', '9', '8', 'BRG-1708602227739', 'Toples A', 'toples-a', '50000', '0', 'image.png', '2024-02-22 03:44:51', '2024-02-24 16:46:24'),
	(19, '15', '9', '8', 'BRG-1708602315893', 'Toples B', 'toples-b', '30000', '10', 'image.png', '2024-02-22 03:45:40', '2024-02-22 03:45:59'),
	(20, NULL, '9', '8', 'BRG-1708602362497', 'Paket Mini', 'paket-mini', '4000', '100', 'image.png', '2024-02-22 03:46:49', '2024-02-25 18:21:11'),
	(21, NULL, '11', '8', 'BRG-1709470738167', 'Barang Test 1', 'barang-test-1', '1000', '0', 'image.png', '2024-03-03 05:59:10', '2024-03-03 05:59:10');

-- membuang struktur untuk table davibardb.tbl_barangkeluar
CREATE TABLE IF NOT EXISTS `tbl_barangkeluar` (
  `bk_id` int unsigned NOT NULL AUTO_INCREMENT,
  `bk_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bk_tanggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bk_tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bk_jumlah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_barangkeluar: ~0 rows (lebih kurang)
INSERT INTO `tbl_barangkeluar` (`bk_id`, `bk_kode`, `barang_kode`, `bk_tanggal`, `bk_tujuan`, `bk_jumlah`, `created_at`, `updated_at`) VALUES
	(1, 'BK-1709457451094', 'BRG-1708602362497', '2024-03-13', 'asda', '200', '2024-03-03 02:17:38', '2024-03-03 02:17:57');

-- membuang struktur untuk table davibardb.tbl_barangmasuk
CREATE TABLE IF NOT EXISTS `tbl_barangmasuk` (
  `bm_id` int unsigned NOT NULL AUTO_INCREMENT,
  `bm_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bm_tanggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bm_jumlah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_barangmasuk: ~3 rows (lebih kurang)
INSERT INTO `tbl_barangmasuk` (`bm_id`, `bm_kode`, `barang_kode`, `customer_id`, `bm_tanggal`, `bm_jumlah`, `created_at`, `updated_at`) VALUES
	(2, 'BM-1709442954650', 'BRG-1708602362497', '4', '2024-03-21', '100', '2024-03-02 22:16:08', '2024-03-02 22:16:08'),
	(3, 'BM-1709443037419', 'BRG-1708587025134', '4', '2024-03-20', '100', '2024-03-02 22:17:30', '2024-03-02 22:17:30'),
	(4, 'BM-1709449779205', 'BRG-1708602227739', '4', '2024-03-21', '40', '2024-03-03 00:09:52', '2024-03-03 00:10:51');

-- membuang struktur untuk table davibardb.tbl_customer
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `customer_id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `customer_notelp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_customer: ~0 rows (lebih kurang)
INSERT INTO `tbl_customer` (`customer_id`, `customer_nama`, `customer_slug`, `customer_alamat`, `customer_notelp`, `created_at`, `updated_at`) VALUES
	(4, 'Gudang Produksi Davibar', 'gudang-produksi-davibar', 'Malang, Dau, Sumbersekar Jawa Timur', '08123456', '2024-02-21 20:55:34', '2024-02-21 20:55:34');

-- membuang struktur untuk table davibardb.tbl_jenisbarang
CREATE TABLE IF NOT EXISTS `tbl_jenisbarang` (
  `jenisbarang_id` int unsigned NOT NULL AUTO_INCREMENT,
  `jenisbarang_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenisbarang_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenisbarang_keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`jenisbarang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_jenisbarang: ~0 rows (lebih kurang)

-- membuang struktur untuk table davibardb.tbl_menu
CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `menu_id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_redirect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_sort` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1709484340 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_menu: ~7 rows (lebih kurang)
INSERT INTO `tbl_menu` (`menu_id`, `menu_judul`, `menu_slug`, `menu_icon`, `menu_redirect`, `menu_sort`, `menu_type`, `created_at`, `updated_at`) VALUES
	(1667444041, 'Dashboard', 'dashboard', 'home', '/dashboard', '1', '1', '2022-11-15 03:51:04', '2024-03-03 09:45:13'),
	(1668509889, 'Menu Produk', 'menu-produk', 'package', '-', '5', '2', '2022-11-15 03:58:09', '2024-03-03 09:47:42'),
	(1668510568, 'Laporan', 'laporan', 'printer', '-', '7', '2', '2022-11-15 04:09:28', '2024-03-03 09:47:32'),
	(1669390641, 'Customer', 'customer', 'user', '/customer', '4', '1', '2022-11-25 08:37:21', '2024-03-03 09:47:49'),
	(1708489505, 'Pesan', 'pesan', 'shopping-cart', '/pesan', '2', '1', '2024-02-20 21:25:05', '2024-03-03 09:45:13'),
	(1708497496, 'Barang In Out', 'barang-in-out', 'code', '-', '6', '2', '2024-02-20 23:38:16', '2024-03-03 09:47:38'),
	(1709484339, 'Status Pesanan', 'status-pesanan', 'truck', '/pesan/status', '3', '1', '2024-03-03 09:45:39', '2024-03-03 09:47:49');

-- membuang struktur untuk table davibardb.tbl_merk
CREATE TABLE IF NOT EXISTS `tbl_merk` (
  `merk_id` int unsigned NOT NULL AUTO_INCREMENT,
  `merk_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`merk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_merk: ~0 rows (lebih kurang)
INSERT INTO `tbl_merk` (`merk_id`, `merk_nama`, `merk_slug`, `merk_keterangan`, `created_at`, `updated_at`) VALUES
	(8, 'Davibar', 'davibar', NULL, '2024-02-21 10:11:51', '2024-02-21 10:11:51');

-- membuang struktur untuk table davibardb.tbl_pesan
CREATE TABLE IF NOT EXISTS `tbl_pesan` (
  `pesan_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesan_idbarang` int NOT NULL,
  `pesan_idtransaksi` int NOT NULL,
  `pesan_jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pesan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_pesan: ~0 rows (lebih kurang)

-- membuang struktur untuk table davibardb.tbl_role
CREATE TABLE IF NOT EXISTS `tbl_role` (
  `role_id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_role: ~4 rows (lebih kurang)
INSERT INTO `tbl_role` (`role_id`, `role_title`, `role_slug`, `role_desc`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin', 'Admin Gudang', '2022-11-15 03:51:04', '2024-02-20 23:14:04'),
	(2, 'Kasir', 'kasir', 'Kasir', '2022-11-15 03:51:04', '2024-02-20 23:14:22'),
	(3, 'Reseller', 'reseller', 'Reseller', '2022-11-15 03:51:04', '2024-02-20 23:14:35'),
	(4, 'Owner', 'owner', 'Owner', '2022-12-06 02:33:27', '2024-02-20 23:13:49');

-- membuang struktur untuk table davibardb.tbl_satuan
CREATE TABLE IF NOT EXISTS `tbl_satuan` (
  `satuan_id` int unsigned NOT NULL AUTO_INCREMENT,
  `satuan_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`satuan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_satuan: ~0 rows (lebih kurang)
INSERT INTO `tbl_satuan` (`satuan_id`, `satuan_nama`, `satuan_slug`, `satuan_keterangan`, `created_at`, `updated_at`) VALUES
	(8, 'Gram', 'gram', NULL, '2024-02-21 10:11:19', '2024-02-21 10:11:39'),
	(9, 'Pcs', 'pcs', NULL, '2024-02-21 20:57:42', '2024-02-21 20:57:42'),
	(10, 'Pack', 'pack', NULL, '2024-02-21 20:57:53', '2024-02-21 20:57:53'),
	(11, 'Kg', 'kg', NULL, '2024-02-21 20:58:02', '2024-02-21 20:58:02');

-- membuang struktur untuk table davibardb.tbl_status_order
CREATE TABLE IF NOT EXISTS `tbl_status_order` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `kode_inv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Dikirim','Selesai','Dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bukti_bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode_bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diskon` int NOT NULL DEFAULT (0),
  `status_tanggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_status_order: ~0 rows (lebih kurang)

-- membuang struktur untuk table davibardb.tbl_submenu
CREATE TABLE IF NOT EXISTS `tbl_submenu` (
  `submenu_id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_redirect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submenu_sort` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`submenu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_submenu: ~0 rows (lebih kurang)
INSERT INTO `tbl_submenu` (`submenu_id`, `menu_id`, `submenu_judul`, `submenu_slug`, `submenu_redirect`, `submenu_sort`, `created_at`, `updated_at`) VALUES
	(21, '1668510568', 'Lap Barang Masuk', 'lap-barang-masuk', '/lap-barang-masuk', '1', '2022-11-30 05:56:24', '2022-11-30 05:56:24'),
	(22, '1668510568', 'Lap Barang Keluar', 'lap-barang-keluar', '/lap-barang-keluar', '2', '2022-11-30 05:56:24', '2022-11-30 05:56:24'),
	(23, '1668510568', 'Lap Stok Barang', 'lap-stok-barang', '/lap-stok-barang', '3', '2022-11-30 05:56:24', '2022-11-30 05:56:24'),
	(28, '1668509889', 'Jenis Produk', 'jenis-produk', '/jenisbarang', '1', '2024-02-20 21:29:30', '2024-02-20 21:29:30'),
	(29, '1668509889', 'Satuan Produk', 'satuan-produk', '/satuan', '2', '2024-02-20 21:29:30', '2024-02-20 21:29:30'),
	(30, '1668509889', 'Merk Produk', 'merk-produk', '/merk', '3', '2024-02-20 21:29:30', '2024-02-20 21:29:30'),
	(31, '1668509889', 'List Produk', 'list-produk', '/barang', '4', '2024-02-20 21:29:30', '2024-02-20 21:29:30'),
	(40, '1708497496', 'Barang Masuk', 'barang-masuk', '/barang-masuk', '1', '2024-02-20 23:38:16', '2024-02-20 23:38:16'),
	(41, '1708497496', 'Barang Keluar', 'barang-keluar', '/barang-keluar', '2', '2024-02-20 23:38:16', '2024-02-20 23:38:16');

-- membuang struktur untuk table davibardb.tbl_user
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_nmlengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_notlp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_user: ~4 rows (lebih kurang)
INSERT INTO `tbl_user` (`user_id`, `role_id`, `user_nmlengkap`, `user_nama`, `user_notlp`, `user_email`, `user_alamat`, `user_foto`, `user_password`, `created_at`, `updated_at`) VALUES
	(1, '1', 'Admin Gudang', 'admingudang', '111', 'admingudang@gmail.com', '212', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-11-15 03:51:04', '2024-02-25 02:12:27'),
	(2, '2', 'Kasir', 'kasir', '123456', 'kasir@gmail.com', 'Malang', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-11-15 03:51:04', '2024-02-25 02:44:51'),
	(3, '3', 'Reseller', 'reseller', '123456', 'reseller@gmail.com', 'Malang', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-11-15 03:51:04', '2024-02-25 02:44:43'),
	(4, '4', 'Fitri Alda Belia Wahyuni', 'owner', '123456', 'owner@gmail.com', 'Malang', 'undraw_profile.svg', '25d55ad283aa400af464c76d713c07ad', '2022-12-06 02:33:54', '2024-02-25 04:40:13');

-- membuang struktur untuk table davibardb.tbl_web
CREATE TABLE IF NOT EXISTS `tbl_web` (
  `web_id` int unsigned NOT NULL AUTO_INCREMENT,
  `web_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `web_bca` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_bri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_mandiri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_ewallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_bca_an` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_bri_an` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_mandiri_an` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_ewallet_an` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_zh_0900_as_cs DEFAULT NULL,
  `web_alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_tlpn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`web_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel davibardb.tbl_web: ~1 rows (lebih kurang)
INSERT INTO `tbl_web` (`web_id`, `web_nama`, `web_logo`, `web_deskripsi`, `created_at`, `updated_at`, `web_bca`, `web_bri`, `web_mandiri`, `web_ewallet`, `web_bca_an`, `web_bri_an`, `web_mandiri_an`, `web_ewallet_an`, `web_alamat`, `web_tlpn`) VALUES
	(1, 'DAVIBAR HOUSE', 'OJ6RYzt5m8XLI6XAjh6gLNQ5Ukgqzz9nPMeBy5YT.png', 'GUDANG DAN PEMBELIAN', '2022-11-15 03:51:04', '2025-06-14 01:34:28', '12345678', '12345678', '12345678', '12345678', 'Davibar', 'Davibar', 'Davibar', 'Davibar', 'Malang', '0812345678');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
