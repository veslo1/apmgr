-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2010 at 09:59 PM
-- Server version: 5.0.90
-- PHP Version: 5.2.12-pl0-gentoo

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
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` int(11) unsigned NOT NULL,
  `orientation` enum('debit','credit') NOT NULL,
  `isDiscount` bit(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `account`
--

REPLACE INTO `account` (`id`, `dateCreated`, `dateUpdated`, `name`, `number`, `orientation`, `isDiscount`) VALUES
(1, '2010-02-02 16:55:06', '2010-02-02 16:55:06', 'test', 1234, 'debit', '\0'),
(2, '2010-02-02 17:00:45', '2010-02-02 17:00:45', 'test12', 54321, 'credit', '\0');

-- --------------------------------------------------------

--
-- Table structure for table `accountLink`
--

DROP TABLE IF EXISTS `accountLink`;
CREATE TABLE IF NOT EXISTS `accountLink` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `billTypeId` int(10) unsigned NOT NULL,
  `debitAccountId` int(10) unsigned NOT NULL,
  `creditAccountId` int(10) unsigned NOT NULL,
  `discountAccountId` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `billTypeId` (`billTypeId`,`debitAccountId`,`creditAccountId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `accountLink`
--

REPLACE INTO `accountLink` (`id`, `dateCreated`, `dateUpdated`, `name`, `billTypeId`, `debitAccountId`, `creditAccountId`, `discountAccountId`) VALUES
(1, '2010-02-06 04:05:17', '2010-02-06 04:05:17', 'test', 2, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accountTransaction`
--

DROP TABLE IF EXISTS `accountTransaction`;
CREATE TABLE IF NOT EXISTS `accountTransaction` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `datePosted` datetime NOT NULL,
  `accountId` int(10) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  `referenceNumber` int(11) NOT NULL,
  `side` enum('credit','debit') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `accountId` (`accountId`,`transactionId`,`referenceNumber`,`side`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `accountTransaction`
--

REPLACE INTO `accountTransaction` (`id`, `dateCreated`, `dateUpdated`, `amount`, `datePosted`, `accountId`, `transactionId`, `referenceNumber`, `side`) VALUES
(1, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 100.00, '2009-02-02 00:00:00', 1, 21, 1234, 'debit'),
(2, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 100.00, '2009-02-02 00:00:00', 2, 21, 1234, 'credit'),
(3, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 51.00, '2009-02-02 00:00:00', 1, 21, 1234, 'debit'),
(4, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 51.00, '2009-02-02 00:00:00', 2, 21, 1234, 'credit');

-- --------------------------------------------------------

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `actions`
--

REPLACE INTO `actions` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Error', NULL, 0, '2010-02-06 19:07:24', NULL),
(2, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-02-06 19:07:24', NULL),
(3, 'Db', NULL, 1, '2010-02-06 19:07:24', NULL),
(4, 'Text', NULL, 1, '2010-02-06 19:07:24', NULL),
(5, 'Read', NULL, 1, '2010-02-06 19:07:24', NULL),
(6, 'Getregions', NULL, 1, '2010-02-06 19:07:24', NULL),
(7, 'Delete', '/images/dashboard/onebit_32.gif', 1, '2010-02-06 19:07:24', NULL),
(8, 'Noaccess', NULL, 1, '2010-02-06 19:07:24', NULL),
(9, 'Search', NULL, 1, '2010-02-06 19:07:24', NULL),
(10, 'Help', NULL, 1, '2010-02-06 19:07:24', NULL),
(11, 'Changepwd', NULL, 1, '2010-02-06 19:07:24', NULL),
(12, 'Changerole', NULL, 1, '2010-02-06 19:07:24', NULL),
(13, 'Logout', NULL, 1, '2010-02-06 19:07:24', NULL),
(14, 'Viewunittenet', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(15, 'Searchaddtenet', NULL, 1, '2010-02-06 19:07:24', NULL),
(16, 'Addtounit', NULL, 1, '2010-02-06 19:07:24', NULL),
(17, 'Unitmodelindex', '/images/dashboard/onebit_01.gif', 1, '2010-02-06 19:07:24', NULL),
(18, 'Amenityindex', '/images/dashboard/onebit_01.gif', 1, '2010-02-06 19:07:24', NULL),
(19, 'Createunitsingle', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(20, 'Createunitbulk', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(21, 'Createunitmodel', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(22, 'Createunitamenity', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(23, 'Enterpayment', NULL, 1, '2010-02-06 19:07:24', NULL),
(24, 'Update', '/images/dashboard/onebit_20.gif', 1, '2010-02-06 19:07:24', NULL),
(25, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(26, 'Roleaccess', NULL, 1, '2010-02-06 19:07:24', NULL),
(27, 'Create', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(28, 'Viewallmodules', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(29, 'Viewallaccounts', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(30, 'Viewaccount', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(31, 'Viewallaccountlinks', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(32, 'Createaccount', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(33, 'Createaccountlink', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amenity`
--

DROP TABLE IF EXISTS `amenity`;
CREATE TABLE IF NOT EXISTS `amenity` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds the amenities of the apt such as ceiling fan, furnishe' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `amenity`
--

REPLACE INTO `amenity` (`id`, `dateCreated`, `dateUpdated`, `name`) VALUES
(1, '2010-01-25 17:26:34', '2010-01-25 17:26:34', 'Furnished'),
(2, '2010-01-25 17:58:14', '2010-01-25 17:58:14', 'W/D Connections'),
(3, '2010-01-25 17:59:11', '2010-01-25 17:59:11', 'Ceiling Fans'),
(4, '2010-01-25 18:01:04', '2010-01-25 18:01:04', 'Electric');

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

DROP TABLE IF EXISTS `apartment`;
CREATE TABLE IF NOT EXISTS `apartment` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `addressOne` varchar(50) NOT NULL,
  `addressTwo` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores the apartments' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `apartment`
--

REPLACE INTO `apartment` (`id`, `name`, `dateCreated`, `dateUpdated`, `addressOne`, `addressTwo`) VALUES
(2, 'test126', '2009-12-04 01:48:50', '2009-12-04 01:55:23', 't12', 't12'),
(5, 'test123', '2009-12-04 01:49:31', '2009-12-04 02:59:44', 't123', 't1234');

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
CREATE TABLE IF NOT EXISTS `applicant` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`)
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
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `originalAmountDue` decimal(10,2) NOT NULL,
  `dueDate` datetime NOT NULL COMMENT 'due date of bill',
  `accountLinkId` int(11) unsigned NOT NULL,
  `isPaid` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `accountBillTypeId` (`accountLinkId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bill`
--

REPLACE INTO `bill` (`id`, `dateCreated`, `dateUpdated`, `originalAmountDue`, `dueDate`, `accountLinkId`, `isPaid`) VALUES
(1, '2010-01-01 15:27:58', '2010-01-01 15:27:58', 100.22, '2010-02-15 15:28:22', 1, 0),
(2, '2010-01-05 15:49:31', '2010-01-05 15:49:36', 51.34, '2010-01-20 15:49:52', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `billType`
--

DROP TABLE IF EXISTS `billType`;
CREATE TABLE IF NOT EXISTS `billType` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `billType`
--

REPLACE INTO `billType` (`id`, `dateCreated`, `dateUpdated`, `name`) VALUES
(1, '2010-02-05 00:00:00', '2010-02-05 00:00:00', 'Rent'),
(2, '2010-02-05 00:00:00', '2010-02-05 00:00:00', 'Fee'),
(3, '2010-02-05 00:00:00', '2010-02-05 00:00:00', 'Security Deposit'),
(4, '2010-02-05 00:00:00', '2010-02-05 00:00:00', 'Refund');

-- --------------------------------------------------------

--
-- Table structure for table `billUnit`
--

DROP TABLE IF EXISTS `billUnit`;
CREATE TABLE IF NOT EXISTS `billUnit` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `billId` int(10) unsigned NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `billId` (`billId`,`unitId`),
  KEY `billId_2` (`billId`),
  KEY `unitId` (`unitId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `billUnit`
--

REPLACE INTO `billUnit` (`id`, `dateCreated`, `dateUpdated`, `billId`, `unitId`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 13),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 13);

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

REPLACE INTO `city` (`id`, `name`, `provinceId`, `latitude`, `longitude`, `dateCreated`, `dateUpdated`, `url`) VALUES
(1, 'Dique Luján', 1, '34°21¿14¿S', '58°42¿29¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Dique_Luj%C3%A1n'),
(2, 'Grand Bourg', 1, '34°29¿S', '58°43¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Grand_Bourg'),
(3, 'Sourigues', 1, '35°02¿S', '60°15¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Sourigues_(Buenos_Aires)'),
(4, 'Nordelta', 1, '34°35¿S', '58°35¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Nordelta'),
(5, 'Nueve de Abril', 1, '34°48¿54¿S', '58°28¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Nueve_de_Abril'),
(6, 'Castelar', 1, '34°40¿00¿S', '58°40¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Castelar'),
(7, 'Santos Lugares', 1, '34°36¿S', '58°33¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Santos_Lugares'),
(8, 'Turdera', 1, '34°46¿60¿S', '58°23¿59¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Turdera'),
(9, 'Paso del Rey', 1, '34°38¿60¿S', '58°46¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Paso_del_Rey'),
(11, 'Luis Guillón', 1, '34°47¿60¿S', '58°27¿0¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Luis_Guill%C3%B3n'),
(12, 'La Tablada', 1, '34°42¿00¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/La_Tablada'),
(13, 'Vicente López', 1, '34°31¿60¿S', '58°28¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Vicente_L%C3%B3pez_(Buenos_Aires)'),
(14, 'Glew', 1, '34°53¿17¿S', '58°23¿03¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Glew'),
(15, 'Villa Chacabuco', 1, '34°34¿59¿S', '58°31¿52¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Chacabuco'),
(16, 'Pontevedra', 1, '34°45¿06¿S', '58°42¿42¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pontevedra_(Buenos_Aires)'),
(17, 'Once de Septiembre', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Once_de_Septiembre'),
(18, 'Muñiz', 1, '34°32¿60¿S', '58°42¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mu%C3%B1iz'),
(19, 'Bella Vista', 1, '34°32¿60¿S', '58°40¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bella_Vista_(Buenos_Aires)'),
(21, 'Alejandro Korn', 1, '34°58¿58¿S', '58°22¿57¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Alejandro_Korn_(Buenos_Aires)'),
(22, 'Rafael Castillo', 1, '34°43¿00¿S', '58°37¿34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Rafael_Castillo'),
(23, 'Churruca ', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Churruca_(Buenos_Aires)'),
(24, 'Ingeniero Maschwitz', 1, '34°22¿53¿S', '58°45¿25¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Maschwitz'),
(25, 'Juan María Gutiérrez ', 1, '34°49¿60¿S', '58°12¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Juan_Mar%C3%ADa_Guti%C3%A9rrez_(Buenos_Aires)'),
(26, 'Rafael Calzada', 1, '34°47¿60¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Rafael_Calzada'),
(27, 'Bernal', 1, '34°42¿00¿S', '58°17¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bernal'),
(28, 'Villa Bosch', 1, '34°34¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Bosch'),
(29, 'Temperley', 1, '34°46¿60¿S', '58°23¿59¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Temperley'),
(31, 'Belén de Escobar', 1, '34°20¿48¿S', '58°49¿07¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bel%C3%A9n_de_Escobar'),
(32, 'Pereyra', 1, '34°49¿60¿S', '58°06¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pereyra'),
(34, 'José C. Paz', 1, '34°31¿08¿S', '58°45¿03¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_C._Paz'),
(35, 'Caseros', 1, '34°37¿46¿S', '58°32¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Caseros'),
(36, 'Villa Lynch', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Lynch'),
(37, 'Tortuguitas', 1, '34°28¿¿S', '58°46¿¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Tortuguitas'),
(38, 'Barrio Montecarlo', 1, '36°15¿00¿S', '61°06¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Barrio_Montecarlo'),
(39, 'La Reja', 1, '34°37¿60¿S', '58°47¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/La_Reja'),
(40, 'San Fernando ', 1, '34°26¿30¿S', '58°33¿30¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Fernando_(Buenos_Aires)'),
(41, 'Matheu ', 1, '34°22¿59¿S', '58°50¿56¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Matheu_(Buenos_Aires)'),
(42, 'San Francisco Solano ', 1, '34°46¿60¿S', '58°19¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Francisco_Solano_(Buenos_Aires)'),
(43, 'Loma Hermosa', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Loma_Hermosa'),
(44, 'Valentín Alsina ', 1, '34°40¿60¿S', '58°25¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Valent%C3%ADn_Alsina_(Buenos_Aires)'),
(45, 'Lomas de Zamora', 1, '34°46¿00¿S', '58°23¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Lomas_de_Zamora'),
(46, 'El Palomar ', 1, '34°32¿30¿S', '58°36¿55¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Palomar_(Buenos_Aires)'),
(47, 'Villa Eduardo Madero', 1, '34°42¿00¿S', '58°30¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Eduardo_Madero'),
(48, 'Máximo Paz ', 1, '34°55¿60¿S', '58°37¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/M%C3%A1ximo_Paz_(Buenos_Aires)'),
(49, 'Ramos Mejía', 1, '34°37¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ramos_Mej%C3%ADa'),
(50, 'Ciudad Evita', 1, '34°43¿20¿S', '58°31¿15¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ciudad_Evita'),
(51, 'Lanús', 1, '34°42¿55¿S', '58°24¿28¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Lan%C3%BAs'),
(52, 'Gregorio de Laferrere ', 1, '34°42¿00¿S', '58°32¿17¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gregorio_de_Laferrere_(Buenos_Aires)'),
(53, 'San Isidro ', 1, '34°28¿15¿S', '58°31¿43¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Isidro_(Buenos_Aires)'),
(54, 'Berazategui', 1, '34°43¿59¿S', '58°15¿19¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Berazategui'),
(55, 'Villa General José Tomás Guido', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_General_Jos%C3%A9_Tom%C3%A1s_Guido'),
(56, 'Quilmes ', 1, '34°43¿13¿S', '58°16¿10¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Quilmes_(Buenos_Aires)'),
(57, 'Libertad ', 1, '34°42¿00¿S', '58°40¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Libertad_(Buenos_Aires)'),
(58, 'Ranelagh', 1, '34°47¿60¿S', '58°12¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ranelagh'),
(59, 'Mariano Acosta ', 1, '34°43¿34¿S', '58°47¿27¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mariano_Acosta_(Buenos_Aires)'),
(60, 'Dock Sud', 1, '34°37¿60¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Dock_Sud'),
(61, 'Hurlingham ', 1, '34°36¿S', '58°38¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Hurlingham_(Buenos_Aires)'),
(62, 'Longchamps', 1, '34°51¿34¿S', '58°23¿18¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Longchamps'),
(63, 'Martínez ', 1, '34°28¿60¿S', '58°30¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mart%C3%ADnez_(Buenos_Aires)'),
(64, 'Quintas de Sarandí', 1, '34°40¿13¿S', '58°18¿56¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Quintas_de_Sarand%C3%AD'),
(65, 'Plátanos', 1, '34°46¿60¿S', '58°10¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pl%C3%A1tanos'),
(66, 'Ezeiza', 1, '34°50¿17¿S', '58°31¿02¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ezeiza'),
(67, 'José León Suárez', 1, '34°31¿60¿S', '58°34¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_Le%C3%B3n_Su%C3%A1rez'),
(68, 'Sáenz Peña ', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/S%C3%A1enz_Pe%C3%B1a_(Buenos_Aires)'),
(69, 'Aeropuerto Internacional Ezeiza', 1, '34°49¿25¿S', '58°31¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Aeropuerto_Internacional_Ezeiza'),
(70, 'González Catán', 1, '34°46¿03¿S', '58°38¿34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gonz%C3%A1lez_Cat%C3%A1n'),
(71, 'Guernica', 1, '34°55¿02¿S', '58°23¿13¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Guernica_(Argentina)'),
(72, 'Gobernador Julio A. Costa', 1, '34°49¿00¿S', '58°13¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gobernador_Julio_A._Costa'),
(74, 'Martín Coronado ', 1, '34°36¿S', '58°33¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mart%C3%ADn_Coronado_(Buenos_Aires)'),
(75, 'Villa Gregoria Matorras', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Gregoria_Matorras'),
(76, 'Merlo ', 1, '34°39¿55¿S', '58°43¿39¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Merlo_(Buenos_Aires)'),
(77, 'Hudson ', 1, '34°47¿S', '58°24¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Hudson_(Buenos_Aires)'),
(78, 'Villa Libertad', 1, '34°34¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Libertad'),
(79, 'General Pacheco', 1, '34°27¿50¿S', '58°39¿13¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/General_Pacheco'),
(80, 'Villa Ballester', 1, '34°31¿60¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Ballester'),
(83, 'Villa Fiorito', 1, '34°42¿00¿S', '58°27¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Fiorito'),
(85, 'San Vicente ', 1, '35°1¿29¿S', '58°25¿26¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Vicente_(Buenos_Aires)'),
(86, 'Barrio Don Orione', 1, '34°51¿00¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Barrio_Don_Orione'),
(87, 'San Miguel ', 1, '34°31¿26¿S', '58°46¿46¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Miguel_(Buenos_Aires)'),
(88, 'Malvinas Argentinas', 1, '34°30¿S', '58°41¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Malvinas_Argentinas_(Malvinas_Argentinas)'),
(89, 'Remedios de Escalada ', 1, '34°35¿46¿S', '58°32¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Remedios_de_Escalada_(Buenos_Aires)'),
(91, 'Marcos Paz ', 1, '34°46¿54¿S', '58°50¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Marcos_Paz_(Buenos_Aires)'),
(92, 'Villa Coronel José M. Zapiola', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Coronel_Jos%C3%A9_M._Zapiola'),
(93, 'Estanislao Severo Zeballos ', 1, '34°49¿00¿S', '58°15¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Estanislao_Severo_Zeballos_(Buenos_Aires)'),
(94, 'José Ingenieros ', 1, '34°35¿46¿S', '58°32¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_Ingenieros_(Buenos_Aires)'),
(95, 'Villa General Antonio J. de Sucre', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_General_Antonio_J._de_Sucre'),
(97, 'Villa Bernardo Monteagudo', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Bernardo_Monteagudo'),
(98, 'Ingeniero Juan Allan', 1, '34°52¿00¿S', '58°10¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Juan_Allan'),
(99, 'Villa Maipú', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Maip%C3%BA'),
(100, 'Del Viso', 1, '34°27¿00¿S', '58°47¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Del_Viso'),
(101, 'Malvinas Argentinas', 1, '34°47¿60¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Malvinas_Argentinas_(Almirante_Brown)'),
(102, 'San Antonio de Padua ', 1, '34°40¿00¿S', '58°42¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Antonio_de_Padua_(Buenos_Aires)'),
(103, 'Villa Centenario', 1, '34°46¿00¿S', '58°23¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Centenario'),
(104, 'Remedios de Escalada', 1, '34°43¿60¿S', '58°22¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Remedios_de_Escalada_(Lan%C3%BAs)'),
(105, 'El Libertador ', 1, '34°34¿S', '58°34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Libertador_(Buenos_Aires)'),
(106, 'Florencio Varela ', 1, '34°49¿38¿S', '58°23¿44¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Florencio_Varela_(Buenos_Aires)'),
(107, 'Área Reserva Cinturón Ecológico', 1, '34°39¿S', '58°22¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/%C3%81rea_Reserva_Cintur%C3%B3n_Ecol%C3%B3gico'),
(108, 'Ingeniero Pablo Nogués', 1, '34°28¿S', '58°46¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Pablo_Nogu%C3%A9s'),
(109, 'Ingeniero Adolfo Sourdeaux', 1, '34°28¿S', '58°46¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ingeniero_Adolfo_Sourdeaux'),
(110, 'Villa Luzuriaga', 1, '34°38¿60¿S', '58°34¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Luzuriaga'),
(111, 'Bosques ', 1, '34°49¿00¿S', '58°13¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Bosques_(Buenos_Aires)'),
(112, 'Aldo Bonzi', 1, '34°42¿00¿S', '58°31¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Aldo_Bonzi'),
(113, 'Tristán Suárez', 1, '34°52¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Trist%C3%A1n_Su%C3%A1rez'),
(115, 'Veinte de Junio', 1, '34°45¿06¿S', '58°42¿42¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Veinte_de_Junio'),
(116, 'Acassuso', 1, '34°28¿60¿S', '58°31¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Acassuso'),
(117, 'Haedo', 1, '34°37¿60¿S', '58°36¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Haedo'),
(118, 'Villa General Juan G. Las Heras', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_General_Juan_G._Las_Heras'),
(119, 'Crucecita', 1, '34°40¿05.00¿S', '58°20¿55.00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Crucecita'),
(120, 'Ituzaingó ', 1, '34°40¿00¿S', '58°40¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ituzaing%C3%B3_(Buenos_Aires)'),
(121, 'Béccar', 1, '34°28¿00¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/B%C3%A9ccar'),
(122, 'Lomas del Mirador', 1, '34°38¿60¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Lomas_del_Mirador'),
(123, 'Trujui', 1, '34°27¿54¿S', '58°55¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Trujui'),
(124, 'Tapiales', 1, '34°42¿00¿S', '58°31¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Tapiales'),
(125, 'Isidro Casanova', 1, '34°42¿00¿S', '58°34¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Isidro_Casanova'),
(126, 'Don Torcuato', 1, '34°30¿S', '58°37¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Don_Torcuato'),
(128, 'San Justo ', 1, '34°40¿59¿S', '58°33¿07¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Justo_(Buenos_Aires)'),
(129, 'Villa Adelina', 1, '34°31¿13.31¿S', '58°32¿48.00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Adelina'),
(130, 'Tigre ', 1, '34°25¿33¿S', '58°35¿48¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Tigre_(Buenos_Aires)'),
(131, 'Fátima ', 1, '34°25¿60¿S', '59°00¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/F%C3%A1tima_(Buenos_Aires)'),
(133, 'Maquinista F. Savio', 1, '34°24¿40¿S', '58°47¿54¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Maquinista_F._Savio'),
(134, 'Villa Ayacucho', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Ayacucho'),
(135, 'Parque San Martín', 1, '34°40¿13¿S', '58°43¿56¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Parque_San_Mart%C3%ADn'),
(136, 'Billinghurst', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Billinghurst'),
(137, 'Campo de Mayo', 1, '34°32¿04¿S', '58°40¿18¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Campo_de_Mayo'),
(138, 'Francisco %C3%81lvarez ', 1, '34°37¿60¿S', '58°52¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Francisco_%C3%81lvarez_(Buenos_Aires)'),
(139, 'El Talar ', 1, '34°27¿00¿S', '58°38¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Talar_(Buenos_Aires)'),
(140, 'Presidente Derqui ', 1, '34°29¿50¿S', '58°51¿49¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Presidente_Derqui_(Buenos_Aires)'),
(141, 'Villa Granaderos de San Martín', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Granaderos_de_San_Mart%C3%ADn'),
(142, 'San Martín ', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Mart%C3%ADn_(Buenos_Aires)'),
(143, 'San José %28Almirante Brown%29', 1, '34°47¿60¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Jos%C3%A9_(Almirante_Brown)'),
(144, 'El Jag%C3%BCel ', 1, '34°48¿54¿S', '58°28¿45¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/El_Jag%C3%BCel_(Buenos_Aires)'),
(145, 'Villa Godoy Cruz', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Godoy_Cruz'),
(146, 'Carlos Spegazzini', 1, '34°52¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Carlos_Spegazzini'),
(147, 'Monte Chingolo', 1, '34°43¿00¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Monte_Chingolo'),
(148, 'Pilar ', 1, '34°29¿01¿S', '58°55¿55¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pilar_(Buenos_Aires)'),
(149, 'Barrio Parque General San Martín', 1, '34°34¿20¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Barrio_Parque_General_San_Mart%C3%ADn'),
(150, 'Victoria ', 1, '34°27¿S', '58°34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Victoria_(Buenos_Aires)'),
(151, 'Benavídez', 1, '34°24¿34¿S', '58°42¿34¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Benav%C3%ADdez'),
(152, 'Villa Juan Martín de Pueyrredón', 1, '34°34¿00¿S', '58°32¿50¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Juan_Mart%C3%ADn_de_Pueyrred%C3%B3n'),
(153, 'Piñeiro', 1, '34°31¿60¿S', '58°45¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pi%C3%B1eiro'),
(154, 'José Mármol ', 1, '34°46¿60¿S', '58°22¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Jos%C3%A9_M%C3%A1rmol_(Buenos_Aires)'),
(155, 'Don Bosco ', 1, '34°42¿00¿S', '58°16¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Don_Bosco_(Buenos_Aires)'),
(156, 'Garín', 1, '34°25¿24¿S', '58°45¿43¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gar%C3%ADn'),
(157, 'Gerli', 1, '34°42¿00¿S', '58°20¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Gerli'),
(158, 'Ciudadela ', 1, '34°37¿60¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ciudadela_(Buenos_Aires)'),
(159, 'Villa España', 1, '34°46¿00¿S', '58°12¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Espa%C3%B1a'),
(160, 'San Andrés ', 1, '34°32¿60¿S', '58°31¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/San_Andr%C3%A9s_(Buenos_Aires)'),
(162, 'Ministro Rivadavia', 1, '34°51¿00¿S', '58°22¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Ministro_Rivadavia'),
(163, 'Pablo Podestá ', 1, '34°36¿S', '58°31¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Pablo_Podest%C3%A1_(Buenos_Aires)'),
(164, 'Avellaneda ', 1, '34°39¿45¿S', '58°21¿54¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Avellaneda_(Buenos_Aires)'),
(165, 'Los Polvorines', 1, '34°30¿S', '58°40¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Los_Polvorines'),
(166, 'Burzaco', 1, '34°49¿00¿S', '58°22¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Burzaco'),
(168, 'Morón ', 1, '34°38¿33¿S', '58°37¿05¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Mor%C3%B3n_(Buenos_Aires)'),
(169, 'Boulogne Sur Mer ', 1, '34°30¿00¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Boulogne_Sur_Mer_(Buenos_Aires)'),
(170, 'Villa Domínico', 1, '34°40¿60¿S', '58°19¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_Dom%C3%ADnico'),
(171, 'Claypole', 1, '34°47¿60¿S', '58°19¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Claypole'),
(172, 'Villa La Florida', 1, '34°43¿00¿S', '58°17¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Villa_La_Florida'),
(173, 'Canning ', 1, '34°52¿37¿S', '58°31¿41¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Canning_(Buenos_Aires)'),
(174, 'La Unión ', 1, '34°52¿60¿S', '58°34¿00¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/La_Uni%C3%B3n_(Buenos_Aires)'),
(176, 'Llavallol', 1, '34°46¿60¿S', '58°25¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Llavallol'),
(177, 'Adrogué', 1, '34°48¿02¿S', '58°23¿03¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Adrogu%C3%A9'),
(178, 'Banfield', 1, '34°45¿00¿S', '58°23¿60¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Banfield'),
(179, 'Moreno ', 1, '34°39¿02¿S', '58°47¿23¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Moreno_(Buenos_Aires)'),
(180, 'Manuel Alberti ', 1, '34°29¿01¿S', '58°55¿55¿O', '2009-10-11 21:45:20', '2009-10-11 21:45:20', 'http://es.wikipedia.org/wiki/Manuel_Alberti_(Buenos_Aires)');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All the controllers that we have' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `controllers`
--

REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Error', '/images/dashboard/smile_sad_48.gif', 0, '2010-02-06 19:07:24', '2010-02-13 13:16:59'),
(2, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-02-06 19:07:24', NULL),
(3, 'Update', '/images/dashboard/onebit_20.gif', 1, '2010-02-06 19:07:24', NULL),
(4, 'Delete', '/images/dashboard/onebit_32.gif', 0, '2010-02-06 19:07:24', NULL),
(5, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-02-06 19:07:24', NULL),
(6, 'Create', '/images/dashboard/onebit_48.gif', 1, '2010-02-06 19:07:24', NULL),
(7, 'Login', NULL, 1, '2010-02-06 19:07:24', NULL),
(8, 'Join', NULL, 1, '2010-02-06 19:07:24', NULL),
(9, 'Tenet', NULL, 1, '2010-02-06 19:07:24', NULL),
(10, 'Search', NULL, 1, '2010-02-06 19:07:24', NULL);

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

REPLACE INTO `country` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Americas', '2009-09-14 23:58:18', '2009-11-05 21:35:21'),
(2, 'Argentina', '2009-09-17 20:36:40', '2009-09-17 20:36:40'),
(3, 'Brasil', '2009-09-17 20:36:45', '2009-09-17 20:36:45'),
(4, 'Chile', '2009-09-17 20:37:03', '2009-09-17 20:37:03'),
(5, 'Uruguay', '2009-09-17 20:37:09', '2009-09-17 20:37:09'),
(6, 'Paraguay', '2009-09-17 20:37:14', '2009-09-17 20:37:14');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `eventDateFrom` date NOT NULL COMMENT 'The date that this event happens',
  `eventDateTo` date default NULL COMMENT 'Till when we repeat the event',
  `data` text NOT NULL,
  `recursive` int(11) NOT NULL default '0' COMMENT 'Unit that meassure the recursivness of this event.',
  `recursivePeriod` enum('dd','ww','MM','y') default NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='The events table that holds the particular event' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `events`
--


-- --------------------------------------------------------

--
-- Table structure for table `eventsChilds`
--

DROP TABLE IF EXISTS `eventsChilds`;
CREATE TABLE IF NOT EXISTS `eventsChilds` (
  `id` int(11) NOT NULL auto_increment,
  `eventDate` date NOT NULL COMMENT 'The date that this event happens',
  `startTime` time NOT NULL COMMENT 'When this event starts',
  `endTime` time NOT NULL COMMENT 'When this event ends',
  `eventId` int(11) NOT NULL COMMENT 'Which is the parent event',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `eventId` (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `eventsChilds`
--


-- --------------------------------------------------------

--
-- Table structure for table `eventsNotification`
--

DROP TABLE IF EXISTS `eventsNotification`;
CREATE TABLE IF NOT EXISTS `eventsNotification` (
  `id` int(11) NOT NULL auto_increment,
  `eventId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `confirmed` tinyint(4) default '0',
  `recipients` varchar(90) NOT NULL COMMENT 'The email',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `eventId` (`eventId`),
  KEY `userId` (`userId`),
  KEY `recipients` (`recipients`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains the notifications that are sent to the u' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `eventsNotification`
--


-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

DROP TABLE IF EXISTS `lease`;
CREATE TABLE IF NOT EXISTS `lease` (
  `id` int(10) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `effectiveDate` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `modelRentScheduleId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `unitId` (`unitId`,`modelRentScheduleId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lease`
--


-- --------------------------------------------------------

--
-- Table structure for table `leaseSchedule`
--

DROP TABLE IF EXISTS `leaseSchedule`;
CREATE TABLE IF NOT EXISTS `leaseSchedule` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `modelRentScheduleItemId` int(10) unsigned NOT NULL,
  `discount` decimal(10,2) unsigned NOT NULL,
  `leaseId` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `modelRentScheduleItemId` (`modelRentScheduleItemId`,`leaseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `leaseSchedule`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Logs of the application' AUTO_INCREMENT=34 ;

--
-- Dumping data for table `logs`
--

REPLACE INTO `logs` (`id`, `message`, `dateCreated`) VALUES
(1, 'Query>>>SELECT `messages`.* FROM `messages` ORDER BY `id` ASC', '2010-02-13 16:17:16'),
(2, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:17:35'),
(3, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:18:04'),
(4, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:18:29'),
(5, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:14'),
(6, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:16'),
(7, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:18'),
(8, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:19'),
(9, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:19'),
(10, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:20'),
(11, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` DESC', '2010-02-13 16:19:21'),
(12, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:21'),
(13, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-13 16:19:23'),
(14, 'SELECT `messages`.* FROM `messages` ORDER BY `message` DESC', '2010-02-13 16:19:26'),
(15, 'SELECT `messages`.* FROM `messages` ORDER BY `message` ASC', '2010-02-13 16:19:44'),
(16, 'SELECT `messages`.* FROM `messages` ORDER BY `message` ASC', '2010-02-13 16:28:32'),
(17, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` ASC', '2010-02-13 22:46:42'),
(18, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` DESC', '2010-02-13 22:46:43'),
(19, 'SELECT `role`.* FROM `role` ORDER BY `dateCreated` ASC', '2010-02-13 22:46:44'),
(20, 'SELECT `role`.* FROM `role` ORDER BY `name` DESC', '2010-02-13 22:46:45'),
(21, 'SELECT `role`.* FROM `role` ORDER BY `name` ASC', '2010-02-13 22:46:46'),
(22, 'SELECT `messages`.* FROM `messages` ORDER BY `message` ASC', '2010-02-20 13:19:24'),
(23, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` ASC', '2010-02-20 13:20:43'),
(24, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` DESC', '2010-02-20 13:20:44'),
(25, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` ASC', '2010-02-20 13:20:47'),
(26, 'SELECT `permission`.* FROM `permission` ORDER BY `alias` ASC', '2010-02-20 14:40:19'),
(27, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:25'),
(28, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:27'),
(29, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:28'),
(30, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:45:30'),
(31, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:49:27'),
(32, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:49:29'),
(33, 'SELECT `messages`.* FROM `messages` ORDER BY `identifier` ASC', '2010-02-20 14:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequest`
--

DROP TABLE IF EXISTS `maintenanceRequest`;
CREATE TABLE IF NOT EXISTS `maintenanceRequest` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `requestorId` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` enum('new','assigned','completed') NOT NULL,
  `assignedTo` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `unitId` (`unitId`,`requestorId`,`status`,`assignedTo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequest`
--


-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequestComment`
--

DROP TABLE IF EXISTS `maintenanceRequestComment`;
CREATE TABLE IF NOT EXISTS `maintenanceRequestComment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `maintenanceRequestId` int(10) unsigned NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `maintenanceRequestId` (`maintenanceRequestId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequestComment`
--


-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequestHistory`
--

DROP TABLE IF EXISTS `maintenanceRequestHistory`;
CREATE TABLE IF NOT EXISTS `maintenanceRequestHistory` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `requestorId` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` enum('new','assigned','completed') NOT NULL,
  `assignedTo` int(10) unsigned default NULL,
  `maintenanceRequestId` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `unitId` (`unitId`,`requestorId`,`status`,`assignedTo`),
  KEY `maintenanceRequestId` (`maintenanceRequestId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequestHistory`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `messages`
--

REPLACE INTO `messages` (`id`, `message`, `identifier`, `category`, `language`, `locked`, `dateCreated`, `dateUpdated`) VALUES
(1, 'The message has been saved', 'messageCreated', 'success', 'en_US', 1, '2009-10-31 15:04:39', '2010-02-20 14:41:51'),
(2, 'The message has been updated', 'messageUpdated', 'success', 'en_US', 0, '2009-11-01 14:17:03', '2010-02-13 22:43:47'),
(3, 'The message was deleted', 'msgDeleted', 'success', 'en_US', 0, '2009-11-01 15:34:49', '2010-02-13 22:44:08'),
(4, 'The Message Has Been Deleted', 'roleDeleted', 'success', 'en_US', 1, '2009-11-01 16:45:10', '2009-11-05 22:57:28'),
(5, 'The Role Has Been Saved', 'roleSaved', 'success', 'en_US', 1, '2009-11-01 17:12:41', '2009-11-05 22:57:28'),
(6, 'The application is missing an important part in order to continue working', 'haveId', 'error', 'en_US', 1, '2009-10-03 20:52:44', '2009-11-08 12:50:14'),
(7, 'The selected resource doesn''t exists yet.Please,try again later or verify your URL information', 'resourceExist', 'error', 'en_US', 1, '2009-10-03 20:53:37', '2009-11-08 01:18:44'),
(8, 'You do not have enough permissions to edit that resource', 'canEdit', 'error', 'en_US', 1, '2009-10-03 20:54:21', '2009-11-08 01:18:44'),
(9, 'We couldn''t save your information.An error happened', 'saveWork', 'error', 'en_US', 1, '2009-10-03 22:06:16', '2009-11-08 01:18:44'),
(10, 'The user account doesn''t exists.\r\nPlease, create an account and try again later.', 'unknownuser', 'error', 'en_US', 1, '2009-10-11 20:54:16', '2009-11-08 01:18:44'),
(11, 'The specified password is incorrect.Please, verify your password and retry', 'invalidPassword', 'error', 'en_US', 1, '2009-10-11 20:56:13', '2009-11-08 01:18:44'),
(12, 'The specified value already exists', 'valueExists', 'error', 'en_US', 1, '2009-10-31 13:02:56', '2009-11-08 01:18:44'),
(13, 'The message couldn''t be saved', 'msgUpdateFail', 'error', 'en_US', 1, '2009-11-01 14:19:35', '2009-11-08 01:18:44'),
(14, 'The Role Couldn''t Be Deleted', 'roleDeletedFail', 'error', 'en_US', 1, '2009-11-01 17:15:01', '2009-11-08 01:18:44'),
(15, 'The Message Couldn''t be deleted', 'msgDeleteFail', 'warning', 'en_US', 1, '2009-11-01 16:47:53', '2009-11-08 02:00:46'),
(16, 'The Role Is No Longer Active', 'roleMissing', 'warning', 'en_US', 1, '2009-11-01 17:16:15', '2009-11-08 02:01:07'),
(17, 'The password update failed', 'pwdupdatefail', 'error', 'en_US', 1, '2009-12-17 18:35:03', NULL),
(18, 'The password was successfully changed.', 'pwdupdatepass', 'success', 'en_US', 1, '2009-12-17 18:39:43', NULL),
(19, 'Roles Updated.', 'roleupdatepass', 'success', 'en_US', 1, '2009-12-19 11:07:53', NULL),
(20, 'One or multiple roles failed while trying to be saved', 'roleupdatefail', 'error', 'en_US', 1, '2009-12-19 11:09:10', NULL),
(21, 'Probando mensajes que se muestran', 'testinglocale', 'warning', 'es_AR', 1, '2009-12-20 18:08:24', '2009-12-20 18:22:26'),
(22, 'The message could not be saved', 'roleAclSaveFail', 'error', 'en_US', 1, '2010-01-10 08:48:02', NULL),
(23, 'The Access Has Been Deleted', 'rolePermPass', 'success', 'en_US', 1, '2010-02-04 00:15:21', NULL),
(24, 'The Permission Could Not Be Deleted', 'rolePermFail', 'error', 'en_US', 1, '2010-02-04 00:15:54', NULL),
(25, 'The Permission Was Saved', 'rolePermSaved', 'success', 'en_US', 1, '2010-02-05 21:17:46', NULL),
(26, 'The permission could not be saved', 'rolePermFailed', 'success', 'en_US', 0, '2010-02-05 21:26:23', '2010-02-13 22:44:52'),
(27, 'The Specified Permission already exists.', 'rolePermExists', 'warning', 'en_US', 1, '2010-02-05 21:36:03', NULL),
(28, 'The selected unit does not have any record.', 'nobillsforunit', 'error', 'en_US', 1, '2010-02-09 20:40:59', '2010-02-09 21:26:25'),
(29, 'An unidentified  error happened.', 'unhandledMsg', 'error', 'en_US', 1, '2010-02-20 14:41:34', NULL),
(30, 'The specified permission does not exist.', 'pmsfakeId', 'error', 'en_US', 1, '2010-02-20 14:52:14', NULL),
(31, 'An error happened while saving the alias.', 'pmSaveFail', 'error', 'en_US', 1, '2010-02-20 15:56:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migration_version`
--

DROP TABLE IF EXISTS `migration_version`;
CREATE TABLE IF NOT EXISTS `migration_version` (
  `version` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration_version`
--


-- --------------------------------------------------------

--
-- Table structure for table `modelRentSchedule`
--

DROP TABLE IF EXISTS `modelRentSchedule`;
CREATE TABLE IF NOT EXISTS `modelRentSchedule` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitModelId` int(10) unsigned NOT NULL,
  `effectiveDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `unitModelId` (`unitModelId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `modelRentSchedule`
--

REPLACE INTO `modelRentSchedule` (`id`, `dateCreated`, `dateUpdated`, `unitModelId`, `effectiveDate`) VALUES
(1, '2010-02-15 01:09:33', '2010-02-15 01:09:33', 2, '2009-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `modelRentScheduleItem`
--

DROP TABLE IF EXISTS `modelRentScheduleItem`;
CREATE TABLE IF NOT EXISTS `modelRentScheduleItem` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `modelRentScheduleId` int(10) unsigned NOT NULL,
  `rentAmount` decimal(10,2) unsigned NOT NULL,
  `numMonths` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `modelRentScheduleId` (`modelRentScheduleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `modelRentScheduleItem`
--

REPLACE INTO `modelRentScheduleItem` (`id`, `dateCreated`, `dateUpdated`, `modelRentScheduleId`, `rentAmount`, `numMonths`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 551.43, 12),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 500.34, 6),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 480.82, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The content of the modules folder, ie all the modules' AUTO_INCREMENT=16 ;

--
-- Dumping data for table `modules`
--

REPLACE INTO `modules` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'logs', '/images/dashboard/info.gif', 1, '2010-02-06 19:07:24', NULL),
(2, 'city', '/images/dashboard/CitySearch.gif', 1, '2010-02-06 19:07:24', NULL),
(3, 'default', '/images/dashboard/ok.gif', 1, '2010-02-06 19:07:24', NULL),
(4, 'messages', '/images/dashboard/messages.gif', 1, '2010-02-06 19:07:24', NULL),
(5, 'user', '/images/dashboard/user_48.gif', 1, '2010-02-06 19:07:24', NULL),
(6, 'unit', '/images/dashboard/home_48.gif', 0, '2010-02-06 19:07:24', NULL),
(8, 'role', '/images/dashboard/role.gif', 1, '2010-02-06 19:07:24', NULL),
(9, 'permission', '/images/dashboard/onebit_04.gif', 1, '2010-02-06 19:07:24', NULL),
(10, 'country', '/images/dashboard/country.gif', 1, '2010-02-06 19:07:24', NULL),
(11, 'calendar', '/images/dashboard/calendar.gif', 1, '2010-02-06 19:07:24', '2010-02-20 16:13:19'),
(12, 'modules', '/images/dashboard/google_48.gif', 1, '2010-02-06 19:07:24', NULL),
(13, 'apartment', '/images/dashboard/apartment.gif', 1, '2010-02-06 19:07:24', NULL),
(14, 'province', '/images/dashboard/onebit_09.gif', 1, '2010-02-06 19:07:24', NULL),
(15, 'financial', NULL, 0, '2010-02-06 19:07:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `billId` int(10) unsigned NOT NULL,
  `amtPaid` double NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  `paymentDetailId` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `billId` (`billId`,`transactionId`),
  KEY `paymentDetailId` (`paymentDetailId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `payment`
--

REPLACE INTO `payment` (`id`, `dateCreated`, `dateUpdated`, `billId`, `amtPaid`, `transactionId`, `paymentDetailId`) VALUES
(1, '2010-02-04 19:19:46', '2010-02-04 19:19:46', 1, 100.22, 4, 9),
(2, '2010-02-04 19:19:46', '2010-02-04 19:19:46', 2, 51.34, 4, 9),
(7, '2010-02-07 15:06:44', '2010-02-07 15:06:44', 1, 100.22, 7, 12),
(8, '2010-02-07 15:06:44', '2010-02-07 15:06:44', 2, 51.34, 7, 12),
(9, '2010-02-07 15:06:48', '2010-02-07 15:06:48', 1, 100.22, 8, 13),
(10, '2010-02-07 15:06:48', '2010-02-07 15:06:48', 2, 51.34, 8, 13),
(29, '2010-02-07 15:41:32', '2010-02-07 15:41:32', 1, 100.22, 18, 23),
(30, '2010-02-07 15:41:32', '2010-02-07 15:41:32', 2, 51.34, 18, 23),
(35, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 1, 100.22, 21, 26),
(36, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 2, 51.34, 21, 26);

-- --------------------------------------------------------

--
-- Table structure for table `paymentDetail`
--

DROP TABLE IF EXISTS `paymentDetail`;
CREATE TABLE IF NOT EXISTS `paymentDetail` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `totalAmount` decimal(10,2) unsigned NOT NULL,
  `payor` varchar(50) NOT NULL,
  `paymentType` enum('cash','credit card','check','money order') NOT NULL,
  `paymentNumber` int(11) NOT NULL COMMENT 'stores the check or cc or money order number',
  `ccName` varchar(50) default NULL,
  `ccExpirationDate` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `paymentType` (`paymentType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `paymentDetail`
--

REPLACE INTO `paymentDetail` (`id`, `dateCreated`, `dateUpdated`, `totalAmount`, `payor`, `paymentType`, `paymentNumber`, `ccName`, `ccExpirationDate`) VALUES
(1, '2010-02-03 23:59:54', '2010-02-03 23:59:54', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(4, '2010-02-04 00:04:11', '2010-02-04 00:04:11', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(6, '2010-02-04 18:39:44', '2010-02-04 18:39:44', 151.56, 'test', 'cash', 1, 'test', '2007-02-04 00:00:00'),
(7, '2010-02-04 18:42:04', '2010-02-04 18:42:04', 151.56, 'test', 'cash', 1, 'test', '2007-02-04 00:00:00'),
(8, '2010-02-04 19:16:10', '2010-02-04 19:16:10', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(9, '2010-02-04 19:19:46', '2010-02-04 19:19:46', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(12, '2010-02-07 15:06:44', '2010-02-07 15:06:44', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(13, '2010-02-07 15:06:48', '2010-02-07 15:06:48', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(23, '2010-02-07 15:41:32', '2010-02-07 15:41:32', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00'),
(26, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 151.56, 'test', 'cash', 123, 'test', '2007-02-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL auto_increment,
  `moduleId` int(11) NOT NULL,
  `controllerId` int(11) NOT NULL,
  `actionId` int(11) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `controllerId` (`controllerId`),
  KEY `actionId` (`actionId`),
  KEY `moduleId` (`moduleId`),
  KEY `alias` (`alias`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This entity represents the permissions that we have' AUTO_INCREMENT=110 ;

--
-- Dumping data for table `permission`
--

REPLACE INTO `permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 1, 1, 'Logs Error', '2010-02-06 19:07:24', '2010-02-20 15:51:15'),
(2, 1, 2, 2, 'Logs Index Index', '2010-02-06 19:07:24', NULL),
(3, 1, 2, 3, 'Logs Index Db', '2010-02-06 19:07:24', NULL),
(4, 1, 2, 4, 'Logs Index Text', '2010-02-06 19:07:24', NULL),
(5, 1, 2, 5, 'Logs Index Read', '2010-02-06 19:07:24', NULL),
(6, 2, 1, 1, 'City Error Error', '2010-02-06 19:07:24', NULL),
(7, 2, 3, 2, 'City Update Index', '2010-02-06 19:07:24', NULL),
(8, 2, 3, 6, 'City Update Getregions', '2010-02-06 19:07:24', NULL),
(9, 2, 4, 2, 'City Delete Index', '2010-02-06 19:07:24', NULL),
(10, 2, 4, 7, 'City Delete Delete', '2010-02-06 19:07:24', NULL),
(11, 2, 5, 2, 'City View Index', '2010-02-06 19:07:24', NULL),
(12, 2, 2, 2, 'City Index Index', '2010-02-06 19:07:24', NULL),
(13, 2, 6, 2, 'City Create Index', '2010-02-06 19:07:24', NULL),
(14, 2, 6, 6, 'City Create Getregions', '2010-02-06 19:07:24', NULL),
(15, 3, 1, 1, 'Default Error Error', '2010-02-06 19:07:24', NULL),
(16, 3, 1, 8, 'Default Error Noaccess', '2010-02-06 19:07:24', NULL),
(17, 3, 2, 2, 'Default Index Index', '2010-02-06 19:07:24', NULL),
(18, 3, 2, 9, 'Default Index Search', '2010-02-06 19:07:24', NULL),
(19, 4, 3, 2, 'Messages Update Index', '2010-02-06 19:07:24', NULL),
(20, 4, 4, 10, 'Messages Delete Help', '2010-02-06 19:07:24', NULL),
(21, 4, 4, 2, 'Messages Delete Index', '2010-02-06 19:07:24', NULL),
(22, 4, 5, 2, 'Messages View Index', '2010-02-06 19:07:24', NULL),
(23, 4, 2, 2, 'Messages Index Index', '2010-02-06 19:07:24', NULL),
(24, 4, 6, 2, 'Messages Create Index', '2010-02-06 19:07:24', NULL),
(25, 5, 1, 1, 'User Error Error', '2010-02-06 19:07:24', NULL),
(26, 5, 1, 8, 'User Error Noaccess', '2010-02-06 19:07:24', NULL),
(27, 5, 3, 2, 'User Update Index', '2010-02-06 19:07:24', NULL),
(28, 5, 3, 11, 'User Update Changepwd', '2010-02-06 19:07:24', NULL),
(29, 5, 3, 12, 'User Update Changerole', '2010-02-06 19:07:24', NULL),
(30, 5, 5, 2, 'User View Index', '2010-02-06 19:07:24', NULL),
(31, 5, 2, 2, 'User Index Index', '2010-02-06 19:07:24', NULL),
(32, 5, 7, 2, 'User Login Index', '2010-02-06 19:07:24', NULL),
(33, 5, 7, 13, 'User Login Logout', '2010-02-06 19:07:24', NULL),
(34, 5, 7, 1, 'User Login Error', '2010-02-06 19:07:24', NULL),
(35, 5, 8, 2, 'User Join Index', '2010-02-06 19:07:24', NULL),
(36, 5, 6, 2, 'User Create Index', '2010-02-06 19:07:24', NULL),
(37, 6, 1, 1, 'Unit Error Error', '2010-02-06 19:07:24', NULL),
(38, 6, 3, 2, 'Unit Update Index', '2010-02-06 19:07:24', NULL),
(39, 6, 4, 2, 'Unit Delete Index', '2010-02-06 19:07:24', NULL),
(40, 6, 4, 7, 'Unit Delete Delete', '2010-02-06 19:07:24', NULL),
(41, 6, 9, 14, 'Unit Tenet Viewunittenet', '2010-02-06 19:07:24', NULL),
(42, 6, 9, 15, 'Unit Tenet Searchaddtenet', '2010-02-06 19:07:24', NULL),
(43, 6, 9, 16, 'Unit Tenet Addtounit', '2010-02-06 19:07:24', NULL),
(44, 6, 5, 2, 'Unit View Index', '2010-02-06 19:07:24', NULL),
(45, 6, 2, 2, 'Unit Index Index', '2010-02-06 19:07:24', NULL),
(46, 6, 2, 17, 'Unit Index Unitmodelindex', '2010-02-06 19:07:24', NULL),
(47, 6, 2, 18, 'Unit Index Amenityindex', '2010-02-06 19:07:24', NULL),
(48, 6, 6, 2, 'Unit Create Index', '2010-02-06 19:07:24', NULL),
(49, 6, 6, 19, 'Unit Create Createunitsingle', '2010-02-06 19:07:24', NULL),
(50, 6, 6, 20, 'Unit Create Createunitbulk', '2010-02-06 19:07:24', NULL),
(51, 6, 6, 21, 'Unit Create Createunitmodel', '2010-02-06 19:07:24', NULL),
(52, 6, 6, 22, 'Unit Create Createunitamenity', '2010-02-06 19:07:24', NULL),
(53, 7, 6, 23, 'Payment Create Enterpayment', '2010-02-06 19:07:24', NULL),
(54, 8, 1, 1, 'Role Error Error', '2010-02-06 19:07:24', NULL),
(55, 8, 1, 8, 'Role Error Noaccess', '2010-02-06 19:07:24', NULL),
(56, 8, 10, 2, 'Role Search Index', '2010-02-06 19:07:24', NULL),
(57, 8, 3, 2, 'Role Update Index', '2010-02-06 19:07:24', NULL),
(58, 8, 3, 24, 'Role Update Update', '2010-02-06 19:07:24', NULL),
(59, 8, 4, 2, 'Role Delete Index', '2010-02-06 19:07:24', NULL),
(60, 8, 4, 7, 'Role Delete Delete', '2010-02-06 19:07:24', NULL),
(61, 8, 5, 2, 'Role View Index', '2010-02-06 19:07:24', NULL),
(62, 8, 5, 25, 'Role View View', '2010-02-06 19:07:24', NULL),
(63, 8, 5, 26, 'Role View Roleaccess', '2010-02-06 19:07:24', NULL),
(64, 8, 2, 2, 'Role Index Index', '2010-02-06 19:07:24', NULL),
(65, 8, 6, 2, 'Role Create Index', '2010-02-06 19:07:24', NULL),
(66, 8, 6, 26, 'Role Create Roleaccess', '2010-02-06 19:07:24', NULL),
(67, 9, 1, 1, 'Permission Error Error', '2010-02-06 19:07:24', NULL),
(68, 9, 10, 2, 'Permission Search Index', '2010-02-06 19:07:24', NULL),
(69, 9, 3, 2, 'Permission Update Index', '2010-02-06 19:07:24', NULL),
(70, 9, 5, 2, 'Permission View Index', '2010-02-06 19:07:24', NULL),
(71, 9, 5, 25, 'Permission View View', '2010-02-06 19:07:24', NULL),
(72, 9, 2, 2, 'Permission Index Index', '2010-02-06 19:07:24', NULL),
(73, 10, 1, 1, 'Country Error Error', '2010-02-06 19:07:24', NULL),
(74, 10, 3, 2, 'Country Update Index', '2010-02-06 19:07:24', NULL),
(75, 10, 4, 2, 'Country Delete Index', '2010-02-06 19:07:24', NULL),
(76, 10, 4, 7, 'Country Delete Delete', '2010-02-06 19:07:24', NULL),
(77, 10, 5, 2, 'Country View Index', '2010-02-06 19:07:24', NULL),
(78, 10, 2, 2, 'Country Index Index', '2010-02-06 19:07:24', NULL),
(79, 10, 6, 2, 'Country Create Index', '2010-02-06 19:07:24', NULL),
(80, 11, 6, 2, 'Calendar Create Index', '2010-02-06 19:07:24', NULL),
(81, 11, 6, 27, 'Calendar Create Create', '2010-02-06 19:07:24', NULL),
(82, 12, 1, 1, 'Modules Error Error', '2010-02-06 19:07:24', NULL),
(83, 12, 3, 2, 'Modules Update Index', '2010-02-06 19:07:24', NULL),
(84, 12, 3, 24, 'Modules Update Update', '2010-02-06 19:07:24', NULL),
(85, 12, 5, 2, 'Modules View Index', '2010-02-06 19:07:24', NULL),
(86, 12, 5, 28, 'Modules View Viewallmodules', '2010-02-06 19:07:24', NULL),
(87, 12, 2, 2, 'Modules Index Index', '2010-02-06 19:07:24', NULL),
(88, 13, 1, 1, 'Apartment Error Error', '2010-02-06 19:07:24', NULL),
(89, 13, 3, 2, 'Apartment Update Index', '2010-02-06 19:07:24', NULL),
(90, 13, 3, 6, 'Apartment Update Getregions', '2010-02-06 19:07:24', NULL),
(91, 13, 4, 2, 'Apartment Delete Index', '2010-02-06 19:07:24', NULL),
(92, 13, 4, 7, 'Apartment Delete Delete', '2010-02-06 19:07:24', NULL),
(93, 13, 5, 2, 'Apartment View Index', '2010-02-06 19:07:24', NULL),
(94, 13, 2, 2, 'Apartment Index Index', '2010-02-06 19:07:24', NULL),
(95, 13, 6, 2, 'Apartment Create Index', '2010-02-06 19:07:24', NULL),
(96, 14, 1, 1, 'Province Error Error', '2010-02-06 19:07:24', NULL),
(97, 14, 3, 2, 'Province Update Index', '2010-02-06 19:07:24', NULL),
(98, 14, 4, 2, 'Province Delete Index', '2010-02-06 19:07:24', NULL),
(99, 14, 4, 7, 'Province Delete Delete', '2010-02-06 19:07:24', NULL),
(100, 14, 5, 2, 'Province View Index', '2010-02-06 19:07:24', NULL),
(101, 14, 2, 2, 'Province Index Index', '2010-02-06 19:07:24', NULL),
(102, 14, 6, 2, 'Province Create Index', '2010-02-06 19:07:24', NULL),
(103, 15, 5, 29, 'Financial View Viewallaccounts', '2010-02-06 19:07:24', NULL),
(104, 15, 5, 30, 'Financial View Viewaccount', '2010-02-06 19:07:24', NULL),
(105, 15, 5, 31, 'Financial View Viewallaccountlinks', '2010-02-06 19:07:24', NULL),
(106, 15, 2, 2, 'Financial Index Index', '2010-02-06 19:07:24', NULL),
(107, 15, 6, 32, 'Financial Create Createaccount', '2010-02-06 19:07:24', NULL),
(108, 15, 6, 33, 'Financial Create Createaccountlink', '2010-02-06 19:07:24', NULL),
(109, 15, 6, 23, 'Financial Create Enterpayment', '2010-02-06 19:07:24', NULL);

-- --------------------------------------------------------

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

REPLACE INTO `province` (`id`, `name`, `countryId`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Provincia De Buenos ', 1, '2009-09-22 00:00:00', '0000-00-00 00:00:00'),
(2, 'blahst', 4, '2009-11-05 22:38:58', '2009-11-05 22:55:33');

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

REPLACE INTO `role` (`id`, `name`, `protected`, `dateCreated`, `dateUpdated`) VALUES
(1, 'admin', 1, '2010-02-06 18:20:09', '2010-02-06 18:20:13'),
(2, 'member', 1, '2010-02-06 18:20:27', '2010-02-06 00:00:00'),
(3, 'viewer', 1, '2010-02-06 18:20:37', '2010-02-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rolePermission`
--

DROP TABLE IF EXISTS `rolePermission`;
CREATE TABLE IF NOT EXISTS `rolePermission` (
  `id` int(11) NOT NULL auto_increment,
  `roleId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tuple` (`roleId`,`permissionId`),
  KEY `roleId` (`roleId`),
  KEY `permissionId` (`permissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relation between roles and permissions' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rolePermission`
--


-- --------------------------------------------------------

--
-- Table structure for table `tenet`
--

DROP TABLE IF EXISTS `tenet`;
CREATE TABLE IF NOT EXISTS `tenet` (
  `id` int(11) NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `leaseId` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`,`leaseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tenet`
--


-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `comment` varchar(500) default NULL,
  `action` varchar(200) default NULL,
  PRIMARY KEY  (`id`),
  KEY `userId` (`userId`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `transaction`
--

REPLACE INTO `transaction` (`id`, `dateCreated`, `dateUpdated`, `userId`, `comment`, `action`) VALUES
(1, '2010-02-04 18:39:44', '2010-02-04 18:39:44', 1, NULL, NULL),
(2, '2010-02-04 18:42:04', '2010-02-04 18:42:04', 1, NULL, NULL),
(3, '2010-02-04 19:16:10', '2010-02-04 19:16:10', 1, NULL, NULL),
(4, '2010-02-04 19:19:46', '2010-02-04 19:19:46', 1, NULL, NULL),
(7, '2010-02-07 15:06:44', '2010-02-07 15:06:44', 1, NULL, NULL),
(8, '2010-02-07 15:06:48', '2010-02-07 15:06:48', 1, NULL, NULL),
(18, '2010-02-07 15:41:32', '2010-02-07 15:41:32', 1, NULL, NULL),
(21, '2010-02-07 15:44:46', '2010-02-07 15:44:46', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `number` varchar(50) NOT NULL,
  `apartmentId` int(11) unsigned NOT NULL,
  `unitModelId` int(11) unsigned NOT NULL,
  `size` int(11) unsigned NOT NULL COMMENT 'In the us this is sq ft.  We''ll need to translate this field according to local measurements',
  `numBeds` tinyint(3) unsigned NOT NULL,
  `numBaths` decimal(2,1) unsigned NOT NULL,
  `numFloors` tinyint(3) unsigned NOT NULL COMMENT '1 story, 2 story, etc',
  `yearBuilt` year(4) NOT NULL,
  `yearRenovated` year(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `number` (`number`,`apartmentId`),
  KEY `unitModelId` (`unitModelId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `unit`
--

REPLACE INTO `unit` (`id`, `dateCreated`, `dateUpdated`, `number`, `apartmentId`, `unitModelId`, `size`, `numBeds`, `numBaths`, `numFloors`, `yearBuilt`, `yearRenovated`) VALUES
(13, '2010-01-26 01:05:44', '2010-01-26 01:05:44', '25', 2, 2, 1000, 1, 1.0, 1, 1990, NULL),
(14, '2010-01-26 01:05:44', '2010-01-26 01:05:44', '26', 2, 2, 1000, 1, 1.0, 1, 1990, NULL),
(15, '2010-01-26 01:05:44', '2010-01-26 01:05:44', '27', 2, 2, 1000, 1, 1.0, 1, 1990, NULL),
(16, '2010-01-26 01:05:44', '2010-01-26 01:05:44', '28', 2, 2, 1000, 1, 1.0, 1, 1990, NULL),
(17, '2010-01-26 01:05:44', '2010-01-26 01:05:44', '29', 2, 2, 1000, 1, 1.0, 1, 1990, NULL),
(18, '2010-01-26 01:07:53', '2010-01-26 01:07:53', '30', 2, 1, 1, 1, 1.0, 1, 0000, 0000),
(19, '2010-01-26 01:07:53', '2010-01-26 01:07:53', '31', 2, 1, 1, 1, 1.0, 1, 0000, 0000),
(20, '2010-01-26 01:07:53', '2010-01-26 01:07:53', '32', 2, 1, 1, 1, 1.0, 1, 0000, 0000),
(21, '2010-01-26 01:07:53', '2010-01-26 01:07:53', '33', 2, 1, 1, 1, 1.0, 1, 0000, 0000),
(22, '2010-01-26 01:07:53', '2010-01-26 01:07:53', '34', 2, 1, 1, 1, 1.0, 1, 0000, 0000);

-- --------------------------------------------------------

--
-- Table structure for table `unitAmenity`
--

DROP TABLE IF EXISTS `unitAmenity`;
CREATE TABLE IF NOT EXISTS `unitAmenity` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(11) unsigned NOT NULL,
  `amenityId` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `unitId` (`unitId`,`amenityId`),
  KEY `amenityId` (`amenityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `unitAmenity`
--

REPLACE INTO `unitAmenity` (`id`, `dateCreated`, `dateUpdated`, `unitId`, `amenityId`) VALUES
(3, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 13, 2),
(4, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 13, 4),
(5, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 14, 2),
(6, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 14, 4),
(7, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 15, 2),
(8, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 15, 4),
(9, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 16, 2),
(10, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 16, 4),
(11, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 17, 2),
(12, '2010-01-26 01:05:44', '2010-01-26 01:05:44', 17, 4),
(13, '2010-01-26 01:07:53', '2010-01-26 01:07:53', 18, 4),
(14, '2010-01-26 01:07:53', '2010-01-26 01:07:53', 19, 4),
(15, '2010-01-26 01:07:53', '2010-01-26 01:07:53', 20, 4),
(16, '2010-01-26 01:07:53', '2010-01-26 01:07:53', 21, 4),
(17, '2010-01-26 01:07:53', '2010-01-26 01:07:53', 22, 4);

-- --------------------------------------------------------

--
-- Table structure for table `unitLease`
--

DROP TABLE IF EXISTS `unitLease`;
CREATE TABLE IF NOT EXISTS `unitLease` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `modelRentScheduleId` int(10) unsigned NOT NULL,
  `hasOverride` tinyint(1) unsigned NOT NULL default '0',
  `rentAmountOverride` decimal(10,2) default NULL,
  `numMonthsOverride` int(10) unsigned default NULL,
  `effectiveDateOverride` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `unitId` (`unitId`,`userId`,`modelRentScheduleId`,`hasOverride`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `unitLease`
--


-- --------------------------------------------------------

--
-- Table structure for table `unitModel`
--

DROP TABLE IF EXISTS `unitModel`;
CREATE TABLE IF NOT EXISTS `unitModel` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `unitModel`
--

REPLACE INTO `unitModel` (`id`, `name`, `dateCreated`, `dateUpdated`) VALUES
(1, 'test', '2010-01-17 12:08:08', '2010-01-17 12:08:08'),
(2, 'test2', '2010-01-17 12:09:49', '2010-01-17 12:09:49'),
(3, 'test3', '2010-01-17 12:10:23', '2010-01-17 12:10:23');

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
  `dateUpdated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The user table.' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

REPLACE INTO `user` (`id`, `firstName`, `lastName`, `username`, `password`, `emailAddress`, `dob`, `phone`, `mobile`, `fax`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Jorge', 'Vazquez', 'jvazquez', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'jorgeomar.vazquez@gmail.com', '1985-04-22 14:00:00', NULL, NULL, NULL, '2009-09-27 16:58:26', '2009-09-27 16:58:30'),
(2, 'Chango', 'Lolo', 'clololo', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'lolo@gmail.com', '1985-04-22 00:00:00', NULL, NULL, NULL, '2009-09-28 21:03:18', '2009-09-28 21:03:18'),
(3, 'Cholo', 'Chango', 'cchango', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'chango@gmail.com', '1985-04-22 00:00:00', NULL, NULL, NULL, '2009-09-28 21:03:52', '2009-09-28 21:03:52'),
(5, 'John', 'Lopez', 'jlopez', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', 'jorgeomar.vazquez@gmail.com', '1985-09-22 00:00:00', NULL, NULL, NULL, '0000-00-00 00:00:00', '2009-12-17 19:10:05');

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
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`userId`),
  KEY `role_id` (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This interrelation tables shows the roles that a user has' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userRole`
--

REPLACE INTO `userRole` (`id`, `userId`, `roleId`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 1, '2009-09-27 16:58:40', '2009-09-27 16:58:43'),
(2, 2, 3, '2009-09-28 21:03:18', '2009-09-28 21:03:18'),
(3, 3, 3, '2009-09-28 21:03:52', '2009-09-28 21:03:52'),
(4, 5, 2, '2009-10-03 18:02:59', '2009-12-19 15:41:39');

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


--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventsChilds`
--
ALTER TABLE `eventsChilds`
  ADD CONSTRAINT `eventsChilds_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `apmgr_tests`.`events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventsNotification`
--
ALTER TABLE `eventsNotification`
  ADD CONSTRAINT `eventsNotification_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `apmgr_tests`.`user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventsNotification_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `apmgr_tests`.`events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

