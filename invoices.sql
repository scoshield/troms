-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2022 at 04:23 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tromflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaction_invoices`
--

DROP TABLE IF EXISTS `transaction_invoices`;
CREATE TABLE IF NOT EXISTS `transaction_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(170) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_amount` double NOT NULL,
  `delivery_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_note` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_note_amount` int(11) DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `dnote_date` date DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `level` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `tracking_no` varchar(170) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_date` date DEFAULT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `file_number` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_invoices`
--

INSERT INTO `transaction_invoices` (`id`, `invoice_number`, `invoice_amount`, `delivery_note`, `credit_note`, `credit_note_amount`, `invoice_date`, `dnote_date`, `comments`, `level`, `created_at`, `updated_at`, `user_id`, `currency_id`, `tracking_no`, `tracking_date`, `invoice_id`, `file_number`) VALUES
(1, '756984', 19000, 'NA', 'NA', 0, '2022-10-18', '2022-10-18', 'NA', 0, '2022-10-18 13:21:05', '2022-10-18 13:24:12', 4, 2, '60187', '2022-10-18', 1, '56314'),
(2, '25489', 19000, 'NA', 'NA', 0, '2022-10-18', '2022-10-18', 'NA', 0, '2022-10-18 13:46:47', '2022-10-18 13:47:20', 4, 1, '236541', '2022-10-18', 2, '987654'),
(3, '93467', 30000, 'NA', 'NA', 0, '2022-10-18', '2022-10-18', 'NA', 0, '2022-10-18 14:01:15', '2022-10-18 14:01:15', 4, 2, '12321', '2022-10-18', NULL, '1234');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
