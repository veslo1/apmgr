-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2010 at 11:51 PM
-- Server version: 5.0.90
-- PHP Version: 5.2.13-pl0-gentoo

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(50) UNIQUE NOT NULL,
  `number` int(11) unsigned UNIQUE NOT NULL,
  `orientation` enum('debit','credit') NOT NULL,    
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `accountLink`
--

DROP TABLE IF EXISTS `accountLink`;
CREATE TABLE IF NOT EXISTS `accountLink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(50) UNIQUE NOT NULL,  
  `debitAccountId` int(10) unsigned NOT NULL REFERENCES account (id),
  `creditAccountId` int(10) unsigned NOT NULL REFERENCES account (id),
  PRIMARY KEY (`id`) ,
  INDEX (`debitAccountId`),
  INDEX (`creditAccountId`),
  CONSTRAINT `accountLink_ibfk_1` FOREIGN KEY (`debitAccountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `accountLink_ibfk_2` FOREIGN KEY (`creditAccountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `accountLink`
--


-- --------------------------------------------------------

--
-- Table structure for table `accountTransaction`
--

DROP TABLE IF EXISTS `accountTransaction`;
CREATE TABLE IF NOT EXISTS `accountTransaction` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `datePosted` datetime NOT NULL,
  `accountId` int(10) unsigned NOT NULL REFERENCES account (id),
  `transactionId` int(10) unsigned NOT NULL REFERENCES transaction (id),
  `referenceNumber` int(11) NOT NULL,
  `side` enum('credit','debit') NOT NULL,
  PRIMARY KEY (`id`)  ,
  INDEX(`accountId`),
  INDEX(`transactionId`),
  INDEX(`side`), 
  CONSTRAINT `accountTrans_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `accountTrans_ibfk_2` FOREIGN KEY (`transactionId`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `icon` varchar(90) default NULL,
  `display` tinyint(4) NOT NULL default '1',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(2)),
  KEY `icon` (`icon`(6))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `actions`
--

REPLACE INTO `actions` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Error', NULL, 0, '2010-03-23 21:09:29', NULL),
(2, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-03-23 21:09:29', NULL),
(3, 'Db', NULL, 1, '2010-03-23 21:09:29', NULL),
(4, 'Text', NULL, 1, '2010-03-23 21:09:29', NULL),
(5, 'Read', NULL, 1, '2010-03-23 21:09:29', NULL),
(6, 'Getregions', NULL, 1, '2010-03-23 21:09:29', NULL),
(7, 'Delete', '/images/dashboard/onebit_32.gif', 1, '2010-03-23 21:09:29', NULL),
(8, 'Noaccess', NULL, 1, '2010-03-23 21:09:29', NULL),
(9, 'Search', NULL, 1, '2010-03-23 21:09:29', NULL),
(10, 'Help', NULL, 1, '2010-03-23 21:09:29', NULL),
(11, 'Changepwd', NULL, 1, '2010-03-23 21:09:29', NULL),
(12, 'Changerole', NULL, 1, '2010-03-23 21:09:29', NULL),
(13, 'Logout', NULL, 1, '2010-03-23 21:09:29', NULL),
(14, 'Addusertolist', NULL, 1, '2010-03-23 21:09:29', NULL),
(15, 'Removeuserfromlist', NULL, 1, '2010-03-23 21:09:29', NULL),
(16, 'Confirmation', NULL, 1, '2010-03-23 21:09:29', NULL),
(17, 'Enterdiscounts', NULL, 1, '2010-03-23 21:09:29', NULL),
(18, 'Entermoveindate', NULL, 1, '2010-03-23 21:09:29', NULL),
(19, 'Searchaddtenet', NULL, 1, '2010-03-23 21:09:29', NULL),
(20, 'Selectaccountlink', NULL, 1, '2010-03-23 21:09:29', NULL),
(21, 'Selectrentschedule', NULL, 1, '2010-03-23 21:09:29', NULL),
(22, 'Viewunittenet', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:29', NULL),
(23, 'Addtounit', NULL, 1, '2010-03-23 21:09:29', NULL),
(24, 'Viewallmodelrentschedule', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:29', NULL),
(25, 'Viewmodelrentschedule', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:29', NULL),
(26, 'Unitmodelindex', '/images/dashboard/onebit_01.gif', 1, '2010-03-23 21:09:29', NULL),
(27, 'Amenityindex', '/images/dashboard/onebit_01.gif', 1, '2010-03-23 21:09:29', NULL),
(28, 'Createunitsingle', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:29', NULL),
(29, 'Createunitbulk', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:29', NULL),
(30, 'Createunitmodel', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:29', NULL),
(31, 'Createunitamenity', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:29', NULL),
(32, 'Createmodelrentschedule', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:29', NULL),
(33, 'Enterpayment', NULL, 1, '2010-03-23 21:09:29', NULL),
(34, 'Update', '/images/dashboard/onebit_20.gif', 1, '2010-03-23 21:09:29', NULL),
(35, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:29', NULL),
(36, 'Roleaccess', NULL, 1, '2010-03-23 21:09:29', NULL),
(37, 'Retrieve', NULL, 1, '2010-03-23 21:09:29', NULL),
(38, 'Viewallmodules', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:29', NULL),
(39, 'Viewallaccounts', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:30', NULL),
(40, 'Viewaccount', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:30', NULL),
(41, 'Viewallaccountlinks', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:30', NULL),
(42, 'Createaccount', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:30', NULL),
(43, 'Createaccountlink', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:30', NULL),
(44, 'Searchunit', NULL, 1, '2010-03-23 21:09:30', NULL),
(45, 'Selectbill', NULL, 1, '2010-03-23 21:09:30', NULL),
(46, 'Createbill', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:30', NULL),
(47, 'Viewallmaintenancerequests', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:30', NULL),
(48, 'Viewmymaintenancerequests', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:30', NULL),
(49, 'Viewmaintenancerequest', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:30', NULL),
(50, 'Createmaintenancerequest', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:30', NULL),
(51, 'Dailyview', NULL, 1, '2010-04-14 13:01:54', NULL),
(52, 'Viewevent', NULL, 1, '2010-04-14 13:01:54', NULL),
(53, 'Updateaccountlink', NULL, 1, '2010-04-14 13:01:54', NULL),
(54, 'Viewallapartments', NULL, 1, '2010-04-14 13:01:54', NULL),
(55, 'Viewapartment', NULL, 1, '2010-04-14 13:01:54', NULL),
(56, 'Viewlease', NULL, 1, '2010-04-14 13:01:54', NULL),
(57, 'Viewleaselist', NULL, 1, '2010-04-14 13:01:54', NULL),
(58, 'Deleteapartment', NULL, 1, '2010-04-14 13:01:54', NULL),
(59, 'Createapartment', NULL, 1, '2010-04-14 13:01:54', NULL),
(60, 'Startleasewizard', NULL, 1, '2010-04-14 13:01:54', NULL),
(61, 'Cancellease', NULL, 1, '2010-04-14 13:01:54', NULL),
(62, 'Updateapartment', NULL, 1, '2010-04-14 13:01:54', NULL),
(63, 'Viewunit', NULL, 1, '2010-04-14 14:02:16', NULL),
(64, 'Viewallunits', NULL, 1, '2010-04-14 14:02:16', NULL);
-- --------------------------------------------------------

--
-- Table structure for table `amenity`
--

DROP TABLE IF EXISTS `amenity`;
CREATE TABLE IF NOT EXISTS `amenity` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `name` varchar(50) UNIQUE NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds the amenities of the apt such as ceiling fan, furnishe' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

DROP TABLE IF EXISTS `apartment`;
CREATE TABLE IF NOT EXISTS `apartment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) UNIQUE NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `addressOne` varchar(50) NOT NULL,
  `addressTwo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores the apartments' AUTO_INCREMENT=1 ;


--
-- Dumping data for table `apartment`
--


-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
CREATE TABLE IF NOT EXISTS `applicant` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  INDEX(`userId`),  
  CONSTRAINT `applicant_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicant`
--


-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `originalAmountDue` decimal(10,2) NOT NULL,
  `dueDate` date NOT NULL COMMENT 'due date of bill',
  `isPaid` tinyint(1) NOT NULL,
  INDEX (`isPaid`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------
DROP TABLE IF EXISTS `billLease`;
CREATE TABLE IF NOT EXISTS `billLease` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `billId` int(10) unsigned NOT NULL,
  `leaseScheduleId` int(10) unsigned NOT NULL,
  `leaseId` int(11) unsigned NOT NULL,
  INDEX (`billId`),
  INDEX (`leaseScheduleId`),
  INDEX (`leaseId`),
  PRIMARY KEY (`id`),
  CONSTRAINT `billLease_ibfk_1` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `billLease_ibfk_2` FOREIGN KEY (`leaseScheduleId`) REFERENCES `leaseSchedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `billLease_ibfk_3` FOREIGN KEY (`leaseId`) REFERENCES `lease` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `billTransaction`;
CREATE TABLE IF NOT EXISTS `billTransaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `billId` int(10) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`billId`),
  INDEX (`transactionId`),
  CONSTRAINT `billTransaction_ibfk_1` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `billTransaction_ibfk_2` FOREIGN KEY (`transactionId`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(90) NOT NULL,
  `provinceId` int(11) NOT NULL,
  `latitude` varchar(30) default NULL,
  `longitude` varchar(30) default NULL,
  `dateCreated` datetime default NULL,
  `dateUpdated` datetime default NULL,
  `url` varchar(500) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `provinceId` (`provinceId`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This entity represents the cities' AUTO_INCREMENT=181 ;

--
-- Dumping data for table `city`
--

REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(1, 'Dique Luján', 1, '34°21¿14¿S', '58°42¿29¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Dique_Luj%C3%A1n');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(2, 'Grand Bourg', 1, '34°29¿S', '58°43¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Grand_Bourg');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(3, 'Sourigues', 1, '35°02¿S', '60°15¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Sourigues_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(4, 'Nordelta', 1, '34°35¿S', '58°35¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Nordelta');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(5, 'Nueve de Abril', 1, '34°48¿54¿S', '58°28¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Nueve_de_Abril');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(6, 'Castelar', 1, '34°40¿00¿S', '58°40¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Castelar');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(7, 'Santos Lugares', 1, '34°36¿S', '58°33¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Santos_Lugares');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(8, 'Turdera', 1, '34°46¿60¿S', '58°23¿59¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Turdera');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(9, 'Paso del Rey', 1, '34°38¿60¿S', '58°46¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Paso_del_Rey');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(11, 'Luis Guillón', 1, '34°47¿60¿S', '58°27¿0¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Luis_Guill%C3%B3n');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(12, 'La Tablada', 1, '34°42¿00¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/La_Tablada');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(13, 'Vicente López', 1, '34°31¿60¿S', '58°28¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Vicente_L%C3%B3pez_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(14, 'Glew', 1, '34°53¿17¿S', '58°23¿03¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Glew');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(15, 'Villa Chacabuco', 1, '34°34¿59¿S', '58°31¿52¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Chacabuco');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(16, 'Pontevedra', 1, '34°45¿06¿S', '58°42¿42¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pontevedra_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(17, 'Once de Septiembre', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Once_de_Septiembre');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(18, 'Muñiz', 1, '34°32¿60¿S', '58°42¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mu%C3%B1iz');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(19, 'Bella Vista', 1, '34°32¿60¿S', '58°40¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bella_Vista_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(21, 'Alejandro Korn', 1, '34°58¿58¿S', '58°22¿57¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Alejandro_Korn_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(22, 'Rafael Castillo', 1, '34°43¿00¿S', '58°37¿34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Rafael_Castillo');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(23, 'Churruca ', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Churruca_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(24, 'Ingeniero Maschwitz', 1, '34°22¿53¿S', '58°45¿25¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Maschwitz');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(25, 'Juan María Gutiérrez ', 1, '34°49¿60¿S', '58°12¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Juan_Mar%C3%ADa_Guti%C3%A9rrez_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(26, 'Rafael Calzada', 1, '34°47¿60¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Rafael_Calzada');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(27, 'Bernal', 1, '34°42¿00¿S', '58°17¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bernal');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(28, 'Villa Bosch', 1, '34°34¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Bosch');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(29, 'Temperley', 1, '34°46¿60¿S', '58°23¿59¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Temperley');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(31, 'Belén de Escobar', 1, '34°20¿48¿S', '58°49¿07¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bel%C3%A9n_de_Escobar');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(32, 'Pereyra', 1, '34°49¿60¿S', '58°06¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pereyra');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(34, 'José C. Paz', 1, '34°31¿08¿S', '58°45¿03¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_C._Paz');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(35, 'Caseros', 1, '34°37¿46¿S', '58°32¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Caseros');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(36, 'Villa Lynch', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Lynch');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(37, 'Tortuguitas', 1, '34°28¿¿S', '58°46¿¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Tortuguitas');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(38, 'Barrio Montecarlo', 1, '36°15¿00¿S', '61°06¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Barrio_Montecarlo');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(39, 'La Reja', 1, '34°37¿60¿S', '58°47¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/La_Reja');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(40, 'San Fernando ', 1, '34°26¿30¿S', '58°33¿30¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Fernando_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(41, 'Matheu ', 1, '34°22¿59¿S', '58°50¿56¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Matheu_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(42, 'San Francisco Solano ', 1, '34°46¿60¿S', '58°19¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Francisco_Solano_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(43, 'Loma Hermosa', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Loma_Hermosa');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(44, 'Valentín Alsina ', 1, '34°40¿60¿S', '58°25¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Valent%C3%ADn_Alsina_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(45, 'Lomas de Zamora', 1, '34°46¿00¿S', '58°23¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Lomas_de_Zamora');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(46, 'El Palomar ', 1, '34°32¿30¿S', '58°36¿55¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Palomar_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(47, 'Villa Eduardo Madero', 1, '34°42¿00¿S', '58°30¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Eduardo_Madero');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(48, 'Máximo Paz ', 1, '34°55¿60¿S', '58°37¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/M%C3%A1ximo_Paz_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(49, 'Ramos Mejía', 1, '34°37¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ramos_Mej%C3%ADa');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(50, 'Ciudad Evita', 1, '34°43¿20¿S', '58°31¿15¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ciudad_Evita');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(51, 'Lanús', 1, '34°42¿55¿S', '58°24¿28¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Lan%C3%BAs');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(52, 'Gregorio de Laferrere ', 1, '34°42¿00¿S', '58°32¿17¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gregorio_de_Laferrere_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(53, 'San Isidro ', 1, '34°28¿15¿S', '58°31¿43¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Isidro_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(54, 'Berazategui', 1, '34°43¿59¿S', '58°15¿19¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Berazategui');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(55, 'Villa General José Tomás Guido', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_General_Jos%C3%A9_Tom%C3%A1s_Guido');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(56, 'Quilmes ', 1, '34°43¿13¿S', '58°16¿10¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Quilmes_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(57, 'Libertad ', 1, '34°42¿00¿S', '58°40¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Libertad_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(58, 'Ranelagh', 1, '34°47¿60¿S', '58°12¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ranelagh');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(59, 'Mariano Acosta ', 1, '34°43¿34¿S', '58°47¿27¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mariano_Acosta_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(60, 'Dock Sud', 1, '34°37¿60¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Dock_Sud');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(61, 'Hurlingham ', 1, '34°36¿S', '58°38¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Hurlingham_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(62, 'Longchamps', 1, '34°51¿34¿S', '58°23¿18¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Longchamps');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(63, 'Martínez ', 1, '34°28¿60¿S', '58°30¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mart%C3%ADnez_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(64, 'Quintas de Sarandí', 1, '34°40¿13¿S', '58°18¿56¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Quintas_de_Sarand%C3%AD');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(65, 'Plátanos', 1, '34°46¿60¿S', '58°10¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pl%C3%A1tanos');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(66, 'Ezeiza', 1, '34°50¿17¿S', '58°31¿02¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ezeiza');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(67, 'José León Suárez', 1, '34°31¿60¿S', '58°34¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_Le%C3%B3n_Su%C3%A1rez');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(68, 'Sáenz Peña ', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/S%C3%A1enz_Pe%C3%B1a_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(69, 'Aeropuerto Internacional Ezeiza', 1, '34°49¿25¿S', '58°31¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Aeropuerto_Internacional_Ezeiza');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(70, 'González Catán', 1, '34°46¿03¿S', '58°38¿34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gonz%C3%A1lez_Cat%C3%A1n');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(71, 'Guernica', 1, '34°55¿02¿S', '58°23¿13¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Guernica_(Argentina)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(72, 'Gobernador Julio A. Costa', 1, '34°49¿00¿S', '58°13¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gobernador_Julio_A._Costa');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(74, 'Martín Coronado ', 1, '34°36¿S', '58°33¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mart%C3%ADn_Coronado_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(75, 'Villa Gregoria Matorras', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Gregoria_Matorras');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(76, 'Merlo ', 1, '34°39¿55¿S', '58°43¿39¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Merlo_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(77, 'Hudson ', 1, '34°47¿S', '58°24¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Hudson_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(78, 'Villa Libertad', 1, '34°34¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Libertad');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(79, 'General Pacheco', 1, '34°27¿50¿S', '58°39¿13¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/General_Pacheco');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(80, 'Villa Ballester', 1, '34°31¿60¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Ballester');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(83, 'Villa Fiorito', 1, '34°42¿00¿S', '58°27¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Fiorito');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(85, 'San Vicente ', 1, '35°1¿29¿S', '58°25¿26¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Vicente_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(86, 'Barrio Don Orione', 1, '34°51¿00¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Barrio_Don_Orione');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(87, 'San Miguel ', 1, '34°31¿26¿S', '58°46¿46¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Miguel_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(88, 'Malvinas Argentinas', 1, '34°30¿S', '58°41¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Malvinas_Argentinas_(Malvinas_Argentinas)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(89, 'Remedios de Escalada ', 1, '34°35¿46¿S', '58°32¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Remedios_de_Escalada_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(91, 'Marcos Paz ', 1, '34°46¿54¿S', '58°50¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Marcos_Paz_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(92, 'Villa Coronel José M. Zapiola', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Coronel_Jos%C3%A9_M._Zapiola');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(93, 'Estanislao Severo Zeballos ', 1, '34°49¿00¿S', '58°15¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Estanislao_Severo_Zeballos_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(94, 'José Ingenieros ', 1, '34°35¿46¿S', '58°32¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_Ingenieros_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(95, 'Villa General Antonio J. de Sucre', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_General_Antonio_J._de_Sucre');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(97, 'Villa Bernardo Monteagudo', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Bernardo_Monteagudo');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(98, 'Ingeniero Juan Allan', 1, '34°52¿00¿S', '58°10¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Juan_Allan');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(99, 'Villa Maipú', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Maip%C3%BA');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(100, 'Del Viso', 1, '34°27¿00¿S', '58°47¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Del_Viso');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(101, 'Malvinas Argentinas', 1, '34°47¿60¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Malvinas_Argentinas_(Almirante_Brown)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(102, 'San Antonio de Padua ', 1, '34°40¿00¿S', '58°42¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Antonio_de_Padua_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(103, 'Villa Centenario', 1, '34°46¿00¿S', '58°23¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Centenario');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(104, 'Remedios de Escalada', 1, '34°43¿60¿S', '58°22¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Remedios_de_Escalada_(Lan%C3%BAs)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(105, 'El Libertador ', 1, '34°34¿S', '58°34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Libertador_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(106, 'Florencio Varela ', 1, '34°49¿38¿S', '58°23¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Florencio_Varela_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(107, 'Área Reserva Cinturón Ecológico', 1, '34°39¿S', '58°22¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/%C3%81rea_Reserva_Cintur%C3%B3n_Ecol%C3%B3gico');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(108, 'Ingeniero Pablo Nogués', 1, '34°28¿S', '58°46¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Pablo_Nogu%C3%A9s');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(109, 'Ingeniero Adolfo Sourdeaux', 1, '34°28¿S', '58°46¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Adolfo_Sourdeaux');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(110, 'Villa Luzuriaga', 1, '34°38¿60¿S', '58°34¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Luzuriaga');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(111, 'Bosques ', 1, '34°49¿00¿S', '58°13¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bosques_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(112, 'Aldo Bonzi', 1, '34°42¿00¿S', '58°31¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Aldo_Bonzi');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(113, 'Tristán Suárez', 1, '34°52¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Trist%C3%A1n_Su%C3%A1rez');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(115, 'Veinte de Junio', 1, '34°45¿06¿S', '58°42¿42¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Veinte_de_Junio');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(116, 'Acassuso', 1, '34°28¿60¿S', '58°31¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Acassuso');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(117, 'Haedo', 1, '34°37¿60¿S', '58°36¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Haedo');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(118, 'Villa General Juan G. Las Heras', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_General_Juan_G._Las_Heras');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(119, 'Crucecita', 1, '34°40¿05.00¿S', '58°20¿55.00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Crucecita');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(120, 'Ituzaingó ', 1, '34°40¿00¿S', '58°40¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ituzaing%C3%B3_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(121, 'Béccar', 1, '34°28¿00¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/B%C3%A9ccar');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(122, 'Lomas del Mirador', 1, '34°38¿60¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Lomas_del_Mirador');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(123, 'Trujui', 1, '34°27¿54¿S', '58°55¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Trujui');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(124, 'Tapiales', 1, '34°42¿00¿S', '58°31¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Tapiales');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(125, 'Isidro Casanova', 1, '34°42¿00¿S', '58°34¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Isidro_Casanova');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(126, 'Don Torcuato', 1, '34°30¿S', '58°37¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Don_Torcuato');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(128, 'San Justo ', 1, '34°40¿59¿S', '58°33¿07¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Justo_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(129, 'Villa Adelina', 1, '34°31¿13.31¿S', '58°32¿48.00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Adelina');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(130, 'Tigre ', 1, '34°25¿33¿S', '58°35¿48¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Tigre_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(131, 'Fátima ', 1, '34°25¿60¿S', '59°00¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/F%C3%A1tima_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(133, 'Maquinista F. Savio', 1, '34°24¿40¿S', '58°47¿54¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Maquinista_F._Savio');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(134, 'Villa Ayacucho', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Ayacucho');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(135, 'Parque San Martín', 1, '34°40¿13¿S', '58°43¿56¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Parque_San_Mart%C3%ADn');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(136, 'Billinghurst', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Billinghurst');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(137, 'Campo de Mayo', 1, '34°32¿04¿S', '58°40¿18¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Campo_de_Mayo');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(138, 'Francisco %C3%81lvarez ', 1, '34°37¿60¿S', '58°52¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Francisco_%C3%81lvarez_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(139, 'El Talar ', 1, '34°27¿00¿S', '58°38¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Talar_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(140, 'Presidente Derqui ', 1, '34°29¿50¿S', '58°51¿49¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Presidente_Derqui_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(141, 'Villa Granaderos de San Martín', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Granaderos_de_San_Mart%C3%ADn');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(142, 'San Martín ', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Mart%C3%ADn_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(143, 'San José %28Almirante Brown%29', 1, '34°47¿60¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Jos%C3%A9_(Almirante_Brown)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(144, 'El Jag%C3%BCel ', 1, '34°48¿54¿S', '58°28¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Jag%C3%BCel_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(145, 'Villa Godoy Cruz', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Godoy_Cruz');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(146, 'Carlos Spegazzini', 1, '34°52¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Carlos_Spegazzini');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(147, 'Monte Chingolo', 1, '34°43¿00¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Monte_Chingolo');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(148, 'Pilar ', 1, '34°29¿01¿S', '58°55¿55¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pilar_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(149, 'Barrio Parque General San Martín', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Barrio_Parque_General_San_Mart%C3%ADn');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(150, 'Victoria ', 1, '34°27¿S', '58°34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Victoria_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(151, 'Benavídez', 1, '34°24¿34¿S', '58°42¿34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Benav%C3%ADdez');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(152, 'Villa Juan Martín de Pueyrredón', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Juan_Mart%C3%ADn_de_Pueyrred%C3%B3n');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(153, 'Piñeiro', 1, '34°31¿60¿S', '58°45¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pi%C3%B1eiro');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(154, 'José Mármol ', 1, '34°46¿60¿S', '58°22¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_M%C3%A1rmol_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(155, 'Don Bosco ', 1, '34°42¿00¿S', '58°16¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Don_Bosco_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(156, 'Garín', 1, '34°25¿24¿S', '58°45¿43¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gar%C3%ADn');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(157, 'Gerli', 1, '34°42¿00¿S', '58°20¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gerli');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(158, 'Ciudadela ', 1, '34°37¿60¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ciudadela_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(159, 'Villa España', 1, '34°46¿00¿S', '58°12¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Espa%C3%B1a');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(160, 'San Andrés ', 1, '34°32¿60¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Andr%C3%A9s_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(162, 'Ministro Rivadavia', 1, '34°51¿00¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ministro_Rivadavia');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(163, 'Pablo Podestá ', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pablo_Podest%C3%A1_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(164, 'Avellaneda ', 1, '34°39¿45¿S', '58°21¿54¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Avellaneda_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(165, 'Los Polvorines', 1, '34°30¿S', '58°40¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Los_Polvorines');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(166, 'Burzaco', 1, '34°49¿00¿S', '58°22¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Burzaco');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(168, 'Morón ', 1, '34°38¿33¿S', '58°37¿05¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mor%C3%B3n_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(169, 'Boulogne Sur Mer ', 1, '34°30¿00¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Boulogne_Sur_Mer_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(170, 'Villa Domínico', 1, '34°40¿60¿S', '58°19¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Dom%C3%ADnico');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(171, 'Claypole', 1, '34°47¿60¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Claypole');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(172, 'Villa La Florida', 1, '34°43¿00¿S', '58°17¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_La_Florida');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(173, 'Canning ', 1, '34°52¿37¿S', '58°31¿41¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Canning_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(174, 'La Unión ', 1, '34°52¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/La_Uni%C3%B3n_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(176, 'Llavallol', 1, '34°46¿60¿S', '58°25¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Llavallol');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(177, 'Adrogué', 1, '34°48¿02¿S', '58°23¿03¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Adrogu%C3%A9');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(178, 'Banfield', 1, '34°45¿00¿S', '58°23¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Banfield');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(179, 'Moreno ', 1, '34°39¿02¿S', '58°47¿23¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Moreno_(Buenos_Aires)');
REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES(180, 'Manuel Alberti ', 1, '34°29¿01¿S', '58°55¿55¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Manuel_Alberti_(Buenos_Aires)');

-- --------------------------------------------------------

--
-- Table structure for table `controllers`
--

DROP TABLE IF EXISTS `controllers`;
CREATE TABLE IF NOT EXISTS `controllers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(90) NOT NULL,
  `icon` varchar(250) default NULL,
  `display` tinyint(4) NOT NULL default '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All the controllers that we have' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `controllers`
--

REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(1, 'Error', '/images/dashboard/smile_sad_48.gif', 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(2, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(3, 'Update', '/images/dashboard/onebit_20.gif', 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(4, 'Delete', '/images/dashboard/onebit_32.gif', 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(5, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(6, 'Create', '/images/dashboard/onebit_48.gif', 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(7, 'Login', NULL, 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(8, 'Join', NULL, 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(9, 'Leasewizard', NULL, 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(10, 'Tenet', NULL, 1, '2010-03-23 21:09:29', NULL);
REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES(11, 'Search', NULL, 1, '2010-03-23 21:09:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(80) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This entity represents the countries' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `country`
--

REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES(1, 'Americas', '2009-09-14 23:58:18', '2009-11-05 21:35:21');
REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES(2, 'Argentina', '2009-09-17 20:36:40', '2009-09-17 20:36:40');
REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES(3, 'Brasil', '2009-09-17 20:36:45', '2009-09-17 20:36:45');
REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES(4, 'Chile', '2009-09-17 20:37:03', '2009-09-17 20:37:03');
REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES(5, 'Uruguay', '2009-09-17 20:37:09', '2009-09-17 20:37:09');
REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES(6, 'Paraguay', '2009-09-17 20:37:14', '2009-09-17 20:37:14');

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

REPLACE INTO `events` (`id`, `owner`, `title`, `data`, `allDayEvent`, `dateCreated`, `dateUpdated`) VALUES(1, 1, 'Therion', 'This is a test to create an event.\r\nTable fucked up', 0, '2010-04-08 22:39:57', '2010-04-08 22:39:57');
REPLACE INTO `events` (`id`, `owner`, `title`, `data`, `allDayEvent`, `dateCreated`, `dateUpdated`) VALUES(2, 1, 'MegaTherion', 'Testing recursive', 1, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `events` (`id`, `owner`, `title`, `data`, `allDayEvent`, `dateCreated`, `dateUpdated`) VALUES(3, 1, 'Mashop', 'Fuck this shit.', 0, '2010-04-10 16:15:10', '2010-04-10 16:15:10');

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

REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES(1, 1, 2, 0, '2010-04-08 22:39:58', '2010-04-08 22:39:58');
REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES(2, 1, 3, 0, '2010-04-08 22:39:58', '2010-04-08 22:39:58');
REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES(3, 1, 5, 0, '2010-04-08 22:39:58', '2010-04-08 22:39:58');
REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES(4, 2, 2, 0, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES(5, 2, 3, 0, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsNotification` (`id`, `eventId`, `guestId`, `confirmed`, `dateCreated`, `dateUpdated`) VALUES(6, 2, 5, 0, '2010-04-08 22:43:24', '2010-04-08 22:43:24');

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

REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(1, '2010-04-08', '2010-04-08', '12:00:00', '13:00:00', 1, '2010-04-08 22:39:58', '2010-04-08 22:39:58');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(2, '2010-04-09', '2010-04-09', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(3, '2010-04-10', '2010-04-10', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(4, '2010-04-11', '2010-04-11', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(5, '2010-04-12', '2010-04-12', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(6, '2010-04-13', '2010-04-13', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(7, '2010-04-14', '2010-04-14', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(8, '2010-04-15', '2010-04-15', '09:00:00', '18:00:00', 2, '2010-04-08 22:43:24', '2010-04-08 22:43:24');
REPLACE INTO `eventsTime` (`id`, `startDate`, `endDate`, `startTime`, `endTime`, `eventId`, `dateCreated`, `dateUpdated`) VALUES(9, '2010-04-10', '2010-04-10', '14:00:00', '15:00:00', 3, '2010-04-10 16:15:10', '2010-04-10 16:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

DROP TABLE IF EXISTS `lease`;
CREATE TABLE IF NOT EXISTS `lease` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `effectiveDate` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `userId` int(11) NOT NULL,
  `modelRentScheduleId` int(10) unsigned NOT NULL,
  `modelRentScheduleItemId` int(10) unsigned NOT NULL,
  `lastDay` datetime NOT NULL,
  `isCancelled` tinyint(1) NOT NULL,
  `cancellationDate` datetime DEFAULT NULL COMMENT 'The day the lease was cancelled',
  `cancellationLastDay` date DEFAULT NULL COMMENT 'if cancelled, the last day the tenets will be at the apt',
  PRIMARY KEY (`id`),
  INDEX (`unitId`),
  INDEX (`userId`),
  INDEX (`modelRentScheduleId`),
  INDEX (`modelRentScheduleItemId`),
  INDEX (`effectiveDate`),
  INDEX (`lastDay`),
  INDEX (`cancellationLastDay`),
  CONSTRAINT `lease_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lease_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lease_ibfk_3` FOREIGN KEY (`modelRentScheduleId`) REFERENCES `modelRentSchedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lease_ibfk_4` FOREIGN KEY (`modelRentScheduleItemId`) REFERENCES `modelRentScheduleItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE   
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `lease`
--


-- --------------------------------------------------------

--
-- Table structure for table `leaseSchedule`
--

DROP TABLE IF EXISTS `leaseSchedule`;
CREATE TABLE IF NOT EXISTS `leaseSchedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `billId` int(10) unsigned NOT NULL REFERENCES bill (id),
  `month` date NOT NULL,
  `discount` decimal(10,2) unsigned NOT NULL,
  `leaseId` int(10) unsigned NOT NULL REFERENCES lease (id),
  PRIMARY KEY (`id`),
  INDEX (`billId`),
  INDEX (`leaseId`),
  CONSTRAINT `leaseSchedule_ibfk_1` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaseSchedule_ibfk_2` FOREIGN KEY (`leaseId`) REFERENCES `lease` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Dumping data for table `leaseSchedule`
--
DROP TABLE IF EXISTS `leaseWizard`;
CREATE TABLE IF NOT EXISTS `leaseWizard` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `modelRentScheduleId` int(10) unsigned DEFAULT NULL,
  `modelRentScheduleItemId` int(10) unsigned DEFAULT NULL,
  `discount` varchar(200) DEFAULT NULL,
  `tenet` varchar(250) DEFAULT NULL,
  `effectiveDate` datetime DEFAULT NULL,
  `unitId` int(10) unsigned DEFAULT NULL,
  `accountLinkId` int(10) unsigned DEFAULT NULL,
  `referenceNumber` int(11) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX (`modelRentScheduleId`),
  INDEX (`modelRentScheduleItemId`),
  INDEX (`unitId`),
  INDEX (`accountLinkId`),
  CONSTRAINT `leaseWizard_ibfk_1` FOREIGN KEY (`modelRentScheduleId`) REFERENCES `modelRentSchedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaseWizard_ibfk_2` FOREIGN KEY (`modelRentScheduleItemId`) REFERENCES `modelRentScheduleItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaseWizard_ibfk_3` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaseWizard_ibfk_4` FOREIGN KEY (`accountLinkId`) REFERENCES `accountLink` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL auto_increment,
  `message` text NOT NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Logs of the application' AUTO_INCREMENT=75 ;

--
-- Dumping data for table `logs`
--

REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(1, 'Query>>>SELECT `messages`.* FROM `messages` ORDER BY `id` ASC', '2010-02-13 16:17:16');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(2, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:17:35');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(3, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:18:04');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(4, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:18:29');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(5, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:14');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(6, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:16');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(7, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:18');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(8, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:19');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(9, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:19');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(10, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:20');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(11, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:21');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(12, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:21');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(13, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:23');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(14, 'SELECT `messages`.* FROM `messages` ORDER BY `message` DESC', '2010-02-13 16:19:26');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(15, 'SELECT `messages`.* FROM `messages` ORDER BY `message` ASC', '2010-02-13 16:19:44');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(16, 'SELECT `messages`.* FROM `messages` ORDER BY `message` ASC', '2010-02-13 16:28:32');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(17, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` ASC', '2010-02-13 22:46:42');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(18, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` DESC', '2010-02-13 22:46:43');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(19, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` ASC', '2010-02-13 22:46:44');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(20, 'SELECT `role`.* FROM `role` ORDER BY `name` DESC', '2010-02-13 22:46:45');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(21, 'SELECT `role`.* FROM `role` ORDER BY `name` ASC', '2010-02-13 22:46:46');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(22, 'SELECT `messages`.* FROM `messages` ORDER BY `message` ASC', '2010-02-20 13:19:24');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(23, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` ASC', '2010-02-20 13:20:43');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(24, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` DESC', '2010-02-20 13:20:44');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(25, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` ASC', '2010-02-20 13:20:47');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(26, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` ASC', '2010-02-20 14:40:19');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(27, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:25');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(28, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:27');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(29, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:28');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(30, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:30');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(31, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:49:27');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(32, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:49:29');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(33, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:49:30');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(34, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 11:38:42');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(35, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:35:24');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(36, 'SELECT `messages`.* FROM `messages` ORDER BY `message` DESC', '2010-03-20 15:36:36');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(37, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:36:38');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(38, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:36:41');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(39, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:36:44');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(40, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:36:47');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(41, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:36:52');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(42, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:36:55');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(43, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-03-20 15:37:24');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(44, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:32:03');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(45, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:33:10');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(46, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:33:16');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(47, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:36:31');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(48, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:36:33');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(49, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:36:35');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(50, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:36:37');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(51, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:39:47');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(52, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:40:13');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(53, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` asc', '2010-03-24 18:40:19');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(54, 'SELECT `role`.* FROM `role` ORDER BY `id` ASC', '2010-04-10 18:50:58');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(55, 'SELECT `role`.* FROM `role` ORDER BY `name` DESC', '2010-04-10 18:50:59');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(56, 'SELECT `role`.* FROM `role` ORDER BY `name` ASC', '2010-04-10 18:51:00');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(57, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` DESC', '2010-04-10 18:51:03');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(58, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` ASC', '2010-04-10 18:51:03');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(59, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` DESC', '2010-04-10 18:51:05');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(60, 'SELECT `role`.* FROM `role` ORDER BY `name` ASC', '2010-04-10 18:51:07');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(61, 'SELECT `role`.* FROM `role` ORDER BY `id` DESC', '2010-04-10 19:27:24');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(62, 'SELECT `role`.* FROM `role` ORDER BY `id` ASC', '2010-04-10 19:27:26');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(63, 'SELECT `role`.* FROM `role` ORDER BY `id` DESC', '2010-04-10 19:27:26');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(64, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:25');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(65, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:27');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(66, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:37');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(67, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:39');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(68, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:40');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(69, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:43');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(70, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-10 21:30:44');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(71, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-11 11:08:02');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(72, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-11 11:08:06');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(73, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-11 11:08:11');
REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES(74, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-04-11 11:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequest`
--

DROP TABLE IF EXISTS `maintenanceRequest`;
CREATE TABLE IF NOT EXISTS `maintenanceRequest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `unitId` int(10) unsigned NOT NULL REFERENCES unit (id),
  `requestorId` int(11) NOT NULL REFERENCES user (id),
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` enum('new','assigned','completed') NOT NULL,
  `assignedTo` int(10) unsigned DEFAULT NULL REFERENCES user (id),
  PRIMARY KEY (`id`),
  KEY `unitId` (`unitId`,`requestorId`,`status`,`assignedTo`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequest`
--


-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequestComment`
--
DROP TABLE IF EXISTS `maintenanceRequestComment`;
CREATE TABLE IF NOT EXISTS `maintenanceRequestComment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `maintenanceRequestId` int(10) unsigned NOT NULL REFERENCES maintenanceRequest (id),
  `comment` varchar(1000) NOT NULL,
  `userId` int(11) NOT NULL REFERENCES user (id),
  PRIMARY KEY (`id`),
  KEY `maintenanceRequestId` (`maintenanceRequestId`,`userId`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequestComment`
--


-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequestHistory`
--

DROP TABLE IF EXISTS `maintenanceRequestHistory`;
CREATE TABLE IF NOT EXISTS `maintenanceRequestHistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `unitId` int(10) unsigned NOT NULL REFERENCES unit (id),
  `requestorId` int(11) unsigned NOT NULL REFERENCES user (id),
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` enum('new','assigned','completed') NOT NULL,
  `assignedTo` int(11) DEFAULT NULL REFERENCES user (id),
  `maintenanceRequestId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unitId` (`unitId`,`requestorId`,`status`,`assignedTo`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL auto_increment,
  `message` text NOT NULL,
  `identifier` char(15) NOT NULL,
  `category` enum('error','warning','success') NOT NULL,
  `language` char(5) NOT NULL default 'en_US' COMMENT 'The language this token was created.',
  `locked` tinyint(4) NOT NULL default '1' COMMENT 'Lock this field to prevent deletion',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `messages`
--

REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(1, 'The message has been saved', 'messageCreated', 'success', 'en_US', 1, '2009-10-31 15:04:39', '2010-02-20 14:41:51');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(2, 'The message has been updated', 'messageUpdated', 'success', 'en_US', 0, '2009-11-01 14:17:03', '2010-02-13 22:43:47');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(3, 'The message was deleted', 'msgDeleted', 'success', 'en_US', 0, '2009-11-01 15:34:49', '2010-02-13 22:44:08');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(4, 'The Message Has Been Deleted', 'roleDeleted', 'success', 'en_US', 1, '2009-11-01 16:45:10', '2009-11-05 22:57:28');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(5, 'The Role Has Been Saved', 'roleSaved', 'success', 'en_US', 1, '2009-11-01 17:12:41', '2009-11-05 22:57:28');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(6, 'The application is missing an important part in order to continue working', 'haveId', 'error', 'en_US', 1, '2009-10-03 20:52:44', '2009-11-08 12:50:14');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(7, 'The selected resource doesn''t exists yet.Please,try again later or verify your URL information', 'resourceExist', 'error', 'en_US', 1, '2009-10-03 20:53:37', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(8, 'You do not have enough permissions to edit that resource', 'canEdit', 'error', 'en_US', 1, '2009-10-03 20:54:21', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(9, 'We couldn''t save your information.An error happened', 'saveWork', 'error', 'en_US', 1, '2009-10-03 22:06:16', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(10, 'The user account doesn''t exists.\r\nPlease, create an account and try again later.', 'unknownuser', 'error', 'en_US', 1, '2009-10-11 20:54:16', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(11, 'The specified password is incorrect.Please, verify your password and retry', 'invalidPassword', 'error', 'en_US', 1, '2009-10-11 20:56:13', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(12, 'The specified value already exists', 'valueExists', 'error', 'en_US', 1, '2009-10-31 13:02:56', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(13, 'The message couldn''t be saved', 'msgUpdateFail', 'error', 'en_US', 1, '2009-11-01 14:19:35', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(14, 'The Role Couldn''t Be Deleted', 'roleDeletedFail', 'error', 'en_US', 1, '2009-11-01 17:15:01', '2009-11-08 01:18:44');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(15, 'The Message Couldn''t be deleted', 'msgDeleteFail', 'warning', 'en_US', 1, '2009-11-01 16:47:53', '2009-11-08 02:00:46');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(16, 'The Role Is No Longer Active', 'roleMissing', 'warning', 'en_US', 1, '2009-11-01 17:16:15', '2009-11-08 02:01:07');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(17, 'The password update failed', 'pwdupdatefail', 'error', 'en_US', 1, '2009-12-17 18:35:03', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(18, 'The password was successfully changed.', 'pwdupdatepass', 'success', 'en_US', 1, '2009-12-17 18:39:43', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(19, 'Roles Updated.', 'roleupdatepass', 'success', 'en_US', 1, '2009-12-19 11:07:53', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(20, 'One or multiple roles failed while trying to be saved', 'roleupdatefail', 'error', 'en_US', 1, '2009-12-19 11:09:10', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(21, 'Probando mensajes que se muestran', 'testinglocale', 'warning', 'es_AR', 1, '2009-12-20 18:08:24', '2009-12-20 18:22:26');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(22, 'The message could not be saved', 'roleAclSaveFail', 'error', 'en_US', 1, '2010-01-10 08:48:02', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(23, 'The Access Has Been Deleted', 'rolePermPass', 'success', 'en_US', 1, '2010-02-04 00:15:21', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(24, 'The Permission Could Not Be Deleted', 'rolePermFail', 'error', 'en_US', 1, '2010-02-04 00:15:54', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(25, 'The Permission Was Saved', 'rolePermSaved', 'success', 'en_US', 1, '2010-02-05 21:17:46', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(26, 'The permission could not be saved', 'rolePermFailed', 'success', 'en_US', 0, '2010-02-05 21:26:23', '2010-02-13 22:44:52');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(27, 'The Specified Permission already exists.', 'rolePermExists', 'warning', 'en_US', 1, '2010-02-05 21:36:03', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(28, 'The selected unit does not have any record.', 'nobillsforunit', 'error', 'en_US', 1, '2010-02-09 20:40:59', '2010-02-09 21:26:25');
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(29, 'An unidentified  error happened.', 'unhandledMsg', 'error', 'en_US', 1, '2010-02-20 14:41:34', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(30, 'The specified permission does not exist.', 'pmsfakeId', 'error', 'en_US', 1, '2010-02-20 14:52:14', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(31, 'An error happened while saving the alias.', 'pmSaveFail', 'error', 'en_US', 1, '2010-02-20 15:56:16', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(32, 'The Dates are missing', 'datesMissing', 'error', 'en_US', 1, '2010-03-20 11:38:39', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(33, 'The event was saved', 'eventSaved', 'success', 'en_US', 1, '2010-03-20 15:35:20', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(34, 'The event could not be saved.', 'eventSaveFail', 'warning', 'en_US', 1, '2010-03-20 15:37:21', NULL);
REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES(35, 'An exception happened !', 'exceptionCaught', 'warning', 'en_US', 1, '2010-03-20 15:39:48', NULL);

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Table structure for table `modelRentSchedule`
--

DROP TABLE IF EXISTS `modelRentSchedule`;
CREATE TABLE IF NOT EXISTS `modelRentSchedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `unitModelId` int(10) unsigned NOT NULL,
  `effectiveDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`unitModelId`),
  INDEX (`effectiveDate`),    
  CONSTRAINT `modelRentSchedule_ibfk_1` FOREIGN KEY (`unitModelId`) REFERENCES `unitModel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `modelRentScheduleItem`
--

DROP TABLE IF EXISTS `modelRentScheduleItem`;
CREATE TABLE IF NOT EXISTS `modelRentScheduleItem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `modelRentScheduleId` int(10) unsigned NOT NULL,
  `rentAmount` decimal(10,2) unsigned NOT NULL,
  `numMonths` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),  
  INDEX (`modelRentScheduleId`),    
  CONSTRAINT `modelRentScheduleItem_ibfk_1` FOREIGN KEY (`modelRentScheduleId`) REFERENCES `modelRentSchedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `icon` varchar(250) default NULL,
  `display` tinyint(4) NOT NULL default '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The content of the modules folder, ie all the modules' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `modules`
--
REPLACE INTO `modules` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'logs', '/images/dashboard/info.gif', 1, '2010-03-23 21:09:29', NULL),
(3, 'default', '/images/dashboard/ok.gif', 0, '2010-03-23 21:09:29', NULL),
(4, 'messages', '/images/dashboard/messages.gif', 1, '2010-03-23 21:09:29', NULL),
(5, 'user', '/images/dashboard/user_48.gif', 1, '2010-03-23 21:09:29', NULL),
(6, 'unit', '/images/dashboard/apartment.gif', 1, '2010-03-23 21:09:29', NULL),
(8, 'role', '/images/dashboard/role.gif', 1, '2010-03-23 21:09:29', NULL),
(9, 'permission', '/images/dashboard/onebit_04.gif', 1, '2010-03-23 21:09:29', NULL),
(11, 'calendar', '/images/dashboard/calendar.png', 1, '2010-03-23 21:09:29', '2010-03-23 21:08:50'),
(12, 'modules', '/images/dashboard/google_48.gif', 0, '2010-03-23 21:09:29', NULL),
(15, 'financial', '/images/dashboard/dollar.gif', 1, '2010-03-23 21:09:30', NULL),
(16, 'maintenance', '/images/dashboard/spanner_48.gif', 1, '2010-03-23 21:09:30', NULL);
-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `billId` int(10) unsigned NOT NULL,
  `amtPaid` double NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  `paymentDetailId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`billId`), 
  INDEX (`transactionId`),
  INDEX (`paymentDetailId`),  
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`transactionId`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`paymentDetailId`) REFERENCES `paymentDetail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `paymentDetail`
--

DROP TABLE IF EXISTS `paymentDetail`;
CREATE TABLE IF NOT EXISTS `paymentDetail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `totalAmount` decimal(10,2) unsigned NOT NULL,
  `payor` varchar(50) NOT NULL,
  `paymentType` enum('cash','credit card','check','money order') NOT NULL,
  `paymentNumber` int(11) NOT NULL COMMENT 'stores the check or cc or money order number',
  `ccName` varchar(50) DEFAULT NULL,
  `ccExpirationDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),  
  INDEX (`paymentType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL auto_increment,
  `moduleId` int(11) NOT NULL REFERENCES `apmgr`.`modules` ( `id` ) ON  DELETE  CASCADE  ON  UPDATE  CASCADE,
  `controllerId` int(11) NOT NULL,
  `actionId` int(11) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `controllerId` (`controllerId`),  
  KEY `moduleId` (`moduleId`),
  KEY `alias` (`alias`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This entity represents the permissions that we have' AUTO_INCREMENT=129 ;

--
-- Dumping data for table `permission`
--

REPLACE INTO `permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 1, 1, 'Logs Error Error', '2010-03-23 21:09:29', NULL),
(2, 1, 2, 2, 'Logs Index Index', '2010-03-23 21:09:29', NULL),
(3, 1, 2, 3, 'Logs Index Db', '2010-03-23 21:09:29', NULL),
(4, 1, 2, 4, 'Logs Index Text', '2010-03-23 21:09:29', NULL),
(5, 1, 2, 5, 'Logs Index Read', '2010-03-23 21:09:29', NULL),
(15, 3, 1, 1, 'Default Error Error', '2010-03-23 21:09:29', NULL),
(16, 3, 1, 8, 'Default Error Noaccess', '2010-03-23 21:09:29', NULL),
(17, 3, 2, 2, 'Default Index Index', '2010-03-23 21:09:29', NULL),
(18, 3, 2, 9, 'Default Index Search', '2010-03-23 21:09:29', NULL),
(19, 4, 3, 2, 'Messages Update Index', '2010-03-23 21:09:29', NULL),
(20, 4, 4, 10, 'Messages Delete Help', '2010-03-23 21:09:29', NULL),
(21, 4, 4, 2, 'Messages Delete Index', '2010-03-23 21:09:29', NULL),
(22, 4, 5, 2, 'Messages View Index', '2010-03-23 21:09:29', NULL),
(23, 4, 2, 2, 'Messages Index Index', '2010-03-23 21:09:29', NULL),
(24, 4, 6, 2, 'Messages Create Index', '2010-03-23 21:09:29', NULL),
(25, 5, 1, 1, 'User Error Error', '2010-03-23 21:09:29', NULL),
(26, 5, 1, 8, 'User Error Noaccess', '2010-03-23 21:09:29', NULL),
(27, 5, 3, 2, 'User Update Index', '2010-03-23 21:09:29', NULL),
(28, 5, 3, 11, 'User Update Changepwd', '2010-03-23 21:09:29', NULL),
(29, 5, 3, 12, 'User Update Changerole', '2010-03-23 21:09:29', NULL),
(30, 5, 5, 2, 'User View Index', '2010-03-23 21:09:29', NULL),
(31, 5, 2, 2, 'User Index Index', '2010-03-23 21:09:29', NULL),
(32, 5, 7, 2, 'User Login Index', '2010-03-23 21:09:29', NULL),
(33, 5, 7, 13, 'User Login Logout', '2010-03-23 21:09:29', NULL),
(34, 5, 7, 1, 'User Login Error', '2010-03-23 21:09:29', NULL),
(35, 5, 8, 2, 'User Join Index', '2010-03-23 21:09:29', NULL),
(36, 5, 6, 2, 'User Create Index', '2010-03-23 21:09:29', NULL),
(37, 6, 1, 1, 'Unit Error Error', '2010-03-23 21:09:29', NULL),
(38, 6, 9, 14, 'Unit Leasewizard Addusertolist', '2010-03-23 21:09:29', NULL),
(39, 6, 9, 15, 'Unit Leasewizard Removeuserfromlist', '2010-03-23 21:09:29', NULL),
(40, 6, 9, 16, 'Unit Leasewizard Confirmation', '2010-03-23 21:09:29', NULL),
(41, 6, 9, 17, 'Unit Leasewizard Enterdiscounts', '2010-03-23 21:09:29', NULL),
(42, 6, 9, 18, 'Unit Leasewizard Entermoveindate', '2010-03-23 21:09:29', NULL),
(43, 6, 9, 19, 'Unit Leasewizard Searchaddtenet', '2010-03-23 21:09:29', NULL),
(44, 6, 9, 20, 'Unit Leasewizard Selectaccountlink', '2010-03-23 21:09:29', NULL),
(45, 6, 9, 21, 'Unit Leasewizard Selectrentschedule', '2010-03-23 21:09:29', NULL),
(46, 6, 3, 2, 'Unit Update Index', '2010-03-23 21:09:29', NULL),
(47, 6, 4, 2, 'Unit Delete Index', '2010-03-23 21:09:29', NULL),
(48, 6, 4, 7, 'Unit Delete Delete', '2010-03-23 21:09:29', NULL),
(49, 6, 10, 22, 'Unit Tenet Viewunittenet', '2010-03-23 21:09:29', NULL),
(50, 6, 10, 19, 'Unit Tenet Searchaddtenet', '2010-03-23 21:09:29', NULL),
(51, 6, 10, 23, 'Unit Tenet Addtounit', '2010-03-23 21:09:29', NULL),
(52, 6, 5, 2, 'Unit View Index', '2010-03-23 21:09:29', NULL),
(53, 6, 5, 24, 'Unit View Viewallmodelrentschedule', '2010-03-23 21:09:29', NULL),
(54, 6, 5, 25, 'Unit View Viewmodelrentschedule', '2010-03-23 21:09:29', NULL),
(55, 6, 2, 2, 'Unit Index Index', '2010-03-23 21:09:29', NULL),
(56, 6, 2, 26, 'Unit Index Unitmodelindex', '2010-03-23 21:09:29', NULL),
(57, 6, 2, 27, 'Unit Index Amenityindex', '2010-03-23 21:09:29', NULL),
(58, 6, 6, 2, 'Unit Create Index', '2010-03-23 21:09:29', NULL),
(59, 6, 6, 28, 'Unit Create Createunitsingle', '2010-03-23 21:09:29', NULL),
(60, 6, 6, 29, 'Unit Create Createunitbulk', '2010-03-23 21:09:29', NULL),
(61, 6, 6, 30, 'Unit Create Createunitmodel', '2010-03-23 21:09:29', NULL),
(62, 6, 6, 31, 'Unit Create Createunitamenity', '2010-03-23 21:09:29', NULL),
(63, 6, 6, 32, 'Unit Create Createmodelrentschedule', '2010-03-23 21:09:29', NULL),
(65, 8, 1, 1, 'Role Error Error', '2010-03-23 21:09:29', NULL),
(66, 8, 1, 8, 'Role Error Noaccess', '2010-03-23 21:09:29', NULL),
(67, 8, 11, 2, 'Role Search Index', '2010-03-23 21:09:29', NULL),
(68, 8, 3, 2, 'Role Update Index', '2010-03-23 21:09:29', NULL),
(69, 8, 3, 34, 'Role Update Update', '2010-03-23 21:09:29', NULL),
(70, 8, 4, 2, 'Role Delete Index', '2010-03-23 21:09:29', NULL),
(71, 8, 4, 7, 'Role Delete Delete', '2010-03-23 21:09:29', NULL),
(72, 8, 5, 2, 'Role View Index', '2010-03-23 21:09:29', NULL),
(73, 8, 5, 35, 'Role View View', '2010-03-23 21:09:29', NULL),
(74, 8, 5, 36, 'Role View Roleaccess', '2010-03-23 21:09:29', NULL),
(75, 8, 2, 2, 'Role Index Index', '2010-03-23 21:09:29', NULL),
(76, 8, 6, 2, 'Role Create Index', '2010-03-23 21:09:29', NULL),
(77, 8, 6, 36, 'Role Create Roleaccess', '2010-03-23 21:09:29', NULL),
(78, 9, 1, 1, 'Permission Error Error', '2010-03-23 21:09:29', NULL),
(79, 9, 11, 2, 'Permission Search Index', '2010-03-23 21:09:29', NULL),
(80, 9, 3, 2, 'Permission Update Index', '2010-03-23 21:09:29', NULL),
(81, 9, 5, 2, 'Permission View Index', '2010-03-23 21:09:29', NULL),
(82, 9, 5, 35, 'Permission View View', '2010-03-23 21:09:29', NULL),
(83, 9, 2, 2, 'Permission Index Index', '2010-03-23 21:09:29', NULL),
(91, 11, 5, 2, 'Calendar View Index', '2010-03-23 21:09:29', NULL),
(92, 11, 5, 37, 'Calendar View Retrieve', '2010-03-23 21:09:29', NULL),
(93, 11, 2, 2, 'Calendar Index Index', '2010-03-23 21:09:29', NULL),
(94, 11, 6, 2, 'Calendar Create Index', '2010-03-23 21:09:29', NULL),
(95, 12, 1, 1, 'Modules Error Error', '2010-03-23 21:09:29', NULL),
(96, 12, 3, 2, 'Modules Update Index', '2010-03-23 21:09:29', NULL),
(97, 12, 3, 34, 'Modules Update Update', '2010-03-23 21:09:29', NULL),
(98, 12, 5, 2, 'Modules View Index', '2010-03-23 21:09:29', NULL),
(99, 12, 5, 38, 'Modules View Viewallmodules', '2010-03-23 21:09:29', NULL),
(100, 12, 2, 2, 'Modules Index Index', '2010-03-23 21:09:29', NULL),
(116, 15, 5, 39, 'Financial View Viewallaccounts', '2010-03-23 21:09:30', NULL),
(117, 15, 5, 40, 'Financial View Viewaccount', '2010-03-23 21:09:30', NULL),
(118, 15, 5, 41, 'Financial View Viewallaccountlinks', '2010-03-23 21:09:30', NULL),
(119, 15, 2, 2, 'Financial Index Index', '2010-03-23 21:09:30', NULL),
(120, 15, 6, 42, 'Financial Create Createaccount', '2010-03-23 21:09:30', NULL),
(121, 15, 6, 43, 'Financial Create Createaccountlink', '2010-03-23 21:09:30', NULL),
(122, 15, 6, 44, 'Financial Create Searchunit', '2010-03-23 21:09:30', NULL),
(123, 15, 6, 45, 'Financial Create Selectbill', '2010-03-23 21:09:30', NULL),
(124, 15, 6, 46, 'Financial Create Createbill', '2010-03-23 21:09:30', NULL),
(125, 16, 5, 47, 'Maintenance View Viewallmaintenancerequests', '2010-03-23 21:09:30', NULL),
(126, 16, 5, 48, 'Maintenance View Viewmymaintenancerequests', '2010-03-23 21:09:30', NULL),
(127, 16, 5, 49, 'Maintenance View Viewmaintenancerequest', '2010-03-23 21:09:30', NULL),
(128, 16, 6, 50, 'Maintenance Create Createmaintenancerequest', '2010-03-23 21:09:30', NULL),
(129, 11, 5, 51, 'CalendarViewDailyview', '2010-04-14 13:01:54', NULL),
(130, 11, 5, 52, 'CalendarViewViewevent', '2010-04-14 13:01:54', NULL),
(131, 15, 3, 53, 'FinancialUpdateUpdateaccountlink', '2010-04-14 13:01:54', NULL),
(132, 17, 6, 33, 'PaymentCreateEnterpayment', '2010-04-14 13:01:54', NULL),
(133, 6, 5, 54, 'UnitViewViewallapartments', '2010-04-14 13:01:54', NULL),
(134, 6, 5, 55, 'UnitViewViewapartment', '2010-04-14 13:01:54', NULL),
(135, 6, 5, 56, 'UnitViewViewlease', '2010-04-14 13:01:54', NULL),
(136, 6, 5, 57, 'UnitViewViewleaselist', '2010-04-14 13:01:54', NULL),
(137, 6, 4, 58, 'UnitDeleteDeleteapartment', '2010-04-14 13:01:54', NULL),
(138, 6, 6, 59, 'UnitCreateCreateapartment', '2010-04-14 13:01:54', NULL),
(139, 6, 9, 60, 'UnitLeasewizardStartleasewizard', '2010-04-14 13:01:54', NULL),
(140, 6, 3, 61, 'UnitUpdateCancellease', '2010-04-14 13:01:54', NULL),
(141, 6, 3, 62, 'UnitUpdateUpdateapartment', '2010-04-14 13:01:54', NULL),
(142, 6, 3, 6, 'UnitUpdateGetregions', '2010-04-14 13:01:54', NULL),
(143, 5, 2, 63, 'UserIndex', '2010-04-14 13:01:54', NULL),
(144, 5, 6, 63, 'UserCreate', '2010-04-14 13:01:54', NULL),
(145, 5, 8, 63, 'UserJoin', '2010-04-14 13:01:54', NULL),
(146, 6, 5, 63, 'UnitViewViewunit', '2010-04-14 14:02:16', NULL),
(147, 6, 5, 64, 'UnitViewViewallunits', '2010-04-14 14:02:16', NULL),
(148, 5, 2, 65, 'UserIndex', '2010-04-14 14:02:16', NULL),
(149, 5, 6, 65, 'UserCreate', '2010-04-14 14:02:16', NULL),
(150, 5, 8, 65, 'UserJoin', '2010-04-14 14:02:16', NULL);

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `id` int(6) NOT NULL auto_increment,
  `name` varchar(20) character set latin1 NOT NULL,
  `countryId` int(6) default '1',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `province`
--

REPLACE INTO `province` (`id`, `name`, `countryId`, `dateCreated`, `dateUpdated`) VALUES(1, 'Provincia De Buenos ', 1, '2009-09-22 00:00:00', '0000-00-00 00:00:00');
REPLACE INTO `province` (`id`, `name`, `countryId`, `dateCreated`, `dateUpdated`) VALUES(2, 'blahst', 4, '2009-11-05 22:38:58', '2009-11-05 22:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  `protected` tinyint(1) NOT NULL default '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This entity represents the roles that this application has' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `role`
--

REPLACE INTO `role` (`id`, `name`, `protected`, `dateCreated`, `dateUpdated`) VALUES(1, 'admin', 1, '2010-02-06 18:20:09', '2010-02-06 18:20:13');
REPLACE INTO `role` (`id`, `name`, `protected`, `dateCreated`, `dateUpdated`) VALUES(2, 'member', 1, '2010-02-06 18:20:27', '2010-02-06 00:00:00');
REPLACE INTO `role` (`id`, `name`, `protected`, `dateCreated`, `dateUpdated`) VALUES(3, 'viewer', 1, '2010-02-06 18:20:37', '2010-02-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rolePermission`
--

DROP TABLE IF EXISTS `rolePermission`;
CREATE TABLE IF NOT EXISTS `rolePermission` (
  `id` int(11) NOT NULL auto_increment,
  `roleId` int(11) NOT NULL REFERENCES `apmgr`.`role` ( `id` ) ON  DELETE  CASCADE  ON  UPDATE  CASCADE,
  `permissionId` int(11) NOT NULL REFERENCES `apmgr`.`permission` ( `id` ) ON  DELETE  CASCADE  ON  UPDATE  CASCADE,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tuple` (`roleId`,`permissionId`),
  KEY `roleId` (`roleId`),
  KEY `permissionId` (`permissionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Relation between roles and permissions' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rolePermission`
--

REPLACE INTO `rolePermission` (`id`, `roleId`, `permissionId`, `dateCreated`, `dateUpdated`) VALUES(1, 2, 108, '2010-03-24 18:33:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenet`
--

DROP TABLE IF EXISTS `tenet`;
CREATE TABLE IF NOT EXISTS `tenet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `userId` int(11) NOT NULL,
  `leaseId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`userId`),
  INDEX (`leaseId`),  
  CONSTRAINT `tenet_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tenet_ibfk_2` FOREIGN KEY (`leaseId`) REFERENCES `lease` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tenet`
--


-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `userId` int(11) NOT NULL REFERENCES user (id),
  `comment` varchar(500) DEFAULT NULL,
  `action` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX (`userId`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `number` varchar(50) NOT NULL,
  `apartmentId` int(10) unsigned NOT NULL,
  `unitModelId` int(10) unsigned NOT NULL,
  `size` int(11) unsigned NOT NULL COMMENT 'In the us this is sq ft.  We''ll need to translate this field according to local measurements',
  `numBeds` tinyint(3) unsigned NOT NULL,
  `numBaths` decimal(2,1) unsigned NOT NULL,
  `numFloors` tinyint(3) unsigned NOT NULL COMMENT '1 story, 2 story, etc',
  `yearBuilt` year(4) NOT NULL,
  `yearRenovated` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX (`number`),
  INDEX (`apartmentId`),
  INDEX (`unitModelId`),
  CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`apartmentId`) REFERENCES `apartment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `unit_ibfk_2` FOREIGN KEY (`unitModelId`) REFERENCES `unitModel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `unitAmenity`
--

DROP TABLE IF EXISTS `unitAmenity`;
CREATE TABLE IF NOT EXISTS `unitAmenity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `unitId` int(10) unsigned NOT NULL REFERENCES unit (id),
  `amenityId` int(10) unsigned NOT NULL REFERENCES amenity (id),
  PRIMARY KEY (`id`),
  INDEX (`unitId`),
  INDEX (`amenityId`),
  CONSTRAINT `unitAmenity_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `unitAmenity_ibfk_2` FOREIGN KEY (`amenityId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unitLease`
--

DROP TABLE IF EXISTS `unitModel`;
CREATE TABLE IF NOT EXISTS `unitModel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) UNIQUE NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `unitLease`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(150) NOT NULL,
  `username` varchar(90) NOT NULL,
  `password` varchar(250) NOT NULL,
  `emailAddress` varchar(250) NOT NULL,
  `dob` datetime NOT NULL,
  `phone` varchar(90) default NULL,
  `mobile` varchar(90) default NULL,
  `fax` varchar(90) default NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The user table.' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

REPLACE INTO `user` (`id`, `firstName`, `lastName`, `username`, `password`, `emailAddress`, `dob`, `phone`, `mobile`, `fax`, `dateCreated`, `dateUpdated`) VALUES(1, 'Jorge', 'Vazquez', 'jvazquez', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'jorgeomar.vazquez@gmail.com', '1985-04-22 14:00:00', NULL, NULL, NULL, '2009-09-27 16:58:26', '2009-09-27 16:58:30');
REPLACE INTO `user` (`id`, `firstName`, `lastName`, `username`, `password`, `emailAddress`, `dob`, `phone`, `mobile`, `fax`, `dateCreated`, `dateUpdated`) VALUES(2, 'Chango', 'Lolo', 'clololo', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'lolo@gmail.com', '1985-04-22 00:00:00', NULL, NULL, NULL, '2009-09-28 21:03:18', '2009-09-28 21:03:18');
REPLACE INTO `user` (`id`, `firstName`, `lastName`, `username`, `password`, `emailAddress`, `dob`, `phone`, `mobile`, `fax`, `dateCreated`, `dateUpdated`) VALUES(3, 'Cholo', 'Chango', 'cchango', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'chango@gmail.com', '1985-04-22 00:00:00', NULL, NULL, NULL, '2009-09-28 21:03:52', '2009-09-28 21:03:52');
REPLACE INTO `user` (`id`, `firstName`, `lastName`, `username`, `password`, `emailAddress`, `dob`, `phone`, `mobile`, `fax`, `dateCreated`, `dateUpdated`) VALUES(5, 'John', 'Lopez', 'jlopez', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'jorgeomar.vazquez@gmail.com', '1985-09-22 00:00:00', NULL, NULL, NULL, '2009-09-28 21:03:52', '2009-12-17 19:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `userRole`
--

DROP TABLE IF EXISTS `userRole`;
CREATE TABLE IF NOT EXISTS `userRole` (
  `id` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`userId`),
  KEY `role_id` (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This interrelation tables shows the roles that a user has' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userRole`
--

REPLACE INTO `userRole` (`id`, `userId`, `roleId`, `dateCreated`, `dateUpdated`) VALUES(1, 1, 1, '2009-09-27 16:58:40', '2009-09-27 16:58:43');
REPLACE INTO `userRole` (`id`, `userId`, `roleId`, `dateCreated`, `dateUpdated`) VALUES(2, 2, 3, '2009-09-28 21:03:18', '2009-09-28 21:03:18');
REPLACE INTO `userRole` (`id`, `userId`, `roleId`, `dateCreated`, `dateUpdated`) VALUES(3, 3, 3, '2009-09-28 21:03:52', '2009-09-28 21:03:52');
REPLACE INTO `userRole` (`id`, `userId`, `roleId`, `dateCreated`, `dateUpdated`) VALUES(4, 5, 2, '2009-10-03 18:02:59', '2009-12-19 15:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `zipLocation`
--

DROP TABLE IF EXISTS `zipLocation`;
CREATE TABLE IF NOT EXISTS `zipLocation` (
  `id` int(11) NOT NULL,
  `cityId` int(11) NOT NULL,
  `zipcode` varchar(15) character set utf8 NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cityId` (`cityId`,`zipcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Holds the zipcode information and relates to city.  Used for';

--
-- Dumping data for table `zipLocation`
--


-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2010 at 07:17 AM
-- Server version: 5.0.90
-- PHP Version: 5.2.13-pl0-gentoo

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Structure for view `maintenanceRequestView`
--
DROP TABLE IF EXISTS `maintenanceRequestView`;
DROP VIEW IF EXISTS `maintenanceRequestView`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `maintenanceRequestView` AS select `mr`.`id` AS `id`,`mr`.`dateCreated` AS `dateCreated`,`mr`.`dateUpdated` AS `dateUpdated`,`mr`.`unitId` AS `unitId`,`mr`.`requestorId` AS `requestorId`,`mr`.`title` AS `title`,`mr`.`description` AS `description`,`mr`.`status` AS `status`,`mr`.`assignedTo` AS `assignedTo`,`unit`.`number` AS `unitNumber`,`requestor`.`firstName` AS `requestorFirstName`,`requestor`.`lastName` AS `requestorLastName`,`assigned`.`firstName` AS `assignedFirstName`,`assigned`.`lastName` AS `assignedLastName` from (((`maintenanceRequest` `mr` join `unit` on((`mr`.`unitId` = `unit`.`id`))) join `user` `requestor` on((`mr`.`requestorId` = `requestor`.`id`))) left join `user` `assigned` on((`mr`.`assignedTo` = `assigned`.`id`)));

--
-- VIEW  `maintenanceRequestView`
-- Data: None
--


SET FOREIGN_KEY_CHECKS=1;


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

SET FOREIGN_KEY_CHECKS=1;