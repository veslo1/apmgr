-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2010 at 08:45 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantAppliance`
--

DROP TABLE IF EXISTS `applicantAppliance`;
CREATE TABLE IF NOT EXISTS `applicantAppliance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `unitId` int(11) unsigned NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantId` (`applicantId`),
  KEY `unitId` (`unitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that displays to which table an applicant applied' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantAppliance`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicantAppliance`
--
ALTER TABLE `applicantAppliance`
  ADD CONSTRAINT `applicantAppliance_ibfk_2` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applicantAppliance_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;