-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2010 at 06:40 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantAuthorization`
--

DROP TABLE IF EXISTS `applicantAuthorization`;
CREATE TABLE IF NOT EXISTS `applicantAuthorization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `applicantSignature` varchar(50) NOT NULL,
  `spouseSignature` varchar(50) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `applicantSignature` (`applicantSignature`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Applicant signature accepting the regulations' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantAuthorization`
--

SET FOREIGN_KEY_CHECKS=1;
