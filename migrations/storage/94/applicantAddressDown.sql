-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2010 at 11:13 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantAddress`
--

DROP TABLE IF EXISTS `applicantAddress`;
CREATE TABLE IF NOT EXISTS `applicantAddress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `phone` char(9) DEFAULT NULL,
  `rent` decimal(10,2) NOT NULL,
  `apartmentName` varchar(255) DEFAULT NULL,
  `ownerName` varchar(255) DEFAULT NULL,
  `apartmentPhone` varchar(9) NOT NULL,
  `moveInDate` date NOT NULL,
  `moveOutDate` date DEFAULT NULL,
  `reasonForLeaving` varchar(500) DEFAULT NULL,
  `isCurrentResidence` tinyint(1) DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant address info' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantAddress`
--

