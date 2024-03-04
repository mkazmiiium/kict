-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2024 at 01:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kict_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `centraliseds`
--

CREATE TABLE `centraliseds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `student_capacity` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) NOT NULL,
  `sections` varchar(255) NOT NULL,
  `deleted` varchar(255) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centraliseds`
--

INSERT INTO `centraliseds` (`id`, `course_id`, `staff_id`, `student_capacity`, `created_at`, `updated_at`, `program_id`, `sections`, `deleted`) VALUES
(1, 'INFO 3305', '9831', '100', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(2, 'INFO 4312', '3815', '70', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'no'),
(3, 'INFO 2304', '10402', '214', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(4, 'INFO 1303', '5594', '360', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8 , Section 9', 'no'),
(5, 'CSCI 1301', '10567', '160', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BCS', 'Section 2 , Section 3 , Section 4 , Section 5', 'no'),
(6, 'CSCI 4320', '9221', '12', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BCS', 'Section 1', 'no'),
(7, 'INFO 2303', '4896', '188', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(8, 'CSCI 1303', '9954', '321', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BCS', 'Section 1 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8 , Section 9', 'no'),
(9, 'INFO 4340', '5341', '36', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'no'),
(10, 'INFO 4341', '5341', '18', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 2', 'no'),
(11, 'INFO 2302', '4573', '244', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7', 'no'),
(12, 'INFO 3307', '8398', '180', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(13, 'INFO 3308', '6856', '100', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(14, 'INFO 2306', '4295', '148', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 8', 'no'),
(15, 'CSCI 1304', '4964', '162', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 4 , Section 5', 'no'),
(16, 'CSCI 2303', '9157', '162', '2023-10-19 16:00:00', '2023-10-19 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(17, 'CSCI 1302', '10332', '154', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(18, 'CSCI 1305', '3705', '173', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(19, 'CSCI 1300', '7620', '332', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8', 'no'),
(20, 'CSCI 4323', '5133', '8', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'no'),
(21, 'INFO 4305', '4177', '81', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3', 'no'),
(22, 'INFO 4333', '4177', '25', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BIT', 'Section 1', 'no'),
(23, 'CSCI 4312', '8123', '35', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BCS', 'Section 1', 'no'),
(24, 'INFO 4332', '4177', '20', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BIT', 'Section 1', 'no'),
(25, 'ICTM 1302', '3189', '-165', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5', 'no'),
(26, 'CSCI 4330', '10552', '35', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(27, 'CSCI 4331', '10552', '28', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(28, 'INFO 2305', '6993', '170', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(29, 'INFO 4343', '6993', '29', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BIT', 'Section 1', 'no'),
(30, 'CSCI 4331', '10552', '28', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(31, 'CSCI 4333', '10552', '30', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(32, 'CSCI 4342', '4615', '31', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(33, 'INFO 1302', '1716', '310', '2023-10-25 16:00:00', '2023-10-25 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8', 'no'),
(34, 'CSCI 3303', '9608', '76', '2023-10-26 16:00:00', '2023-10-26 16:00:00', 'BCS', 'Section 1 , Section 2', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `created_at`, `updated_at`, `program_id`) VALUES
('CBIA 7101 ', 'Big Data Across Verticals and Domains ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MBIA'),
('CBIA 7102 ', 'Data Quality ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MBIA'),
('CBIA 7202 ', 'Unstructured Data Analytics ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MBIA'),
('CBIA 7301 ', 'Datathon and Bootcamp ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MBIA'),
('CCSM 7101 ', 'Business Continuity & Disaster Recovery ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MPSM'),
('CCSM 7102 ', 'Physical Protective Security ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MPSM'),
('CCSM 7301 ', 'Risk Management ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MPSM'),
('CCSM 7998 ', 'Dissertation ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MPSM'),
('CITA 7011 ', 'Islamic Worldview on IT and Society ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MBIA'),
('CSCI 1300', 'ELEMENTS OF PROGRAMMING', NULL, NULL, 'BCS'),
('CSCI 1301', 'OBJECT ORIENTED PROGRAMMING', NULL, NULL, 'BCS'),
('CSCI 1302', 'INTRODUCTION TO COMPUTER ORGANIZATION', NULL, NULL, 'BCS'),
('CSCI 1303', 'MATHEMATICS FOR COMPUTING I', NULL, NULL, 'BCS'),
('CSCI 1304', 'PROBABILITY AND STATISTICS', NULL, NULL, 'BCS'),
('CSCI 1305', 'INTRODUCTION TO SOFTWARE ENGINEERING', NULL, NULL, 'BCS'),
('CSCI 2300', 'DATA STRUCTURES AND ALGORITHMS I', NULL, NULL, 'BCS'),
('CSCI 2301', 'COMPUTER NETWORKING', NULL, NULL, 'BCS'),
('CSCI 2302', 'DIGITAL SYSTEMS FUNDAMENTALS', NULL, NULL, 'BCS'),
('CSCI 2303', 'PRINCIPLE OF IT SECURITY', NULL, NULL, 'BCS'),
('CSCI 2304', 'INTELLIGENT SYSTEMS', NULL, NULL, 'BCS'),
('CSCI 2305', 'MATHEMATICS FOR COMPUTING II', NULL, NULL, 'BCS'),
('CSCI 3300', 'OPERATING SYSTEMS', NULL, NULL, 'BCS'),
('CSCI 3301', 'COMPUTER ARCHITECTURE AND ASSEMBLY LANGUAGE', NULL, NULL, 'BCS'),
('CSCI 3302', 'DATA STRUCTURES AND ALGORITHMS II', NULL, NULL, 'BCS'),
('CSCI 3303', 'MATHEMATICS FOR COMPUTING III', NULL, NULL, 'BCS'),
('CSCI 4300', 'COMPUTATION AND COMPLEXITY', NULL, NULL, 'BCS'),
('CSCI 4311', 'MOBILE APPLICATION DEVELOPMENT', NULL, NULL, 'BCS'),
('CSCI 4312', 'BLOCKCHAIN & APPLICATION', NULL, NULL, 'BCS'),
('CSCI 4320', 'SOFTWARE TESTING', NULL, NULL, 'BCS'),
('CSCI 4321', 'PROJECT MANAGEMENT IN SOFTWARE ENGINEERING', NULL, NULL, 'BCS'),
('CSCI 4322', 'SOFTWARE DESIGN AND ARCHITECTURE', NULL, NULL, 'BCS'),
('CSCI 4323', 'REQUIREMENTS ENGINEERING', NULL, NULL, 'BCS'),
('CSCI 4325', 'SOFTWARE QUALITY ASSURANCE', NULL, NULL, 'BCS'),
('CSCI 4326', 'EMPIRICAL METHODS IN SOFTWARE ENGINEERING', NULL, NULL, 'BCS'),
('CSCI 4330', 'NETWORKING CONCEPTS AND PRACTICES', NULL, NULL, 'BCS'),
('CSCI 4331', 'ENTERPRISE NETWORK', NULL, NULL, 'BCS'),
('CSCI 4332', 'DIGITAL EVIDENCE FORENSICS', NULL, NULL, 'BCS'),
('CSCI 4333', 'CRYPTOGRAPHY', NULL, NULL, 'BCS'),
('CSCI 4336', 'NETWORK SECURITY', NULL, NULL, 'BCS'),
('CSCI 4340', 'MACHINE LEARNING', NULL, NULL, 'BCS'),
('CSCI 4341', 'BIG DATA ANALYTICS', NULL, NULL, 'BCS'),
('CSCI 4342', 'NATURAL LANGUAGE PROCESSING', NULL, NULL, 'BCS'),
('CSCI 4343', 'DATA SCIENCE', NULL, NULL, 'BCS'),
('CSCI 4346', 'BIOINSPIRED COMPUTING', NULL, NULL, 'BCS'),
('CSCI 4347', 'BRAIN COMPUTATIONAL ANALYTICS', NULL, NULL, 'BCS'),
('ICTM 1302', 'INFORMATION TECHNOLOGY', NULL, NULL, 'BIT'),
('INFO 1302', 'BUSINESS FUNDAMENTALS', NULL, NULL, 'BIT'),
('INFO 1303', 'DATABASE SYSTEMS', NULL, NULL, 'BIT'),
('INFO 2302', 'WEB TECHNOLOGIES', NULL, NULL, 'BIT'),
('INFO 2303', 'DATABASE PROGRAMMING', NULL, NULL, 'BIT'),
('INFO 2304', 'SYSTEM ANALYSIS AND DESIGN', NULL, NULL, 'BIT'),
('INFO 2305', 'MULTIMEDIA TECHNOLOGY', NULL, NULL, 'BIT'),
('INFO 2306', 'MANAGEMENT INFORMATION SYSTEMS', NULL, NULL, 'BIT'),
('INFO 3304', 'E-COMMERCE', NULL, NULL, 'BIT'),
('INFO 3305', 'WEB APPLICATION DEVELOPMENT', NULL, NULL, 'BIT'),
('INFO 3307', 'HUMAN COMPUTER INTERACTION', NULL, NULL, 'BIT'),
('INFO 3308', 'PROJECT  MANAGEMENT IN IT', NULL, NULL, 'BIT'),
('INFO 4303', 'TECHNOPRENEURSHIP', NULL, NULL, 'BIT'),
('INFO 4304', 'IT AND ISLAM', NULL, NULL, 'BIT'),
('INFO 4305', 'CYBER LAW & ETHICS', NULL, NULL, 'BIT'),
('INFO 4311', 'DATA WAREHOUSING', NULL, NULL, 'BIT'),
('INFO 4312', 'INFORMATION VISUALIZATION', NULL, NULL, 'BIT'),
('INFO 4313', 'DATA MINING', NULL, NULL, 'BIT'),
('INFO 4314', 'BUSINESS DATA ANALYTICS', NULL, NULL, 'BIT'),
('INFO 4320', 'ANIMATION TECHNIQUE', NULL, NULL, 'BIT'),
('INFO 4321', 'CREATIVE DESIGN TECHNIQUES', NULL, NULL, 'BIT'),
('INFO 4325', 'GRAPHIC DESIGN', NULL, NULL, 'BIT'),
('INFO 4328', 'GAME DESIGN AND DEVELOPMENT', NULL, NULL, 'BIT'),
('INFO 4330', 'CONTROL AND AUDIT OF INFORMATION SYSTEMS', NULL, NULL, 'BIT'),
('INFO 4332', 'KNOWLEDGE MANAGEMENT PRACTICES AND APPLICATION', NULL, NULL, 'BIT'),
('INFO 4333', 'INTEGRATED BUSINESS PROCESS AND ERP SYSTEMS', NULL, NULL, 'BIT'),
('INFO 4335', 'MOBILE APPLICATION DEVELOPMENT', NULL, NULL, 'BIT'),
('INFO 4336', 'INFORMATION RETRIEVAL TECHNOLOGIES', NULL, NULL, 'BIT'),
('INFO 4340', 'MANAGEMENT OF INFORMATION SECURITY', NULL, NULL, 'BIT'),
('INFO 4341', 'RISK MANAGEMENT', NULL, NULL, 'BIT'),
('INFO 4342', 'BUSINESS CONTINUITY AND DISASTER RECOVERY', NULL, NULL, 'BIT'),
('INFO 4343', 'INFORMATION PRIVACY', NULL, NULL, 'BIT'),
('INFO 4351', 'DIGITALPRENEURSHIP', NULL, NULL, 'BIT'),
('INFO 4352', 'DIGITALPRENEURSHIP CUSTOMER DEVELOPMENT', NULL, NULL, 'BIT'),
('INFO 7011', 'Islamic Worldview on ICT and Society', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7115', 'Advanced Data Management', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7125', 'Business Data Communications & Networking', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7131', 'IT Project & Change Management', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7145', 'Methodologies for System Development', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7151', 'IT Strategy & Governance', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7165', 'Advanced Enterprise Integration', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7211', 'Knowledge Management Principles & Practices', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7221', 'Advanced E-Commerce', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7231', 'Cybersecurity Challenges, Policy & Strategy', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7251', 'Mobile Communications & Networks', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7261', 'IT Professional Practices', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7271', 'Human Computer Interaction & Design', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7901', 'ICT Research Methods', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7991', 'Computing Project', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7992', 'IT Research Proposal', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('INFO 7993', 'IT Dissertation', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MITEC'),
('LISC 7020', 'Information Analysis and Organization I', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7070', 'Management of Information Institutions', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7071', 'Management of Information Institutions', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7120', 'Information Analysis and Organization I', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7121', 'Information Analysis and Organization II', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7135', 'Records and Archives Management', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7420', 'Application of Information Technology in Library', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7421', 'Application of Information Technology in Library', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7430', 'Digital Library', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7440', 'Information Processing and Database Development', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB');

-- --------------------------------------------------------

--
-- Table structure for table `decentraliseds`
--

CREATE TABLE `decentraliseds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_slot` varchar(255) NOT NULL,
  `student_capacity` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) NOT NULL,
  `sections` varchar(255) NOT NULL,
  `assessment_type` varchar(255) NOT NULL,
  `assessment_time` varchar(255) NOT NULL,
  `deleted` varchar(255) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `decentraliseds`
--

INSERT INTO `decentraliseds` (`id`, `course_id`, `staff_id`, `booking_date`, `booking_slot`, `student_capacity`, `created_at`, `updated_at`, `program_id`, `sections`, `assessment_type`, `assessment_time`, `deleted`) VALUES
(1, 'INFO 4311', '4559', '2024-01-02', 'Class-Time', '59', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Take Home', 'in-class', 'no'),
(2, 'CSCI 2301', '7132', '2024-01-19', 'Class-Time', '113', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'Final Assessment - Test', 'in-class', 'no'),
(3, 'INFO 4304', '4297', '2024-01-23', '9:00am - 1:00pm', '125', '2023-10-17 16:00:00', '2023-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(4, 'INFO 4320', '10163', '2024-01-19', '9:00am - 1:00pm', '33', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Take Home', 'outside-class', 'no'),
(5, 'INFO 4328', '10163', '2024-01-19', '2:00pm - 5:00pm', '17', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Take Home', 'outside-class', 'no'),
(6, 'INFO 3304', '6856', '2024-01-19', 'Class-Time', '29', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 4', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(7, 'INFO 3304', '3904', '2024-01-19', 'Class-Time', '88', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 5', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(8, 'CSCI 3300', '10738', '2024-01-22', '5:00pm - 8:00pm', '200', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5', 'Final Assessment - Test', 'outside-class', 'no'),
(9, 'CSCI 2301', '10738', '2024-01-19', 'Class-Time', '67', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BCS', 'Section 5 , Section 6 , Section 10', 'Final Assessment - Test', 'in-class', 'no'),
(10, 'CSCI 4343', '4964', '2024-01-22', '9:00am - 1:00pm', '15', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(11, 'INFO 4342', '4295', '2024-01-19', 'Class-Time', '26', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(12, 'CSCI 2302', '10324', '2024-01-19', 'Class-Time', '55', '2023-10-19 16:00:00', '2023-10-19 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3', 'Final Assessment - Test', 'in-class', 'yes'),
(13, 'CSCI 4347', '8627', '2024-01-18', 'Class-Time', '15', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(14, 'INFO 4311', '4559', '2024-01-16', 'Class-Time', '59', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Take Home', 'in-class', 'no'),
(15, 'CSCI 4322', '8405', '2024-01-16', 'Class-Time', '27', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(16, 'CSCI 2304', '4296', '2024-01-03', 'Class-Time', '56', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2', 'Final Assessment - Test', 'in-class', 'no'),
(17, 'CSCI 4340', '4296', '2024-01-03', 'Class-Time', '43', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2', 'Final Assessment - Test', 'in-class', 'no'),
(18, 'CSCI 4321', '7620', '2024-01-16', 'Class-Time', '28', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(19, 'CSCI 3301', '7910', '2024-01-08', 'Class-Time', '92', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3', 'Final Assessment - Test', 'in-class', 'no'),
(20, 'CSCI 3301', '7910', '2024-01-10', 'Class-Time', '92', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3', 'Final Assessment - Test', 'in-class', 'no'),
(21, 'CSCI 4341', '8667', '2024-01-17', 'Class-Time', '14', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Take Home', 'in-class', 'no'),
(22, 'CSCI 4341', '8667', '2023-12-20', 'Class-Time', '14', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Take Home', 'in-class', 'no'),
(23, 'CSCI 4332', '5505', '2024-01-15', 'Class-Time', '27', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(24, 'INFO 4321', '7816', '2024-01-17', 'Class-Time', '32', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(25, 'CSCI 2302', '10324', '2024-01-15', 'Class-Time', '55', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3', 'Final Assessment - Test', 'in-class', 'no'),
(26, 'CSCI 4347', '8627', '2024-01-18', 'Class-Time', '15', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(27, 'INFO 4314', '10400', '2024-01-08', 'Class-Time', '29', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(28, 'INFO 4330', '7822', '2024-01-18', 'Class-Time', '60', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(29, 'INFO 4332', '4177', '2024-01-18', 'Class-Time', '20', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(30, 'INFO 4313', '10400', '2024-01-08', 'Class-Time', '67', '2023-10-23 16:00:00', '2023-10-23 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(31, 'CSCI 2301', '10552', '2024-01-17', 'Class-Time', '43', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 7 , Section 9', 'Final Assessment - Test', 'in-class', 'no'),
(32, 'CSCI 4311', '5251', '2024-01-10', 'Class-Time', '25', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(33, 'INFO 4335', '4621', '2024-01-18', 'Class-Time', '22', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(34, 'CSCI 4336', '9157', '2024-01-17', 'Class-Time', '13', '2023-10-24 16:00:00', '2023-10-24 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(35, 'CSCI 2305', '9608', '2024-01-20', '2:00pm - 5:00pm', '162', '2023-10-26 16:00:00', '2023-10-26 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'Final Assessment - Test', 'outside-class', 'no'),
(36, 'CSCI 2305', '9608', '2024-01-05', 'Class-Time', '162', '2023-10-26 16:00:00', '2023-10-26 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'Final Assessment - Test', 'in-class', 'no');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_10_08_140204_create_sessions_table', 1),
(7, '2022_10_11_075627_create_courses_table', 1),
(8, '2022_10_11_081209_create_staff_table', 1),
(9, '2022_10_11_124131_create_decentraliseds_table', 1),
(10, '2022_10_15_123136_create_programs_table', 1),
(11, '2022_10_15_124631_add_program_id_for_course', 1),
(12, '2022_10_15_132413_add_program_id_for_decentraliseds', 1),
(13, '2022_10_15_142410_add_sections_and_assessment_type_for_decentraliseds', 1),
(14, '2022_10_16_151515_create_centraliseds_table', 1),
(15, '2022_10_19_142444_add_assessment_time_for_decentraliseds', 1),
(16, '2022_11_01_130541_add_deleted_for_decentraliseds', 1),
(17, '2022_11_01_130558_add_deleted_for_centraliseds', 1),
(18, '2022_11_01_133648_create_p_g_decentraliseds_table', 1),
(19, '2022_11_01_133712_create_p_g_centraliseds_table', 1),
(20, '2022_11_01_145228_create_p_g_programs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `program_name`, `created_at`, `updated_at`) VALUES
('BIT', 'Bachelor in Information Technology', NULL, NULL),
('BCS', 'Bachelor in Computer Science', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `p_g_centraliseds`
--

CREATE TABLE `p_g_centraliseds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `student_capacity` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) NOT NULL,
  `sections` varchar(255) NOT NULL,
  `deleted` varchar(255) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p_g_decentraliseds`
--

CREATE TABLE `p_g_decentraliseds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_slot` varchar(255) NOT NULL,
  `student_capacity` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` varchar(255) NOT NULL,
  `sections` varchar(255) NOT NULL,
  `assessment_type` varchar(255) NOT NULL,
  `assessment_time` varchar(255) NOT NULL,
  `deleted` varchar(255) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `p_g_decentraliseds`
--

INSERT INTO `p_g_decentraliseds` (`id`, `course_id`, `staff_id`, `booking_date`, `booking_slot`, `student_capacity`, `created_at`, `updated_at`, `program_id`, `sections`, `assessment_type`, `assessment_time`, `deleted`) VALUES
(1, 'CBIA 7202', '4964', '2024-01-19', 'Class-Time', '13', '2023-10-18 16:00:00', '2023-10-18 16:00:00', 'MBIA', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'yes'),
(2, 'INFO 7145', '7620', '2024-01-17', 'Class-Time', '2', '2023-10-22 16:00:00', '2023-10-22 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `p_g_programs`
--

CREATE TABLE `p_g_programs` (
  `program_id` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `p_g_programs`
--

INSERT INTO `p_g_programs` (`program_id`, `program_name`, `created_at`, `updated_at`) VALUES
('MPSM', 'Master in Protective Security Management', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('MBIA', 'Master in Business Intelligence And Analytic ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('MITEC', 'Master of Information Technology', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('MLIB', 'Master of Library and Information Science', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
('dB10BaoLAg1kZjp9NQwEuNOOWbM9kq1OqfL7c5sf', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNFdDbkZHMnBWSjVudUhybzh5WW1aMTkwV3lBMlZNY1l5VXhqTDZZUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1709510800),
('dNyGa22wQF2I8Q6U2tL7Oslj6evZ5G27vE5KQKsz', NULL, '10.101.229.164', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1JnUW1iR1dHckI0TDlWem1HYzh1OExNY2tjM05ENTRIS2ZFNFJ2cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMC4xMDEuMjI5LjQwL0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1698653812),
('px9zX9S4wfGW2b5JmsH6z2aBIYHwyjgBrdAJghKx', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1IzSTZZajhEalBrMXRhNzhZbnNyaG5TUWdMbnY0SjQ0c1JyVjRXbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698725447),
('U5brTBOEjhc7syhLp1yyLhmk4Ftgds5l4wZufovy', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVdadDY5Q2RPc0RucTB2N2xHNmFyOElhUGZZeWhlNUowSzd4UEhzQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1709267660),
('VH5mcXokVxzC09xAYB50v4msYlNASRQG2eSnZX6L', NULL, '10.101.229.164', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjNIYjhCR3hYa09UY3I5Smc0WnNUcmpMeDZ6dWNUdkJDeDdmUDFjQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMC4xMDEuMjI5LjQwL0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1698725207),
('WadmXyRfqEIPhkkktsVtIfXhytcmxWBeSkydMtFj', NULL, '10.111.63.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWNmZDI4RUtpak9TdVBFRjVSZk9Gc3FnaW1hWVZPV0tQS2RqMnp6eiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMC4xMDEuMjI5LjQwL0NlbnRyYWxpc2VkLWJvb2tpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698710561);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(255) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `created_at`, `updated_at`) VALUES
('10163', 'NURAZLIN BINTI ZAINAL AZMI', NULL, NULL),
('10324', 'ASMARANI BINTI AHMAD PUZI', NULL, NULL),
('10325', 'ATIKAH BALQIS BINTI BASRI', NULL, NULL),
('10332', 'AHSIAH BINTI ISMAIL', NULL, NULL),
('10400', 'ABDUL RAFIEZ BIN ABDUL RAZIFF', NULL, NULL),
('10402', 'ELIN ELIANA BINTI ABDUL RAHIM', NULL, NULL),
('10552', 'ZAINAB SENAN MAHMOD ATTAR BASHI', NULL, NULL),
('10567', 'DINI OKTARINA DWI HANDAYANI', NULL, NULL),
('10722', 'ABDUL WAHAB BIN ABDUL RAHMAN', NULL, NULL),
('10738', 'AHMAD ANWAR BIN ZAINUDDIN', NULL, NULL),
('10744', 'TENGKU MOHD BIN TENGKU SEMBOK ', NULL, NULL),
('11085', 'AYUB BIN ABDUL RAHMAN', NULL, NULL),
('1375', 'MOHAMAD FAUZAN BIN NOORDIN', NULL, NULL),
('1675', 'ROSLINA OTHMAN ', NULL, NULL),
('1716', 'ABD. RAHMAN BIN AHLAN', NULL, NULL),
('3189', 'AHMAD FATZILAH BIN MISMAN', NULL, NULL),
('3451', 'MURNI BT. MAHMUD', NULL, NULL),
('3509', 'NORMI SHAM BT. AWANG ABU BAKAR', NULL, NULL),
('3570', 'MUHD. ROSYDI BIN MUHAMMAD', NULL, NULL),
('3705', 'NORSAREMAH BT. SALLEH', NULL, NULL),
('3815', 'MADIHAH BT. S. ABD. AZIZ', NULL, NULL),
('3904', 'NOOR AZIZAH BT. MOHAMADALI', NULL, NULL),
('4177', 'AZNAN ZUHID BIN SAIDIN', NULL, NULL),
('4295', 'SHUHAILI BT. TALIB', NULL, NULL),
('4296', 'AMELIA RITAHANI BT. ISMAIL', NULL, NULL),
('4297', 'NOOR HASRUL NIZAN BIN MOHAMMAD NOOR', NULL, NULL),
('4298', 'MOHD. SYARQAWY BIN HAMZAH', NULL, NULL),
('4559', 'LILI MARZIANA BT. ABDULLAH', NULL, NULL),
('4573', 'MARINI OTHMAN', NULL, NULL),
('4578', 'MIOR NASIR MIOR NAZRI', NULL, NULL),
('4615', 'SURIANI BT. SULAIMAN', NULL, NULL),
('4621', 'MUHAMAD SADRY ABU SEMAN', NULL, NULL),
('4870', 'HAMWIRA SAKTI BIN YAACOB', NULL, NULL),
('4896', 'ZAINATUL SHIMA ABDULLAH', NULL, NULL),
('4964', 'RAINI BINTI HASSAN', NULL, NULL),
('5066', 'NORZARIYAH BINTI YAHYA', NULL, NULL),
('5133', 'AZLIN BINTI NORDIN', NULL, NULL),
('5251', 'RIZAL BIN MOHD. NOR', NULL, NULL),
('5341', 'NURUL NUHA BINTI ABDUL MOLOK', NULL, NULL),
('5505', 'NORMAZIAH BINTI ABDUL AZIZ', NULL, NULL),
('5594', 'MOHD. IZZUDDIN BIN MOHD. TAMRIN', NULL, NULL),
('6153', 'AKRAM M Z M KHEDHER', NULL, NULL),
('6202', 'JAMALUDIN BIN IBRAHIM', NULL, NULL),
('6250', 'ABDUL RAHMAN BIN AHMAD DAHLAN', NULL, NULL),
('6326', 'MIRA KARTIWI', NULL, NULL),
('6566', 'ASADULLAH SHAH', NULL, NULL),
('6856', 'NOOR AZIAN BT. MOHAMAD ALI', NULL, NULL),
('6948', 'ZAHIDAH BINTI ZULKIFLI', NULL, NULL),
('6993', 'SUHAILA BINTI SAMSURI', NULL, NULL),
('7132', 'ADAMU ABUBAKAR IBRAHIM', NULL, NULL),
('7620', 'SITI ASMA BINTI MOHAMMED', NULL, NULL),
('7684', 'ROOSFA HASHIM', NULL, NULL),
('771', 'MAZNAH BT AHMAD', NULL, NULL),
('7816', 'HAZWANI BT MOHD MOHADIS', NULL, NULL),
('7822', 'NOOR HAYANI BINTI ABD RAHIM', NULL, NULL),
('7910', 'HAFIZAH BINTI MANSOR', NULL, NULL),
('8123', 'NORBIK BASHAH BIN IDRIS', NULL, NULL),
('8227', 'SHARIFAH NUR AMIRAH SARIF ABDULLAH', NULL, NULL),
('8371', 'NURUL LIYANA BINTI MOHAMAD ZULKUFLI', NULL, NULL),
('8398', 'MUNA BINTI AZUDDIN', NULL, NULL),
('8405', 'NOOR AZURA BINTI ZAKARIA', NULL, NULL),
('8627', 'NORZALIZA BINTI MD NOR', NULL, NULL),
('8638', 'RAWAD ABDULKHALEQ ABDULMOLLA ABDULGHAFOR', NULL, NULL),
('8667', 'SHARYAR WANI', NULL, NULL),
('9019', 'NOR SAADAH MD. NOR', NULL, NULL),
('9026', 'NURHAFIZAH BINTI MAHRI', NULL, NULL),
('9041', 'NUR LEYNI NILAM PUTRI JUNURHAM', NULL, NULL),
('9084', 'NAJHAN BIN MUHAMAD IBRAHIM', NULL, NULL),
('9157', 'ANDI FITRIAH BINTI ABDUL KADIR', NULL, NULL),
('9221', 'AMIR AATIEFF BIN AMIR HUSSIN', NULL, NULL),
('9471', 'AIDRINA BINTI MOHAMED SOFIADIN', NULL, NULL),
('9608', 'AKEEM OLOWOLAYEMO', NULL, NULL),
('9622', 'NORLIA MD YUSOF', NULL, NULL),
('9831', 'MOHD KHAIRUL AZMI BIN HASSAN', NULL, NULL),
('9954', 'TAKUMI SASE', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `centraliseds`
--
ALTER TABLE `centraliseds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `decentraliseds`
--
ALTER TABLE `decentraliseds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `p_g_centraliseds`
--
ALTER TABLE `p_g_centraliseds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_g_decentraliseds`
--
ALTER TABLE `p_g_decentraliseds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

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
-- AUTO_INCREMENT for table `centraliseds`
--
ALTER TABLE `centraliseds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `decentraliseds`
--
ALTER TABLE `decentraliseds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p_g_centraliseds`
--
ALTER TABLE `p_g_centraliseds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p_g_decentraliseds`
--
ALTER TABLE `p_g_decentraliseds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
