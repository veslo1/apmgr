-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 23, 2010 at 10:15 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `rentalAnswers`
--

DROP TABLE IF EXISTS `rentalAnswers`;
CREATE TABLE IF NOT EXISTS `rentalAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answer` (`answer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Answers for the rental application how did you find us table' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rentalAnswers`
--


-- --------------------------------------------------------

--
-- Table structure for table `rentalQuestions`
--

DROP TABLE IF EXISTS `rentalQuestions`;
CREATE TABLE IF NOT EXISTS `rentalQuestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(30) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Questions for the rental application form regarding how did ' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rentalQuestions`
--

