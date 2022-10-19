# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.34)
# Database: kict
# Generation Time: 2022-10-17 13:26:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table centraliseds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `centraliseds`;

CREATE TABLE `centraliseds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_capacity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sections` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `course_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`course_id`, `course_name`, `created_at`, `updated_at`, `program_id`)
VALUES
	('CSCI 1300','ELEMENTS OF PROGRAMMING',NULL,NULL,'BCS'),
	('CSCI 1301','OBJECT ORIENTED PROGRAMMING',NULL,NULL,'BCS'),
	('CSCI 1302','INTRODUCTION TO COMPUTER ORGANIZATION',NULL,NULL,'BCS'),
	('CSCI 1303','MATHEMATICS FOR COMPUTING I',NULL,NULL,'BCS'),
	('CSCI 1304','PROBABILITY AND STATISTICS',NULL,NULL,'BCS'),
	('CSCI 1305','INTRODUCTION TO SOFTWARE ENGINEERING',NULL,NULL,'BCS'),
	('CSCI 2300','DATA STRUCTURES AND ALGORITHMS I',NULL,NULL,'BCS'),
	('CSCI 2301','COMPUTER NETWORKING',NULL,NULL,'BCS'),
	('CSCI 2302','DIGITAL SYSTEMS FUNDAMENTALS',NULL,NULL,'BCS'),
	('CSCI 2303','PRINCIPLE OF IT SECURITY',NULL,NULL,'BCS'),
	('CSCI 2304','INTELLIGENT SYSTEMS',NULL,NULL,'BCS'),
	('CSCI 2305','MATHEMATICS FOR COMPUTING II',NULL,NULL,'BCS'),
	('CSCI 3300','OPERATING SYSTEMS',NULL,NULL,'BCS'),
	('CSCI 3301','COMPUTER ARCHITECTURE AND ASSEMBLY LANGUAGE',NULL,NULL,'BCS'),
	('CSCI 3302','DATA STRUCTURES AND ALGORITHMS II',NULL,NULL,'BCS'),
	('CSCI 3303','MATHEMATICS FOR COMPUTING III',NULL,NULL,'BCS'),
	('CSCI 4300','COMPUTATION AND COMPLEXITY',NULL,NULL,'BCS'),
	('CSCI 4311','MOBILE APPLICATION DEVELOPMENT',NULL,NULL,'BCS'),
	('CSCI 4312','BLOCKCHAIN & APPLICATION',NULL,NULL,'BCS'),
	('CSCI 4320','SOFTWARE TESTING',NULL,NULL,'BCS'),
	('CSCI 4321','PROJECT MANAGEMENT IN SOFTWARE ENGINEERING',NULL,NULL,'BCS'),
	('CSCI 4322','SOFTWARE DESIGN AND ARCHITECTURE',NULL,NULL,'BCS'),
	('CSCI 4323','REQUIREMENTS ENGINEERING',NULL,NULL,'BCS'),
	('CSCI 4325','SOFTWARE QUALITY ASSURANCE',NULL,NULL,'BCS'),
	('CSCI 4326','EMPIRICAL METHODS IN SOFTWARE ENGINEERING',NULL,NULL,'BCS'),
	('CSCI 4330','NETWORKING CONCEPTS AND PRACTICES',NULL,NULL,'BCS'),
	('CSCI 4331','ENTERPRISE NETWORK',NULL,NULL,'BCS'),
	('CSCI 4332','DIGITAL EVIDENCE FORENSICS',NULL,NULL,'BCS'),
	('CSCI 4333','CRYPTOGRAPHY',NULL,NULL,'BCS'),
	('CSCI 4336','NETWORK SECURITY',NULL,NULL,'BCS'),
	('CSCI 4340','MACHINE LEARNING',NULL,NULL,'BCS'),
	('CSCI 4341','BIG DATA ANALYTICS',NULL,NULL,'BCS'),
	('CSCI 4342','NATURAL LANGUAGE PROCESSING',NULL,NULL,'BCS'),
	('CSCI 4343','DATA SCIENCE',NULL,NULL,'BCS'),
	('CSCI 4346','BIOINSPIRED COMPUTING',NULL,NULL,'BCS'),
	('CSCI 4347','BRAIN COMPUTATIONAL ANALYTICS',NULL,NULL,'BCS'),
	('ICTM 1302','INFORMATION TECHNOLOGY',NULL,NULL,'BIT'),
	('INFO 1302','BUSINESS FUNDAMENTALS',NULL,NULL,'BIT'),
	('INFO 1303','DATABASE SYSTEMS',NULL,NULL,'BIT'),
	('INFO 2302','WEB TECHNOLOGIES',NULL,NULL,'BIT'),
	('INFO 2303','DATABASE PROGRAMMING',NULL,NULL,'BIT'),
	('INFO 2304','SYSTEM ANALYSIS AND DESIGN',NULL,NULL,'BIT'),
	('INFO 2305','MULTIMEDIA TECHNOLOGY',NULL,NULL,'BIT'),
	('INFO 2306','MANAGEMENT INFORMATION SYSTEMS',NULL,NULL,'BIT'),
	('INFO 3304','E-COMMERCE',NULL,NULL,'BIT'),
	('INFO 3305','WEB APPLICATION DEVELOPMENT',NULL,NULL,'BIT'),
	('INFO 3307','HUMAN COMPUTER INTERACTION',NULL,NULL,'BIT'),
	('INFO 3308','PROJECT  MANAGEMENT IN IT',NULL,NULL,'BIT'),
	('INFO 4303','TECHNOPRENEURSHIP',NULL,NULL,'BIT'),
	('INFO 4304','IT AND ISLAM',NULL,NULL,'BIT'),
	('INFO 4305','CYBER LAW & ETHICS',NULL,NULL,'BIT'),
	('INFO 4311','DATA WAREHOUSING',NULL,NULL,'BIT'),
	('INFO 4312','INFORMATION VISUALIZATION',NULL,NULL,'BIT'),
	('INFO 4314','BUSINESS DATA ANALYTICS',NULL,NULL,'BIT'),
	('INFO 4320','ANIMATION TECHNIQUE',NULL,NULL,'BIT'),
	('INFO 4321','CREATIVE DESIGN TECHNIQUES',NULL,NULL,'BIT'),
	('INFO 4325','GRAPHIC DESIGN',NULL,NULL,'BIT'),
	('INFO 4328','GAME DESIGN AND DEVELOPMENT',NULL,NULL,'BIT'),
	('INFO 4330','CONTROL AND AUDIT OF INFORMATION SYSTEMS',NULL,NULL,'BIT'),
	('INFO 4333','INTEGRATED BUSINESS PROCESS AND ERP SYSTEMS',NULL,NULL,'BIT'),
	('INFO 4335','MOBILE APPLICATION DEVELOPMENT',NULL,NULL,'BIT'),
	('INFO 4336','INFORMATION RETRIEVAL TECHNOLOGIES',NULL,NULL,'BIT'),
	('INFO 4340','MANAGEMENT OF INFORMATION SECURITY',NULL,NULL,'BIT'),
	('INFO 4341','RISK MANAGEMENT',NULL,NULL,'BIT'),
	('INFO 4343','INFORMATION PRIVACY',NULL,NULL,'BIT'),
	('INFO 4351','DIGITALPRENEURSHIP',NULL,NULL,'BIT'),
	('INFO 4352','DIGITALPRENEURSHIP CUSTOMER DEVELOPMENT',NULL,NULL,'BIT');

/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table decentraliseds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `decentraliseds`;

CREATE TABLE `decentraliseds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `booking_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_capacity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sections` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assessment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),
	(4,'2019_08_19_000000_create_failed_jobs_table',1),
	(5,'2019_12_14_000001_create_personal_access_tokens_table',1),
	(6,'2022_10_08_140204_create_sessions_table',1),
	(7,'2022_10_11_075627_create_courses_table',2),
	(8,'2022_10_11_081209_create_staff_table',3),
	(13,'2022_10_11_124131_create_decentraliseds_table',4),
	(15,'2022_10_15_123136_create_programs_table',5),
	(16,'2022_10_15_124631_add_program_id_for_course',6),
	(17,'2022_10_15_132413_add_program_id_for_decentraliseds',7),
	(22,'2022_10_15_142410_add_sections_and_assessment_type_for_decentraliseds',8),
	(24,'2022_10_16_151515_create_centraliseds_table',9);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table personal_access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table programs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `programs`;

CREATE TABLE `programs` (
  `program_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;

INSERT INTO `programs` (`program_id`, `program_name`, `created_at`, `updated_at`)
VALUES
	('BIT','Bachelor in Information Technology',NULL,NULL),
	('BCS','Bachelor in Computer Science',NULL,NULL);

/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`)
VALUES
	('LndCWZzqFBtuCHYRVynA11sgcJ11Z9sLGb8dODoJ',NULL,'::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2lPWlVaNmszRnM3N3Y0OWd6U2YxODNpUWJFaUdkb2NEZDF6NTRKTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvRGVjZW50cmFsaXNlZC1ib29raW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1666013099);

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `staff`;

CREATE TABLE `staff` (
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;

INSERT INTO `staff` (`staff_id`, `staff_name`, `created_at`, `updated_at`)
VALUES
	('10163','NURAZLIN BINTI ZAINAL AZMI',NULL,NULL),
	('10324','ASMARANI BINTI AHMAD PUZI',NULL,NULL),
	('10325','ATIKAH BALQIS BINTI BASRI',NULL,NULL),
	('10332','AHSIAH BINTI ISMAIL',NULL,NULL),
	('10400','ABDUL RAFIEZ BIN ABDUL RAZIFF',NULL,NULL),
	('10402','ELIN ELIANA BINTI ABDUL RAHIM',NULL,NULL),
	('10552','ZAINAB SENAN MAHMOD ATTAR BASHI',NULL,NULL),
	('10567','DINI OKTARINA DWI HANDAYANI',NULL,NULL),
	('10722','ABDUL WAHAB BIN ABDUL RAHMAN',NULL,NULL),
	('10738','AHMAD ANWAR BIN ZAINUDDIN',NULL,NULL),
	('10744','TENGKU MOHD BIN TENGKU SEMBOK ',NULL,NULL),
	('1375','MOHAMAD FAUZAN BIN NOORDIN',NULL,NULL),
	('1716','ABD. RAHMAN BIN AHLAN',NULL,NULL),
	('3189','AHMAD FATZILAH BIN MISMAN',NULL,NULL),
	('3451','MURNI BT. MAHMUD',NULL,NULL),
	('3509','NORMI SHAM BT. AWANG ABU BAKAR',NULL,NULL),
	('3570','MUHD. ROSYDI BIN MUHAMMAD',NULL,NULL),
	('3705','NORSAREMAH BT. SALLEH',NULL,NULL),
	('3815','MADIHAH BT. S. ABD. AZIZ',NULL,NULL),
	('3904','NOOR AZIZAH BT. MOHAMADALI',NULL,NULL),
	('4177','AZNAN ZUHID BIN SAIDIN',NULL,NULL),
	('4295','SHUHAILI BT. TALIB',NULL,NULL),
	('4296','AMELIA RITAHANI BT. ISMAIL',NULL,NULL),
	('4297','NOOR HASRUL NIZAN BIN MOHAMMAD NOOR',NULL,NULL),
	('4298','MOHD. SYARQAWY BIN HAMZAH',NULL,NULL),
	('4559','LILI MARZIANA BT. ABDULLAH',NULL,NULL),
	('4573','MARINI OTHMAN',NULL,NULL),
	('4578','MIOR NASIR MIOR NAZRI',NULL,NULL),
	('4615','SURIANI BT. SULAIMAN',NULL,NULL),
	('4621','MUHAMAD SADRY ABU SEMAN',NULL,NULL),
	('4870','HAMWIRA SAKTI BIN YAACOB',NULL,NULL),
	('4896','ZAINATUL SHIMA ABDULLAH',NULL,NULL),
	('4964','RAINI BINTI HASSAN',NULL,NULL),
	('5066','NORZARIYAH BINTI YAHYA',NULL,NULL),
	('5133','AZLIN BINTI NORDIN',NULL,NULL),
	('5251','RIZAL BIN MOHD. NOR',NULL,NULL),
	('5341','NURUL NUHA BINTI ABDUL MOLOK',NULL,NULL),
	('5505','NORMAZIAH BINTI ABDUL AZIZ',NULL,NULL),
	('5594','MOHD. IZZUDDIN BIN MOHD. TAMRIN',NULL,NULL),
	('6153','AKRAM M Z M KHEDHER',NULL,NULL),
	('6202','JAMALUDIN BIN IBRAHIM',NULL,NULL),
	('6250','ABDUL RAHMAN BIN AHMAD DAHLAN',NULL,NULL),
	('6288','NOOR SHAFINI MOHAMAD',NULL,NULL),
	('6326','MIRA KARTIWI',NULL,NULL),
	('6566','ASADULLAH SHAH',NULL,NULL),
	('6856','NOOR AZIAN BT. MOHAMAD ALI',NULL,NULL),
	('6948','ZAHIDAH BINTI ZULKIFLI',NULL,NULL),
	('6993','SUHAILA BINTI SAMSURI',NULL,NULL),
	('7132','ADAMU ABUBAKAR IBRAHIM',NULL,NULL),
	('7620','SITI ASMA BINTI MOHAMMED',NULL,NULL),
	('771','MAZNAH BT AHMAD',NULL,NULL),
	('7816','HAZWANI BT MOHD MOHADIS',NULL,NULL),
	('7822','NOOR HAYANI BINTI ABD RAHIM',NULL,NULL),
	('7910','HAFIZAH BINTI MANSOR',NULL,NULL),
	('8123','NORBIK BASHAH BIN IDRIS',NULL,NULL),
	('8371','NURUL LIYANA BINTI MOHAMAD ZULKUFLI',NULL,NULL),
	('8398','MUNA BINTI AZUDDIN',NULL,NULL),
	('8405','NOOR AZURA BINTI ZAKARIA',NULL,NULL),
	('8627','NORZALIZA BINTI MD NOR',NULL,NULL),
	('8638','RAWAD ABDULKHALEQ ABDULMOLLA ABDULGHAFOR',NULL,NULL),
	('8667','SHARYAR WANI',NULL,NULL),
	('9026','NURHAFIZAH BINTI MAHRI',NULL,NULL),
	('9084','NAJHAN BIN MUHAMAD IBRAHIM',NULL,NULL),
	('9157','ANDI FITRIAH BINTI ABDUL KADIR',NULL,NULL),
	('9221','AMIR AATIEFF BIN AMIR HUSSIN',NULL,NULL),
	('9471','AIDRINA BINTI MOHAMED SOFIADIN',NULL,NULL),
	('9608','AKEEM OLOWOLAYEMO',NULL,NULL),
	('9622','NORLIA MD YUSOF',NULL,NULL),
	('9831','MOHD KHAIRUL AZMI BIN HASSAN',NULL,NULL),
	('9954','TAKUMI SASE',NULL,NULL);

/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`)
VALUES
	(1,'Mohd Khairul Azmi Hassan','mkazmi@iium.edu.my',NULL,'$2y$10$Vyb1gUpRE9ZGqHj3NkbOBuivVEdz8oKlp5mFztz/rnyLJh60gMa0u',NULL,NULL,NULL,'YVsTUJLTOPlfNLK2ZWSnLjHNz1jqPbsohMlVC5NoHWIcQqzjuk8quajhqZY5',NULL,NULL,'2022-10-08 14:15:07','2022-10-08 14:15:07');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
