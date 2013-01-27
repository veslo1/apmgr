-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 13, 2010 at 11:25 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
CREATE TABLE IF NOT EXISTS `applicant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant address info' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `applicantAnswers`
--

DROP TABLE IF EXISTS `applicantAnswers`;
CREATE TABLE IF NOT EXISTS `applicantAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `questionId` int(11) DEFAULT NULL,
  `answerId` int(11) DEFAULT NULL,
  `extraQuestionOne` text,
  `extraQuestionTwo` text,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`),
  KEY `questionId` (`questionId`),
  KEY `answerId` (`answerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Answers that the user may provide' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `applicantAuthorization`
--

DROP TABLE IF EXISTS `applicantAuthorization`;
CREATE TABLE IF NOT EXISTS `applicantAuthorization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `applicantSignature` varchar(50) NOT NULL,
  `spouseSignature` varchar(50) DEFAULT NULL,
  `acceptedContract` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`),
  KEY `applicantSignature` (`applicantSignature`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Applicant signature accepting the regulations' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `applicantCreditHistory`
--

DROP TABLE IF EXISTS `applicantCreditHistory`;
CREATE TABLE IF NOT EXISTS `applicantCreditHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantId` int(11) NOT NULL,
  `bankName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `zip` int(11) NOT NULL,
  `creditCards` varchar(255) NOT NULL,
  `nonWorkIncome` varchar(255) NOT NULL,
  `creditProblems` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant credit history info' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `applicantEmergencyContact`
--

DROP TABLE IF EXISTS `applicantEmergencyContact`;
CREATE TABLE IF NOT EXISTS `applicantEmergencyContact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantId` int(11) NOT NULL,
  `contactName` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `zip` int(11) NOT NULL,
  `mainPhone` varchar(10) NOT NULL,
  `workPhone` varchar(10) DEFAULT NULL,
  `relationship` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact info' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `applicantEmergencyContactChoice`
--

DROP TABLE IF EXISTS `applicantEmergencyContactChoice`;
CREATE TABLE IF NOT EXISTS `applicantEmergencyContactChoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `choice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `applicantEmergencyContactChoice`
--

REPLACE INTO `applicantEmergencyContactChoice` (`id`, `dateCreated`, `dateUpdated`, `choice`) VALUES
(1, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'abovePerson'),
(2, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'yourSpouse'),
(3, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'parentChild');

-- --------------------------------------------------------

--
-- Table structure for table `applicantEmergencyContactChoiceAnswer`
--

DROP TABLE IF EXISTS `applicantEmergencyContactChoiceAnswer`;
CREATE TABLE IF NOT EXISTS `applicantEmergencyContactChoiceAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantId` int(11) NOT NULL,
  `applicantEmergencyContactChoiceId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantEmergencyContactChoiceId` (`applicantEmergencyContactChoiceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact answer' AUTO_INCREMENT=2 ;

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
-- Table structure for table `applicantPersonalInfo`
--

DROP TABLE IF EXISTS `applicantPersonalInfo`;
CREATE TABLE IF NOT EXISTS `applicantPersonalInfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `streetAddress` varchar(255) NOT NULL,
  `identification` int(11) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') NOT NULL,
  `formerLastName` varchar(255) DEFAULT NULL,
  `ssn` int(11) NOT NULL,
  `dob` date NOT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `sex` enum('m','f') NOT NULL,
  `eyeColor` varchar(20) NOT NULL,
  `hairColor` varchar(50) NOT NULL,
  `maritalStatus` enum('single','married','divorced','widowed','separated') NOT NULL,
  `usCitizen` enum('yes','no') NOT NULL,
  `smoke` enum('yes','no') NOT NULL,
  `havePets` enum('yes','no') DEFAULT NULL,
  `petDetails` varchar(255) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`),
  KEY `fullName` (`fullName`),
  KEY `streetAddress` (`streetAddress`),
  KEY `ssn` (`ssn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant personal info' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `applicantRentalCriminalHistory`
--

DROP TABLE IF EXISTS `applicantRentalCriminalHistory`;
CREATE TABLE IF NOT EXISTS `applicantRentalCriminalHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantId` int(11) NOT NULL,
  `crimeComment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant credit history info' AUTO_INCREMENT=16 ;

--
-- Dumping data for table `applicantRentalCriminalHistory`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantRentalCriminalHistoryAnswer`
--

DROP TABLE IF EXISTS `applicantRentalCriminalHistoryAnswer`;
CREATE TABLE IF NOT EXISTS `applicantRentalCriminalHistoryAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantRentalCriminalHistoryId` int(11) NOT NULL,
  `applicantRentalCriminalHistoryQuestionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantRentalCriminalHistoryId` (`applicantRentalCriminalHistoryId`),
  KEY `applicantRentalCriminalHistoryQuestionId` (`applicantRentalCriminalHistoryQuestionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal answer' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantRentalCriminalHistoryAnswer`
--


-- --------------------------------------------------------

--
-- Table structure for table `applicantRentalCriminalHistoryQuestion`
--

DROP TABLE IF EXISTS `applicantRentalCriminalHistoryQuestion`;
CREATE TABLE IF NOT EXISTS `applicantRentalCriminalHistoryQuestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `applicantRentalCriminalHistoryQuestion`
--

REPLACE INTO `applicantRentalCriminalHistoryQuestion` (`id`, `dateCreated`, `dateUpdated`, `question`) VALUES
(1, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'beenEvicted'),
(2, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'movedBeforeEndOfLease'),
(3, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'declaredBankruptcy'),
(4, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'suedForRent'),
(5, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'suedForPropertyDamage'),
(6, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'resolvedCrime'),
(7, '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'notResolvedCrime');

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
-- Table structure for table `applicantTransactions`
--

DROP TABLE IF EXISTS `applicantTransactions`;
CREATE TABLE IF NOT EXISTS `applicantTransactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) DEFAULT NULL,
  `name` char(15) NOT NULL,
  `page` varchar(50) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `payload` text NOT NULL,
  `current` tinyint(4) NOT NULL DEFAULT '0',
  `action` varchar(50) DEFAULT NULL,
  `next` text NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL COMMENT 'Not used',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `action` (`action`),
  FULLTEXT KEY `payload` (`payload`),
  FULLTEXT KEY `next` (`next`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table that holds the applicant steps through our application' AUTO_INCREMENT=32 ;

--
-- Dumping data for table `applicantTransactions`
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


-- --------------------------------------------------------

--
-- Table structure for table `applicantWorkflowStatus`
--

DROP TABLE IF EXISTS `applicantWorkflowStatus`;
CREATE TABLE IF NOT EXISTS `applicantWorkflowStatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL COMMENT 'Date this record was created',
  `description` text COMMENT 'Description of why the change was triggered',
  `status` enum('pending','rejected','accepted') NOT NULL,
  `previousStatus` enum('pending','rejected','accepted') NOT NULL,
  `current` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `applicantId` (`applicantId`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='History of the status of a user in the system' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantWorkflowStatus`
--


-- --------------------------------------------------------

--
-- Table structure for table `applicantWorkHistory`
--

DROP TABLE IF EXISTS `applicantWorkHistory`;
CREATE TABLE IF NOT EXISTS `applicantWorkHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantId` int(11) NOT NULL,
  `employerName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') NOT NULL,
  `zip` int(11) NOT NULL,
  `employerPhone` varchar(10) DEFAULT NULL,
  `monthlyIncome` decimal(10,2) NOT NULL,
  `dateStarted` date NOT NULL,
  `dateEnded` date DEFAULT NULL,
  `supervisorName` varchar(255) NOT NULL,
  `supervisorPhone` varchar(10) NOT NULL,
  `isCurrentEmployer` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`applicantId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant work history info' AUTO_INCREMENT=2 ;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant`
--
ALTER TABLE `applicant`
  ADD CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `applicantEmergencyContactChoiceAnswer`
--
ALTER TABLE `applicantEmergencyContactChoiceAnswer`
  ADD CONSTRAINT `applicantEmergencyContactChoiceAnswer_ibfk_1` FOREIGN KEY (`applicantEmergencyContactChoiceId`) REFERENCES `applicantEmergencyContactChoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `applicantRentalCriminalHistoryAnswer`
--
ALTER TABLE `applicantRentalCriminalHistoryAnswer`
  ADD CONSTRAINT `applicantRentalCriminalHistoryAnswer_ibfk_1` FOREIGN KEY (`applicantRentalCriminalHistoryId`) REFERENCES `applicantRentalCriminalHistory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applicantRentalCriminalHistoryAnswer_ibfk_2` FOREIGN KEY (`applicantRentalCriminalHistoryQuestionId`) REFERENCES `applicantRentalCriminalHistoryQuestion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;