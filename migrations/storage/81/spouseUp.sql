-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 09, 2010 at 07:16 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantOccupants`
--

DROP TABLE IF EXISTS `applicantOccupants`;
CREATE TABLE IF NOT EXISTS `applicantOccupants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `relationship` char(12) DEFAULT NULL,
  `sex` enum('m','f') DEFAULT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `ssn` int(11) DEFAULT NULL,
  `identification` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `dateCreated` date NOT NULL,
  `dateUpdated` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Other occupants that will reside in the property with the si' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantOccupants`
--


-- --------------------------------------------------------

--
-- Table structure for table `applicantSpouse`
--

DROP TABLE IF EXISTS `applicantSpouse`;
CREATE TABLE IF NOT EXISTS `applicantSpouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `fullName` varchar(250) DEFAULT NULL,
  `ssn` int(11) DEFAULT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `cityStateZip` text,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `sex` enum('m','f') DEFAULT NULL,
  `eyeColor` varchar(30) DEFAULT NULL,
  `hairColor` varchar(30) DEFAULT NULL,
  `usCitizen` enum('yes','no') DEFAULT NULL,
  `workPhone` varchar(50) DEFAULT NULL,
  `cellPhone` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `emailAddress` varchar(250) DEFAULT NULL,
  `dateBeganJob` date DEFAULT NULL,
  `income` double DEFAULT NULL,
  `superVisorName` varchar(250) DEFAULT NULL,
  `superVisorPhone` varchar(50) DEFAULT NULL,
  `dateCreated` int(11) NOT NULL,
  `dateUpdated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spouse information' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantSpouse`
--


-- --------------------------------------------------------

--
-- Table structure for table `applicantVehicles`
--

DROP TABLE IF EXISTS `applicantVehicles`;
CREATE TABLE IF NOT EXISTS `applicantVehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `license` char(9) DEFAULT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`),
  KEY `brand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Applicants vehicles or his occupants vehicles' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantVehicles`
--

SET FOREIGN_KEY_CHECKS=1;
