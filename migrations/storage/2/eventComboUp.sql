-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2010 at 12:58 AM
-- Server version: 5.0.90
-- PHP Version: 5.2.13-pl0-gentoo

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL,
  `title` char(12) NOT NULL,
  `data` text NOT NULL,
  `allDayEvent` tinyint(1) NOT NULL default '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`owner`),
  KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The events table that holds the particular event' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `events`
--

REPLACE INTO `events` (`id`, `owner`, `title`, `data`, `allDayEvent`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 'Therion', 'This is a test to create an event.\r\nTable fucked up', 0, '2010-04-08 22:39:57', '2010-04-08 22:39:57'),
(2, 1, 'MegaTherion', 'Testing recursive', 1, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(3, 1, 'Mashop', 'Fuck this shit.', 0, '2010-04-10 16:15:10', '2010-04-10 16:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `eventsNotification`
--

DROP TABLE IF EXISTS `eventsNotification`;
CREATE TABLE IF NOT EXISTS `eventsNotification` (
  `id` int(11) NOT NULL auto_increment,
  `eventId` int(11) NOT NULL,
  `guestId` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `eventId` (`eventId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `eventsNotification`
--

REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 2, 0, '2010-04-08 22:39:58', '2010-04-08 22:39:58'),
(2, 1, 3, 0, '2010-04-08 22:39:58', '2010-04-08 22:39:58'),
(3, 1, 5, 0, '2010-04-08 22:39:58', '2010-04-08 22:39:58'),
(4, 2, 2, 0, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(5, 2, 3, 0, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(6, 2, 5, 0, '2010-04-08 22:43:24', '2010-04-08 22:43:24');

-- --------------------------------------------------------

--
-- Table structure for table `eventsTime`
--

DROP TABLE IF EXISTS `eventsTime`;
CREATE TABLE IF NOT EXISTS `eventsTime` (
  `id` int(11) NOT NULL auto_increment,
  `startDate` date NOT NULL COMMENT 'The date that this event happens',
  `endDate` date NOT NULL,
  `startTime` time NOT NULL COMMENT 'When this event starts',
  `endTime` time NOT NULL COMMENT 'When this event ends',
  `eventId` int(11) NOT NULL COMMENT 'Which is the parent event',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `eventId` (`eventId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `eventsTime`
--

REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES
(1, '2010-04-08', '2010-04-08', '12:00:00', '13:00:00', 1, '2010-04-08 22:39:58', '2010-04-08 22:39:58'),
(2, '2010-04-09', '2010-04-09', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(3, '2010-04-10', '2010-04-10', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(4, '2010-04-11', '2010-04-11', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(5, '2010-04-12', '2010-04-12', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(6, '2010-04-13', '2010-04-13', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(7, '2010-04-14', '2010-04-14', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(8, '2010-04-15', '2010-04-15', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24'),
(9, '2010-04-10', '2010-04-10', '14:00:00', '15:00:00', 3, '2010-04-10 16:15:10', '2010-04-10 16:15:10');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventsNotification`
--
ALTER TABLE `eventsNotification`
  ADD CONSTRAINT `eventsNotification_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventsTime`
--
ALTER TABLE `eventsTime`
  ADD CONSTRAINT `eventsTime_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;