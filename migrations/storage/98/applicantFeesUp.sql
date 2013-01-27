-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2010 at 05:25 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

DROP TABLE IF EXISTS `applicantSettings`;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantFeeName`
--

DROP TABLE IF EXISTS `applicantFeeName`;
CREATE TABLE IF NOT EXISTS `applicantFeeName` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(3))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The name of the versioned settings fees' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `applicantFeeName`
--

REPLACE INTO `applicantFeeName` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES
(1, 'applicationFee', '2010-08-01 17:21:15', '2010-08-01 17:21:17'),
(2, 'appDeposit', '2010-08-01 17:21:31', '2010-08-01 17:21:34'),
(3, 'admFee', '2010-08-01 17:21:46', '2010-08-01 17:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `applicantFeeParent`
--

DROP TABLE IF EXISTS `applicantFeeParent`;
CREATE TABLE IF NOT EXISTS `applicantFeeParent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `userId` int(11) NOT NULL COMMENT 'The user id that generates the version',
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Parent table for versioned applicant fee settings' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `applicantFeeParent`
--

REPLACE INTO `applicantFeeParent` (`id`, `dateCreated`, `dateUpdated`, `userId`, `comment`) VALUES
(1, '2010-08-01 17:22:26', '2010-08-01 17:22:31', 1, 'Creating the first application fee'),
(2, '2010-08-01 17:22:55', '2010-08-01 17:22:58', 1, 'Creating the first appDeposit fee'),
(3, '2010-08-01 17:23:06', '2010-08-01 17:23:11', 1, 'Creating the first admFee setting');

-- --------------------------------------------------------

--
-- Table structure for table `applicantFeeValue`
--

DROP TABLE IF EXISTS `applicantFeeValue`;
CREATE TABLE `applicantFeeValue` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nameId` int(11) NOT NULL,
 `parentId` int(11) NOT NULL,
 `value` decimal(10,2) NOT NULL,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `nameId` (`nameId`),
 KEY `parentId` (`parentId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Value for versioned applicant fees';

--
-- Dumping data for table `applicantFeeValue`
--

REPLACE INTO `applicantFeeValue` (`id`, `nameId`, `parentId`, `value`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 1, '50', '2010-07-11 15:26:33', '2010-07-11 16:46:32'),
(2, 2, 2, '10', '2010-07-11 18:26:21', '2010-07-11 18:26:21'),
(3, 3, 3, '10', '2010-07-11 18:37:21', '2010-07-11 18:37:21');
