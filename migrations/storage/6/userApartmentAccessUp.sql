-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2010 at 04:07 PM
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
-- Table structure for table `apartmentTransaction`
--

CREATE TABLE IF NOT EXISTS `apartmentTransaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `apartmentId` int(10) unsigned NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `apartmentId` (`apartmentId`),
  KEY `unitId` (`unitId`),
  KEY `transactionId` (`transactionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `apartmentTransaction`
--

REPLACE INTO `apartmentTransaction` (`id`, `dateCreated`, `dateUpdated`, `apartmentId`, `unitId`, `transactionId`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1, 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `userApartmentAccess`
--

CREATE TABLE IF NOT EXISTS `userApartmentAccess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `apartmentId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `apartmentId` (`apartmentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds the apartments the logged in user can access' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `userApartmentAccess`
--

REPLACE INTO `userApartmentAccess` (`id`, `dateCreated`, `dateUpdated`, `userId`, `apartmentId`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2);
SET FOREIGN_KEY_CHECKS=1;
