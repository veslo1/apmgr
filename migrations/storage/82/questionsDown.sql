-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 09, 2010 at 06:05 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantAnswers`
--

DROP TABLE IF EXISTS `applicantAnswers`;
CREATE TABLE IF NOT EXISTS `applicantAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `whereYouRefered` text,
  `howDidYouFindUs` text,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Answers that the user may provide' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantAnswers`
--

DROP TABLE `rentalAnswers`;
DROP TABLE `rentalQuestions`;