-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 12, 2010 at 04:01 PM
-- Server version: 5.1.46
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `apmgr_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantTransactions`
--

DROP TABLE IF EXISTS `applicantTransactions`;
CREATE TABLE IF NOT EXISTS `applicantTransactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `name` char(15) NOT NULL,
  `page` varchar(50) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `payload` text NOT NULL,
  `current` tinyint(4) NOT NULL DEFAULT '0',
  `action` varchar(50) NOT NULL,
  `next` char(15) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `action` (`action`),
  KEY `next` (`next`),
  FULLTEXT KEY `payload` (`payload`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table that holds the applicant steps through our application' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantTransactions`
--
