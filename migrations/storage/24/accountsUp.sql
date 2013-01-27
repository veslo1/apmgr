-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 15, 2010 at 02:04 PM
-- Server version: 5.1.46
-- PHP Version: 5.3.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Dumping data for table `account`
--

REPLACE INTO `account` (`id`, `dateCreated`, `dateUpdated`, `name`, `number`, `orientation`) VALUES
(1, '2010-05-04 14:07:52', '2010-05-15 13:53:02', 'Rent Revenue', 1, 'credit'),
(2, '2010-05-15 13:52:26', '2010-05-15 14:04:09', 'Rent Receivable', 2, 'debit'),
(3, '2010-05-15 13:53:42', '2010-05-15 13:53:42', 'Rent Discount', 3, 'debit'),
(4, '2010-05-15 13:55:15', '2010-05-15 13:55:15', 'Cancelled Rent', 4, 'debit');

-- --------------------------------------------------------

--
-- Dumping data for table `accountLink`
--

REPLACE INTO `accountLink` (`id`, `dateCreated`, `dateUpdated`, `name`, `debitAccountId`, `creditAccountId`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'rentRevenue', 2, 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'rentDiscount', 3, 2),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'leaseCancellationRentPortion', 1, 1),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'leaseCancellationDiscountPortion', 2, 4);

INSERT INTO `apmgr`.`messages` (`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`) VALUES 
('Access Denied. ', 'accessDenied', 'error', 'en_US', '1', '', NULL ),
('Error saving.  Please contact technical support.', 'errorSaving', 'error', 'en_US', '1', '', NULL );

SET FOREIGN_KEY_CHECKS=1;

