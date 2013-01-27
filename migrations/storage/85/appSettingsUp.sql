-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2010 at 06:51 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantSetting`
--

DROP TABLE IF EXISTS `applicantSetting`;
CREATE TABLE IF NOT EXISTS `applicantSetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(15) NOT NULL,
  `value` varchar(40) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Settings for applicant' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `applicantSetting`
--

REPLACE INTO `applicantSetting` (`id`, `name`, `value`, `disabled`, `dateCreated`, `dateUpdated`) VALUES
(1, 'applicationFee', '50', 1, '2010-07-11 15:26:33', '2010-07-11 16:46:32'),
(2, 'appDeposit', '10', 0, '2010-07-11 18:26:21', '2010-07-11 18:26:21'),
(3, 'admFee', '10', 0, '2010-07-11 18:37:21', '2010-07-11 18:37:21');
