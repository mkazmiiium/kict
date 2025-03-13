-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2025 at 03:10 AM
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
(1, 'INFO 3305', '9831', '135', '2024-10-15 16:00:00', '2024-10-15 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(2, 'INFO 4330', '7822', '73', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 2', 'no'),
(3, 'CSCI 1301', '3705', '95', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(4, 'CSCI 1303', '9954', '31', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1', 'no'),
(5, 'CSCI 4333', '9954', '41', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1', 'no'),
(6, 'BICS 1302', '9954', '363', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8 , Section 9', 'no'),
(7, 'BIIT 1302', '9471', '200', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5', 'no'),
(8, 'INFO 2304', '6948', '350', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8 , Section 9', 'no'),
(9, 'BIIT 1303', '6948', '200', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5', 'no'),
(10, 'INFO 3307', '7816', '179', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7', 'no'),
(11, 'INFO 2306', '7816', '103', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 2 , Section 3 , Section 4 , Section 5', 'no'),
(12, 'CSCI 3303', '9608', '156', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(13, 'CSCI 4300', '10744', '25', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1', 'no'),
(14, 'CSCI 4300', '10744', '13', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 2', 'no'),
(15, 'CSCI 4300', '10744', '8', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 3', 'no'),
(16, 'CSCI 2300', '4870', '300', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8', 'no'),
(17, 'CSCI 1305', '5133', '40', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(18, 'CSCI 4323', '5133', '15', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BCS', 'Section 1', 'no'),
(19, 'BIIT 1301', '5594', '362', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8 , Section 9', 'no'),
(20, 'INFO 2303', '4896', '166', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'no'),
(21, 'CSCI 1304', '4964', '69', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(22, 'INFO 2305', '6993', '50', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3', 'no'),
(23, 'INFO 4343', '6993', '40', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1', 'no'),
(24, 'INFO 2302', '9084', '310', '2024-10-21 16:00:00', '2024-10-21 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8', 'no'),
(25, 'CSCI 1302', '10332', '101', '2024-10-21 16:00:00', '2024-10-21 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(26, 'CSCI 2303', '7910', '152', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(27, 'INFO 4333', '1716', '17', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1', 'no'),
(28, 'INFO 4305', '3570', '93', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4', 'no'),
(29, 'INFO 4332', '4177', '18', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1', 'no'),
(30, 'INFO 2305', '11085', '67', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 4 , Section 5', 'no'),
(31, 'CSCI 4330', '10552', '50', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1 , Section 2', 'no'),
(32, 'CSCI 4331', '10552', '50', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1 , Section 2', 'no'),
(33, 'CSCI 4334', '10552', '27', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(34, 'BICS 1301', '4615', '355', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6 , Section 7 , Section 8 , Section 9', 'no'),
(35, 'CSCI 1300', '4615', '15', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(36, 'CSCI 4342', '4615', '42', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1', 'no'),
(37, 'INFO 4320', '3189', '18', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'BIT', 'Section 1', 'no');

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
('BICS 1301', 'ELEMENTS OF PROGRAMMING', NULL, NULL, 'BCS'),
('BICS 1302', 'INTRODUCTION TO COMPUTER ORGANIZATION', NULL, NULL, 'BCS'),
('BICS 1303', 'COMPUTER NETWORKING', NULL, NULL, 'BCS'),
('BICS 1304', 'OBJECT ORIENTED PROGRAMMING', NULL, NULL, 'BCS'),
('BICS 1305', 'DISCRETE STRUCTURES', NULL, NULL, 'BCS'),
('BIIT 1301', 'DATABASE PROGRAMMING', NULL, NULL, 'BIT'),
('BIIT 1302', 'ORGANISATIONAL INFORMATICS', NULL, NULL, 'BIT'),
('BIIT 1303', 'SYSTEM ANALYSIS AND DESIGN', NULL, NULL, 'BIT'),
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
('CSCI 4334', 'NETWORK AND SYSTEM ADMINISTRATION', NULL, NULL, 'BCS'),
('CSCI 4336', 'NETWORK SECURITY', NULL, NULL, 'BCS'),
('CSCI 4340', 'MACHINE LEARNING', NULL, NULL, 'BCS'),
('CSCI 4341', 'BIG DATA ANALYTICS', NULL, NULL, 'BCS'),
('CSCI 4342', 'NATURAL LANGUAGE PROCESSING', NULL, NULL, 'BCS'),
('CSCI 4343', 'DATA SCIENCE', NULL, NULL, 'BCS'),
('CSCI 4346', 'BIOINSPIRED COMPUTING', NULL, NULL, 'BCS'),
('CSCI 4347', 'BRAIN COMPUTATIONAL ANALYTICS', NULL, NULL, 'BCS'),
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
('INFO 4326', '3D MODELLING', NULL, NULL, 'BIT'),
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
('INFO 4345', 'WEB APPLICATION SECURITY', NULL, NULL, 'BIT'),
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
('LISC  8994', 'Research Proposal', NULL, NULL, 'PLIB'),
('LISC 7020', 'Information Analysis and Organization I', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7021', 'Arabic Cataloguing', NULL, NULL, 'MLIB'),
('LISC 7041', 'Information Sources and Services', NULL, NULL, 'MLIB'),
('LISC 7042', 'Information Sources and Services in Islamic Revealed Knowledge', NULL, NULL, 'MLIB'),
('LISC 7051', 'Information Resources Development', NULL, NULL, 'MLIB'),
('LISC 7070', 'Management of Information Institutions', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7071', 'Management of Information Institutions', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7072', 'Management of Islamic Manuscript Collection', NULL, NULL, 'MLIB'),
('LISC 7073', 'Management of Official Publications', NULL, NULL, 'MLIB'),
('LISC 7074', 'Conservation and Preservation of Information Resources', NULL, NULL, 'MLIB'),
('LISC 7075', 'Records and Archives Management', NULL, NULL, 'MLIB'),
('LISC 7120', 'Information Analysis and Organization I', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7121', 'Information Analysis and Organization II', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7135', 'Records and Archives Management', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7182', 'Information Storage and Retrieval', NULL, NULL, 'MLIB'),
('LISC 7183', 'Bibliometrics', NULL, NULL, 'MLIB'),
('LISC 7184', 'Measurement and Evaluation', NULL, NULL, 'MLIB'),
('LISC 7185', 'Indexing and Abstracting', NULL, NULL, 'MLIB'),
('LISC 7199', 'Conservation and Preservation of Information Resources', NULL, NULL, 'MLIB'),
('LISC 7401', 'Reference Services', NULL, NULL, 'MLIB'),
('LISC 7402', 'Information Organization and Classification', NULL, NULL, 'MLIB'),
('LISC 7405', 'Industrial Training', NULL, NULL, 'MLIB'),
('LISC 7406', 'Directed Research', NULL, NULL, 'MLIB'),
('LISC 7410', 'Collection Development and Management', NULL, NULL, 'MLIB'),
('LISC 7411', 'Domain-Specific Taxonomy', NULL, NULL, 'MLIB'),
('LISC 7412', 'Archives and Records Management', NULL, NULL, 'MLIB'),
('LISC 7413', 'Library Assessment and Impact Evaluation', NULL, NULL, 'MLIB'),
('LISC 7414', 'Information Retrieval and Artificial Intelligence Literacy', NULL, NULL, 'MLIB'),
('LISC 7415', 'Bibliometrics and Science Mapping', NULL, NULL, 'MLIB'),
('LISC 7416', 'Management of Islamic Manuscripts', NULL, NULL, 'MLIB'),
('LISC 7417', 'Government Publications', NULL, NULL, 'MLIB'),
('LISC 7418', 'Preservation Management', NULL, NULL, 'MLIB'),
('LISC 7419', 'Web Design and Development', NULL, NULL, 'MLIB'),
('LISC 7420', 'Application of Information Technology in Library', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7421', 'Application of Information Technology in Library', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7422', 'Digital Library', NULL, NULL, 'MLIB'),
('LISC 7423', 'Web-Based Information Design and Development', NULL, NULL, 'MLIB'),
('LISC 7424', 'Information Processing and Database Development', NULL, NULL, 'MLIB'),
('LISC 7425', 'Digital Libraries', NULL, NULL, 'MLIB'),
('LISC 7426', 'Organization and Classification of Islamic Collection', NULL, NULL, 'MLIB'),
('LISC 7427', 'Database Design', NULL, NULL, 'MLIB'),
('LISC 7430', 'Digital Library', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7440', 'Information Processing and Database Development', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'MLIB'),
('LISC 7941', 'Fieldwork', NULL, NULL, 'MLIB'),
('LISC 7987', 'Research Proposal', NULL, NULL, 'MLIB'),
('LISC 7988', 'Directed Research Practicum', NULL, NULL, 'MLIB'),
('LISC 7989', 'LIS Research / Dissertation', NULL, NULL, 'MLIB'),
('LISC 8095', 'Comprehensive Examination', NULL, NULL, 'PLIB'),
('LISC 8290', 'Seminar in Human Information Behaviour', NULL, NULL, 'PLIB'),
('LISC 8380', 'Organization of Islamic Information', NULL, NULL, 'PLIB'),
('LISC 8390', 'Seminar in Organization of Information Resource', NULL, NULL, 'PLIB'),
('LISC 8410', 'Trends in Information Retrieval', NULL, NULL, 'PLIB'),
('LISC 8411', 'Statistics for Library and Information Professionals', NULL, NULL, 'PLIB'),
('LISC 8421', 'Quantitative Social Survey', NULL, NULL, 'PLIB'),
('LISC 8431', 'Advanced Qualitative Research Methods', NULL, NULL, 'PLIB'),
('LISC 8441', 'Information Seeking Behaviour', NULL, NULL, 'PLIB'),
('LISC 8442', 'Bibliographic Representation and Organization', NULL, NULL, 'PLIB'),
('LISC 8443', 'Digital Humanities for Islamic Collections', NULL, NULL, 'PLIB'),
('LISC 8444', 'Advances in Information Retrieval', NULL, NULL, 'PLIB'),
('LISC 8445', 'Library Systems', NULL, NULL, 'PLIB'),
('LISC 8446', 'Strategic Planning for Information Professionals', NULL, NULL, 'PLIB'),
('LISC 8447', 'Seminar in Metrics and Measures for Information Services', NULL, NULL, 'PLIB'),
('LISC 8448', 'Organizational Development in Information Institutions', NULL, NULL, 'PLIB'),
('LISC 8449', 'Trends in Information Research', NULL, NULL, 'PLIB'),
('LISC 8450', 'Planning & Management of Library Automation Systems', NULL, NULL, 'PLIB'),
('LISC 8810', 'Strategic Planning for Information Professional', NULL, NULL, 'PLIB'),
('LISC 8820', 'Organizational Development in Information Institutions', NULL, NULL, 'PLIB'),
('LISC 8890', 'Seminar in Measurement and Evaluation of Library and Information Services', NULL, NULL, 'PLIB'),
('LISC 8910', 'Statistics for Library & Information Professional', NULL, NULL, 'PLIB'),
('LISC 8920', 'Survey Research Method in Library & Information Science', NULL, NULL, 'PLIB'),
('LISC 8930', 'Qualitative Research Method in Library & Information Science', NULL, NULL, 'PLIB'),
('LISC 8980', 'Seminar in Current Trends and Issus in LIS', NULL, NULL, 'PLIB'),
('LISC 8995', 'Comprehensive Examination', NULL, NULL, 'PLIB'),
('LISC 8998', 'Dissertation', NULL, NULL, 'PLIB'),
('LISC 8999', 'Thesis', NULL, NULL, 'PLIB'),
('MIIT 7401', 'Islamic Worldview On ICT & Society', NULL, NULL, 'MITEC'),
('MIIT 7402', 'ICT Research Methods', NULL, NULL, 'MITEC'),
('MIIT 7410', 'Analytics and Visualisation', NULL, NULL, 'MITEC'),
('MIIT 7411', 'Digital Professional Practices ', NULL, NULL, 'MITEC'),
('MIIT 7412', 'IT Project Management and Methodologies ', NULL, NULL, 'MITEC'),
('MIIT 7420', 'Cybersecurity Challenges, Policy and Strategy ', NULL, NULL, 'MITEC'),
('MIIT 7421', 'Infrastructure as a Service ', NULL, NULL, 'MITEC'),
('MIIT 7422', 'Humanity Centred Design', NULL, NULL, 'MITEC'),
('MIIT 7423', 'Internet of Everything ', NULL, NULL, 'MITEC'),
('MIIT 7424', 'Digital Transformation ', NULL, NULL, 'MITEC'),
('MIIT 7425', 'IT Strategy and Governance ', NULL, NULL, 'MITEC'),
('MIIT 7426', 'Generative AI Applications ', NULL, NULL, 'MITEC'),
('MIIT 7427', 'Fintech in Islamic Finance ', NULL, NULL, 'MITEC'),
('MIIT 7502', 'IT Research Proposal', NULL, NULL, 'MITEC');

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
(1, 'INFO 4311', '4559', '2024-12-31', 'Class-Time', '69', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Take Home', 'in-class', 'no'),
(2, 'INFO 4311', '4559', '2025-01-14', 'Class-Time', '69', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Take Home', 'in-class', 'no'),
(3, 'CSCI 2301', '7132', '2025-01-16', 'Class-Time', '127', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'Final Assessment - Test', 'in-class', 'no'),
(4, 'INFO 4312', '3815', '2025-01-15', 'Class-Time', '74', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Test', 'in-class', 'no'),
(5, 'INFO 4312', '3815', '2025-01-17', '5:00pm - 8:00pm', '74', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Take Home', 'outside-class', 'no'),
(6, 'INFO 3308', '6856', '2025-01-15', 'Class-Time', '64', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(7, 'INFO 1302', '6856', '2025-01-16', 'Class-Time', '8', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(8, 'BICS 1303', '10738', '2025-01-13', 'Class-Time', '84', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 5 , Section 6 , Section 7 , Section 8', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(9, 'CSCI 4322', '8405', '2025-01-16', 'Class-Time', '18', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(10, 'INFO 4304', '4297', '2025-01-22', '9:00am - 1:00pm', '140', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BIT', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(11, 'CSCI 2302', '10722', '2025-01-06', 'Class-Time', '70', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2', 'Final Assessment - Test', 'in-class', 'no'),
(12, 'BICS 1305', '10722', '2025-01-06', 'Class-Time', '20', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(13, 'CSCI 2301', '10738', '2025-01-13', 'Class-Time', '84', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 5 , Section 6 , Section 7 , Section 8', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(14, 'CSCI 4347', '4870', '2025-01-16', 'Class-Time', '11', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(15, 'CSCI 2305', '10324', '2025-01-17', '9:00am - 1:00pm', '183', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'Final Assessment - Test', 'outside-class', 'no'),
(16, 'INFO 4342', '4295', '2025-01-20', '9:00am - 1:00pm', '69', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(17, 'INFO 4341', '4295', '2025-01-17', '9:00am - 1:00pm', '63', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1 , Section 2', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(18, 'INFO 4313', '5594', '2025-01-14', 'Class-Time', '42', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(19, 'INFO 4313', '5594', '2025-01-16', 'Class-Time', '42', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(20, 'INFO 1303', '4896', '2025-01-15', 'Class-Time', '2', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(21, 'CSCI 4343', '4964', '2025-01-21', '9:00am - 1:00pm', '51', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(22, 'CSCI 4321', '7620', '2025-01-14', 'Class-Time', '32', '2024-10-21 16:00:00', '2024-10-21 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(23, 'INFO 4314', '10400', '2025-01-15', 'Class-Time', '40', '2024-10-21 16:00:00', '2024-10-21 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(24, 'INFO 4314', '10400', '2025-01-15', 'Class-Time', '40', '2024-10-21 16:00:00', '2024-10-21 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(25, 'INFO 3304', '9471', '2025-01-15', 'Class-Time', '38', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BIT', 'Section 4', 'Final Assessment - Test', 'in-class', 'no'),
(26, 'INFO 3308', '6250', '2025-01-14', 'Class-Time', '49', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BIT', 'Section 3 , Section 4', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(27, 'INFO 4303', '6250', '2024-12-16', 'Class-Time', '36', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BIT', 'Section 5', 'Final Assessment - Take Home', 'in-class', 'no'),
(28, 'CSCI 4332', '9157', '2025-01-15', 'Class-Time', '40', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(29, 'CSCI 4336', '9157', '2025-01-15', 'Class-Time', '32', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'in-class', 'no'),
(30, 'INFO 4321', '8398', '2025-01-20', '2:00pm - 5:00pm', '31', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Take Home', 'outside-class', 'no'),
(31, 'CSCI 3301', '7910', '2025-01-20', '9:00am - 1:00pm', '160', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4', 'Final Assessment - Decentralized Exam', 'outside-class', 'no'),
(32, 'INFO 3304', '3904', '2025-01-13', 'Class-Time', '35', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(33, 'INFO 3304', '3904', '2025-01-14', 'Class-Time', '35', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(34, 'INFO 3304', '3904', '2025-01-14', 'Class-Time', '35', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 2', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(35, 'CSCI 3300', '9622', '2025-01-17', '2:00pm - 5:00pm', '182', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BCS', 'Section 1 , Section 2 , Section 3 , Section 4 , Section 5 , Section 6', 'Final Assessment - Test', 'outside-class', 'no'),
(36, 'INFO 4303', '6202', '2025-01-14', 'Class-Time', '40', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 3 , Section 4 , Section 6', 'Final Assessment - Decentralized Exam', 'in-class', 'no'),
(37, 'INFO 4325', '11085', '2025-01-03', 'Class-Time', '30', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Take Home', 'in-class', 'no'),
(38, 'INFO 4328', '11085', '2025-01-02', 'Class-Time', '18', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Take Home', 'in-class', 'no'),
(39, 'CSCI 2304', '4296', '2025-01-10', 'Class-Time', '64', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 2 , Section 3', 'Final Assessment - Test', 'in-class', 'no'),
(40, 'CSCI 4340', '4296', '2025-01-15', 'Class-Time', '63', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1 , Section 2', 'Final Assessment - Test', 'in-class', 'no'),
(41, 'CSCI 4342', '4615', '2025-01-21', '2:00pm - 5:00pm', '42', '2024-10-24 16:00:00', '2024-10-24 16:00:00', 'BCS', 'Section 1', 'Final Assessment - Test', 'outside-class', 'no'),
(42, 'INFO 4335', '4621', '2025-01-16', 'Class-Time', '30', '2024-11-03 16:00:00', '2024-11-03 16:00:00', 'BIT', 'Section 1', 'Final Assessment - Test', 'in-class', 'no');

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
(1, 'LISC 7402', '8227', '2024-12-31', 'Class-Time', '4', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(2, 'LISC 7020', '8227', '2025-01-04', 'Class-Time', '1', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(3, 'LISC 7074', '9019', '2025-01-04', 'Class-Time', '1', '2024-10-17 16:00:00', '2024-10-17 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(4, 'LISC 7073', '7684', '2025-01-14', 'Class-Time', '1', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(5, 'CBIA 7101', '4896', '2025-01-16', 'Class-Time', '10', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'MBIA', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(6, 'CBIA 7202', '4964', '2024-12-16', 'Class-Time', '10', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'MBIA', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'yes'),
(7, 'CBIA 7202', '4964', '2024-12-29', 'Class-Time', '10', '2024-10-20 16:00:00', '2024-10-20 16:00:00', 'MBIA', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(8, 'INFO 7145', '7620', '2025-01-14', 'Class-Time', '4', '2024-10-21 16:00:00', '2024-10-21 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(9, 'INFO 7151', '6250', '2024-12-19', 'Class-Time', '3', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(10, 'INFO 7271', '10402', '2024-12-16', '9:00am - 1:00pm', '5', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'outside-class', 'no'),
(11, 'MIIT 7422', '10402', '2024-12-16', '2:00pm - 5:00pm', '3', '2024-10-22 16:00:00', '2024-10-22 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'outside-class', 'yes'),
(12, 'INFO 7231', '6202', '2024-12-16', 'Class-Time', '4', '2024-10-23 16:00:00', '2024-10-23 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(13, 'LISC 8810', '7684', '2025-01-15', 'Class-Time', '1', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'PLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(14, 'LISC 7071', '9041', '2025-01-09', 'Class-Time', '4', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(15, 'LISC 8820', '7684', '2025-01-16', 'Class-Time', '1', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'PLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(16, 'LISC 7421', '9041', '2025-01-09', 'Class-Time', '2', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(17, 'LISC 8290', '9041', '2024-12-31', 'Class-Time', '1', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'PLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(18, 'LISC 7199', '9019', '2025-01-04', 'Class-Time', '2', '2024-10-27 16:00:00', '2024-10-27 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(19, 'LISC 7401', '1675', '2025-01-14', 'Class-Time', '5', '2024-10-28 16:00:00', '2024-10-28 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(20, 'LISC 7988', '1675', '2025-01-15', 'Class-Time', '5', '2024-10-28 16:00:00', '2024-10-28 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(21, 'LISC 7422', '1675', '2025-01-16', 'Class-Time', '5', '2024-10-28 16:00:00', '2024-10-28 16:00:00', 'MLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no'),
(22, 'INFO 7901', '4621', '2025-01-22', '5:00pm - 8:00pm', '30', '2024-11-03 16:00:00', '2024-11-03 16:00:00', 'MITEC', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'outside-class', 'no'),
(23, 'LISC 8910', '9019', '2025-01-10', 'Class-Time', '1', '2024-12-18 16:00:00', '2024-12-18 16:00:00', 'PLIB', 'Section 1', 'Final Assessment  - Test, Research Proposal, Research Paper', 'in-class', 'no');

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
('MLIB', 'Master of Library and Information Science', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PLIB', 'Doctor of Philosophy in Library and Information Science', NULL, NULL);

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
('1JRlT3T0FGvsYyd4wQAted9EYOoM7VENj0BLipz3', NULL, '10.111.8.206', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnZ0N203S3FFcW1QYWdZYW54d1pPR3B0S3NzQ1R2YUc0eENYbzdvMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1Ny9QR0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733712942),
('2R2Q08UGMnOqYlnJD8tOxi0jeKXgDx6oZ2X8zQGM', NULL, '10.101.229.254', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2hFZFk1VVVSUmFhZ2s2VlNOSVU5bUl2bFNKaWk5TVF3R3RHdDVCQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1Ny9QR0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733443318),
('5pc33qQLDD1jQMOySELOdmsQkKvnN7Z9lB0ba3aP', NULL, '10.101.229.70', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1pMa1ZMTTB4VFAwSW14MjRUN2kwM0RjSnp1NUNGaTd5OXFTendySiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1Ny9QR0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733386692),
('AXZ8FATQGkwJ1gUHTubZm59hBtsRsdXABI6nQgzU', NULL, '10.111.57.80', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDFJUEdHOWFYV2lCeWREd0RhYVdoU3VhSFRaS252bnRIb3FSQjhhOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1NyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1736731867),
('DRZLbJP8MIYxup3walKjHpVXkrtepS08VeD7ey6q', NULL, '10.111.208.125', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWlCekxQYmM4NkhYQmx3MmhsenRtbWRxQmthQ0dIdnJNYTIyNHVseCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1Ny9QR0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738809818),
('EbYYTipVT0qT3hC2CIyDssIBbTv3mEqvmXRbd8p7', NULL, '10.101.229.254', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzNDZ05FUktKSDVYZWFMY3JwcEtxM05jRDRLYlA0WVYyOGVIQm44SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1Ny9QR0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733387111),
('KnJGRxfiO1C8NulT5TZVlwFLVFlCIvw9cpGi3wC5', NULL, '10.111.63.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGZJVUVkMnFsM2JFTUlFNERXZERNa0NzZThyYzVEdzY4ZW9neUp5MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1Ny9QR0RlY2VudHJhbGlzZWQtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733468634),
('nUHFIEudYcz86w6qPRa5BuHq6vt8nJUdyufgVXiv', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFlwSnZiOEpzUzE3NDdzbHlKS3c3RXhiV0VIWmxzd21PSVpqTFN2RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741313391),
('zznTPrBZdSq03Wr4GU9zhIRH9tGBt9PGebDzrLwf', NULL, '10.111.40.68', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1NZUjBDSzRSWnl5dHdMclJSSDVPazVPaDNEUDFwREZUMlJqWmhkNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMC4xMDEuMjI5LjE1NyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734585630);

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
('11285', 'MIMI LIZA BT ABDUL MAJID', NULL, NULL),
('11417', 'NOR AZURA BT KAMARULZAMAN', NULL, NULL),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `decentraliseds`
--
ALTER TABLE `decentraliseds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
