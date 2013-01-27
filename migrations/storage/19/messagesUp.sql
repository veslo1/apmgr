-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2010 at 03:56 PM
-- Server version: 5.1.45
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
-- Table structure for table `messages`
--

REPLACE INTO `messages` (id,message,identifier,category,language,locked,dateCreated,dateUpdated) VALUES 
(43, 'The operation cannot continue. There is only one occurence left', 'etDeleteBlock', 'warning', 'en_US', 1, '2010-04-24 22:51:43', NULL),
(44, 'The limit of allowed files has been reached', 'quotaLimit', 'error', 'en_US', 1, '2010-05-08 23:24:19', NULL),
(45, 'The directory couldn''t be created. Please ask for permissions.', 'directoryFail', 'warning', 'en_US', 1, '2010-05-08 23:40:49', NULL),
(46, 'The unit id is missing', 'unitIdMissing', 'error', 'en_US', 1, '2010-05-08 23:41:51', NULL),
(47, 'The transfer could not succeed', 'transferFail', 'error', 'en_US', 1, '2010-05-09 14:37:47', NULL);
