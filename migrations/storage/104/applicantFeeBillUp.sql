-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2010 at 10:27 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantFeeBill`
--

DROP TABLE IF EXISTS `applicantFeeBill`;
CREATE TABLE IF NOT EXISTS `applicantFeeBill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` INT(11) NOT NULL, 
  `feeId` int(10) unsigned NOT NULL,
  `billId` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantId` (`applicantId`),
  KEY `feeId` (`feeId`),
  KEY `billId` (`billId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relation between the applicant and the payment' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicantFeeBill`
--
ALTER TABLE `applicantFeeBill`
  ADD CONSTRAINT `applicantfeebill_ibfk_2` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applicantfeebill_ibfk_1` FOREIGN KEY (`feeId`) REFERENCES `fee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applicantfeebill_ibfk_3` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;