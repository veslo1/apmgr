-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2010 at 10:21 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantAnswers`
--

DROP TABLE IF EXISTS `applicantAnswers`;
CREATE TABLE IF NOT EXISTS `applicantAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) DEFAULT NULL,
  `answerId` int(11) DEFAULT NULL,
  `extraQuestionOne` text,
  `extraQuestionTwo` text,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `questionId` (`questionId`),
  KEY `answerId` (`answerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Answers that the user may provide' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantAnswers`
--

SET FOREIGN_KEY_CHECKS=1;
