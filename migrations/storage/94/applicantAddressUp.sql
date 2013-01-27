-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2010 at 11:13 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS=0;
--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicantAddress`
--

DROP TABLE IF EXISTS `applicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant`
--

LOCK TABLES `applicant` WRITE;
/*!40000 ALTER TABLE `applicant` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantAddress`
--

DROP TABLE IF EXISTS `applicantAddress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantAddress` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') default NULL,
  `phone` char(10) default NULL,
  `rent` decimal(10,2) NOT NULL,
  `apartmentName` varchar(255) default NULL,
  `ownerName` varchar(255) default NULL,
  `apartmentPhone` varchar(9) NOT NULL,
  `moveInDate` date NOT NULL,
  `moveOutDate` date default NULL,
  `reasonForLeaving` varchar(500) default NULL,
  `isCurrentResidence` tinyint(1) default '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`),
  CONSTRAINT `applicantAddress_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant address info';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantAddress`
--

LOCK TABLES `applicantAddress` WRITE;
/*!40000 ALTER TABLE `applicantAddress` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantAddress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantAnswers`
--

DROP TABLE IF EXISTS `applicantAnswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantAnswers` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `questionId` int(11) default NULL,
  `answerId` int(11) default NULL,
  `extraQuestionOne` text,
  `extraQuestionTwo` text,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`),
  KEY `questionId` (`questionId`),
  KEY `answerId` (`answerId`),
  CONSTRAINT `applicantAnswers_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Answers that the user may provide';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantAnswers`
--

LOCK TABLES `applicantAnswers` WRITE;
/*!40000 ALTER TABLE `applicantAnswers` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantAnswers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantAuthorization`
--

DROP TABLE IF EXISTS `applicantAuthorization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantAuthorization` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `applicantSignature` varchar(50) NOT NULL,
  `spouseSignature` varchar(50) default NULL,
  `acceptedContract` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`applicantId`),
  KEY `applicantSignature` (`applicantSignature`),
  CONSTRAINT `applicantAuthorization_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Applicant signature accepting the regulations';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantAuthorization`
--

LOCK TABLES `applicantAuthorization` WRITE;
/*!40000 ALTER TABLE `applicantAuthorization` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantAuthorization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantCreditHistory`
--

DROP TABLE IF EXISTS `applicantCreditHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantCreditHistory` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `applicantId` int(11) NOT NULL,
  `bankName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') default NULL,
  `zip` int(11) NOT NULL,
  `creditCards` varchar(255) NOT NULL,
  `nonWorkIncome` varchar(255) NULL,
  `creditProblems` varchar(255) NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`),
  CONSTRAINT `applicantCreditHistory_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant credit history info';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantCreditHistory`
--

LOCK TABLES `applicantCreditHistory` WRITE;
/*!40000 ALTER TABLE `applicantCreditHistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantCreditHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantEmergencyContact`
--

DROP TABLE IF EXISTS `applicantEmergencyContact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantEmergencyContact` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `applicantId` int(11) NOT NULL,
  `contactName` varchar(255) default NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') default NULL,
  `zip` int(11) NOT NULL,
  `mainPhone` varchar(10) NOT NULL,
  `workPhone` varchar(10) default NULL,
  `relationship` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`),
  CONSTRAINT `applicantEmergencyContact_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact info';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantEmergencyContact`
--

LOCK TABLES `applicantEmergencyContact` WRITE;
/*!40000 ALTER TABLE `applicantEmergencyContact` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantEmergencyContact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantEmergencyContactChoice`
--

DROP TABLE IF EXISTS `applicantEmergencyContactChoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantEmergencyContactChoice` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `choice` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantEmergencyContactChoice`
--

LOCK TABLES `applicantEmergencyContactChoice` WRITE;
/*!40000 ALTER TABLE `applicantEmergencyContactChoice` DISABLE KEYS */;
INSERT INTO `applicantEmergencyContactChoice` (`id`, `dateCreated`, `dateUpdated`, `choice`) VALUES (1,'2010-06-22 15:42:02','2010-06-22 15:42:06','abovePerson'),(2,'2010-06-22 15:42:02','2010-06-22 15:42:06','yourSpouse'),(3,'2010-06-22 15:42:02','2010-06-22 15:42:06','parentChild');
/*!40000 ALTER TABLE `applicantEmergencyContactChoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantEmergencyContactChoiceAnswer`
--

DROP TABLE IF EXISTS `applicantEmergencyContactChoiceAnswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantEmergencyContactChoiceAnswer` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `applicantId` int(11) NOT NULL,
  `applicantEmergencyContactChoiceId` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantEmergencyContactChoiceId` (`applicantEmergencyContactChoiceId`),
  KEY `applicantId` (`applicantId`),
  CONSTRAINT `applicantEmergencyContactChoiceAnswer_ibfk_2` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applicantEmergencyContactChoiceAnswer_ibfk_1` FOREIGN KEY (`applicantEmergencyContactChoiceId`) REFERENCES `applicantEmergencyContactChoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact answer';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantEmergencyContactChoiceAnswer`
--

LOCK TABLES `applicantEmergencyContactChoiceAnswer` WRITE;
/*!40000 ALTER TABLE `applicantEmergencyContactChoiceAnswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantEmergencyContactChoiceAnswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantOccupants`
--

DROP TABLE IF EXISTS `applicantOccupants`;
CREATE TABLE `applicantOccupants` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `name` varchar(250) default NULL,
  `relationship` char(12) default NULL,
  `sex` enum('m','f') default NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') default NULL,
  `ssn` int(11) default NULL,
  `identification` int(11) NOT NULL,
  `dob` date default NULL,
  `dateCreated` date NOT NULL,
  `dateUpdated` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Other occupants that will reside in the property with the si';


--
-- Table structure for table `applicantPersonalInfo`
--

DROP TABLE IF EXISTS `applicantPersonalInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantPersonalInfo` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `streetAddress` varchar(255) NOT NULL,
  `identification` int(11) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') NOT NULL,
  `formerLastName` varchar(255) default NULL,
  `ssn` int(11) NOT NULL,
  `dob` date NOT NULL,
  `height` double default NULL,
  `weight` double default NULL,
  `sex` enum('m','f') NOT NULL,
  `eyeColor` varchar(20) NOT NULL,
  `hairColor` varchar(50) NOT NULL,
  `maritalStatus` enum('single','married','divorced','widowed','separated') NOT NULL,
  `usCitizen` enum('yes','no') NOT NULL,
  `smoke` enum('yes','no') NOT NULL,
  `havePets` enum('yes','no') default NULL,
  `petDetails` varchar(255) default NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`),
  KEY `fullName` (`fullName`),
  KEY `streetAddress` (`streetAddress`),
  KEY `ssn` (`ssn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant personal info';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantPersonalInfo`
--

LOCK TABLES `applicantPersonalInfo` WRITE;
/*!40000 ALTER TABLE `applicantPersonalInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantPersonalInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantRentalCriminalHistory`
--

DROP TABLE IF EXISTS `applicantRentalCriminalHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantRentalCriminalHistory` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `applicantId` int(11) NOT NULL,
  `crimeComment` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant credit history info';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantRentalCriminalHistory`
--

LOCK TABLES `applicantRentalCriminalHistory` WRITE;
/*!40000 ALTER TABLE `applicantRentalCriminalHistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantRentalCriminalHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantRentalCriminalHistoryAnswer`
--

DROP TABLE IF EXISTS `applicantRentalCriminalHistoryAnswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantRentalCriminalHistoryAnswer` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `applicantRentalCriminalHistoryId` int(11) NOT NULL,
  `applicantRentalCriminalHistoryQuestionId` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `applicantRentalCriminalHistoryId` (`applicantRentalCriminalHistoryId`),
  KEY `applicantRentalCriminalHistoryQuestionId` (`applicantRentalCriminalHistoryQuestionId`),
  CONSTRAINT `applicantRentalCriminalHistoryAnswer_ibfk_1` FOREIGN KEY (`applicantRentalCriminalHistoryId`) REFERENCES `applicantRentalCriminalHistory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applicantRentalCriminalHistoryAnswer_ibfk_2` FOREIGN KEY (`applicantRentalCriminalHistoryQuestionId`) REFERENCES `applicantRentalCriminalHistoryQuestion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal answer';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantRentalCriminalHistoryAnswer`
--

LOCK TABLES `applicantRentalCriminalHistoryAnswer` WRITE;
/*!40000 ALTER TABLE `applicantRentalCriminalHistoryAnswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantRentalCriminalHistoryAnswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantRentalCriminalHistoryQuestion`
--

DROP TABLE IF EXISTS `applicantRentalCriminalHistoryQuestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantRentalCriminalHistoryQuestion` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantRentalCriminalHistoryQuestion`
--

LOCK TABLES `applicantRentalCriminalHistoryQuestion` WRITE;
/*!40000 ALTER TABLE `applicantRentalCriminalHistoryQuestion` DISABLE KEYS */;
INSERT INTO `applicantRentalCriminalHistoryQuestion` (`id`, `dateCreated`, `dateUpdated`, `question`) VALUES (1,'2010-06-22 15:42:02','2010-06-22 15:42:06','beenEvicted'),(2,'2010-06-22 15:42:02','2010-06-22 15:42:06','movedBeforeEndOfLease'),(3,'2010-06-22 15:42:02','2010-06-22 15:42:06','declaredBankruptcy'),(4,'2010-06-22 15:42:02','2010-06-22 15:42:06','suedForRent'),(5,'2010-06-22 15:42:02','2010-06-22 15:42:06','suedForPropertyDamage'),(6,'2010-06-22 15:42:02','2010-06-22 15:42:06','resolvedCrime'),(7,'2010-06-22 15:42:02','2010-06-22 15:42:06','notResolvedCrime');
/*!40000 ALTER TABLE `applicantRentalCriminalHistoryQuestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantSetting`
--

DROP TABLE IF EXISTS `applicantSetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantSetting` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(15) NOT NULL,
  `value` varchar(40) NOT NULL,
  `disabled` tinyint(1) NOT NULL default '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Settings for applicant';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantSetting`
--

LOCK TABLES `applicantSetting` WRITE;
/*!40000 ALTER TABLE `applicantSetting` DISABLE KEYS */;
INSERT INTO `applicantSetting` (`id`, `name`, `value`, `disabled`, `dateCreated`, `dateUpdated`) VALUES (1,'applicationFee','50',1,'2010-07-11 15:26:33','2010-07-11 16:46:32'),(2,'appDeposit','10',0,'2010-07-11 18:26:21','2010-07-11 18:26:21'),(3,'admFee','10',0,'2010-07-11 18:37:21','2010-07-11 18:37:21');
/*!40000 ALTER TABLE `applicantSetting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantSpouse`
--

DROP TABLE IF EXISTS `applicantSpouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantSpouse` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `fullName` varchar(250) default NULL,
  `ssn` int(11) default NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') default NULL,
  `dob` date default NULL,
  `cityStateZip` text,
  `height` double default NULL,
  `weight` double default NULL,
  `sex` enum('m','f') default NULL,
  `eyeColor` varchar(30) default NULL,
  `hairColor` varchar(30) default NULL,
  `usCitizen` enum('yes','no') default NULL,
  `workPhone` varchar(50) default NULL,
  `cellPhone` varchar(50) default NULL,
  `position` varchar(50) default NULL,
  `emailAddress` varchar(250) default NULL,
  `dateBeganJob` date default NULL,
  `income` double default NULL,
  `superVisorName` varchar(250) default NULL,
  `superVisorPhone` varchar(50) default NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spouse information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantSpouse`
--

LOCK TABLES `applicantSpouse` WRITE;
/*!40000 ALTER TABLE `applicantSpouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantSpouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantTransactions`
--

DROP TABLE IF EXISTS `applicantTransactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantTransactions` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) default NULL,
  `name` char(15) NOT NULL,
  `page` varchar(50) NOT NULL,
  `complete` tinyint(1) NOT NULL default '0',
  `payload` text NOT NULL,
  `current` tinyint(4) NOT NULL default '0',
  `action` varchar(50) default NULL,
  `next` text NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL COMMENT 'Not used',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `action` (`action`),
  FULLTEXT KEY `payload` (`payload`),
  FULLTEXT KEY `next` (`next`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='Table that holds the applicant steps through our application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantTransactions`
--

LOCK TABLES `applicantTransactions` WRITE;
/*!40000 ALTER TABLE `applicantTransactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantTransactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantVehicles`
--

DROP TABLE IF EXISTS `applicantVehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantVehicles` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) NOT NULL,
  `brand` varchar(50) default NULL,
  `license` char(9) default NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') default NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`applicantId`),
  KEY `brand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Applicants vehicles or his occupants vehicles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantVehicles`
--

LOCK TABLES `applicantVehicles` WRITE;
/*!40000 ALTER TABLE `applicantVehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantVehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantWorkHistory`
--

DROP TABLE IF EXISTS `applicantWorkHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantWorkHistory` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  `applicantId` int(11) NOT NULL,
  `employerName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') NOT NULL,
  `zip` int(11) NOT NULL,
  `employerPhone` varchar(10) default NULL,
  `monthlyIncome` decimal(10,2) NOT NULL,
  `dateStarted` date NOT NULL,
  `dateEnded` date default NULL,
  `supervisorName` varchar(255) NOT NULL,
  `supervisorPhone` varchar(10) NOT NULL,
  `isCurrentEmployer` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant work history info';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantWorkHistory`
--

LOCK TABLES `applicantWorkHistory` WRITE;
/*!40000 ALTER TABLE `applicantWorkHistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicantWorkHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicantWorkflowStatus`
--

DROP TABLE IF EXISTS `applicantWorkflowStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicantWorkflowStatus` (
  `id` int(11) NOT NULL auto_increment,
  `applicantId` int(11) default NULL,
  `dateCreated` datetime default NULL COMMENT 'Date this record was created',
  `description` text COMMENT 'Description of why the change was triggered',
  `status` enum('pending','rejected','accepted') NOT NULL,
  `previousStatus` enum('pending','rejected','accepted') NOT NULL,
  `current` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `applicantId` (`applicantId`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='History of the status of a user in the system';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicantWorkflowStatus`
--

LOCK TABLES `applicantWorkflowStatus` WRITE;
UNLOCK TABLES;

-- Dump completed on 2010-07-27 10:10:34

--
-- Dumping data for table `applicantAddress`
--
ALTER TABLE `apmgr`.`applicantOccupants` ADD FOREIGN KEY ( `applicantId` ) REFERENCES `apmgr`.`applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
-- ALTER TABLE `apmgr`.`applicantPersonalInfo` DROP INDEX `userId` , ADD INDEX `applicantId` ( `applicantId` );
ALTER TABLE `applicantPersonalInfo` ADD FOREIGN KEY ( `applicantId` ) REFERENCES `apmgr`.`applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
-- ALTER TABLE `apmgr`.`applicantRentalAnswers` DROP INDEX `userId` , ADD INDEX `applicantId` ( `applicantId` );
-- ALTER TABLE `applicantRentalAnswers` ADD FOREIGN KEY ( `applicantId` ) REFERENCES `apmgr`.`applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE `applicantRentalCriminalHistory` ADD FOREIGN KEY ( `applicantId` ) REFERENCES `apmgr`.`applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE `applicantSpouse` ADD INDEX ( `applicantId` ) ;
ALTER TABLE `applicantSpouse` ADD FOREIGN KEY ( `applicantId` ) REFERENCES `apmgr`.`applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE `applicantWorkHistory` ADD FOREIGN KEY ( `applicantId` ) REFERENCES `apmgr`.`applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
SET FOREIGN_KEY_CHECKS=1;
