-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2010 at 09:36 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(90) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '1',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(2)),
  KEY `icon` (`icon`(6))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `actions`
--

REPLACE INTO `actions` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-04-20 15:03:36', NULL),
(2, 'Dailyview', NULL, 1, '2010-04-20 15:03:36', NULL),
(3, 'Weekview', NULL, 1, '2010-04-20 15:03:36', NULL),
(4, 'Viewevent', NULL, 1, '2010-04-20 15:03:36', NULL),
(5, 'Search', NULL, 1, '2010-04-20 15:03:36', NULL),
(6, 'Error', NULL, 1, '2010-04-20 15:03:36', NULL),
(7, 'Noaccess', NULL, 1, '2010-04-20 15:03:36', NULL),
(8, 'Createaccount', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:36', NULL),
(9, 'Createaccountlink', NULL, 1, '2010-04-20 15:03:36', NULL),
(10, 'Searchunit', '/images/24/search_48.gif', 1, '2010-04-20 15:03:36', '2010-05-28 16:50:33'),
(11, 'Selectbill', NULL, 1, '2010-04-20 15:03:36', NULL),
(12, 'Createbill', NULL, 1, '2010-04-20 15:03:36', NULL),
(13, 'Updateaccount', NULL, 1, '2010-04-20 15:03:36', NULL),
(14, 'Updateaccountlink', NULL, 1, '2010-04-20 15:03:36', NULL),
(15, 'Viewallaccounts', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(16, 'Viewaccount', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(17, 'Viewallaccountlinks', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(18, 'Db', NULL, 1, '2010-04-20 15:03:36', NULL),
(19, 'Text', NULL, 1, '2010-04-20 15:03:36', NULL),
(20, 'Read', NULL, 1, '2010-04-20 15:03:36', NULL),
(21, 'Createmaintenancerequest', NULL, 1, '2010-04-20 15:03:36', NULL),
(22, 'Viewallmaintenancerequests', NULL, 1, '2010-04-20 15:03:36', NULL),
(23, 'Viewmymaintenancerequests', NULL, 1, '2010-04-20 15:03:36', NULL),
(24, 'Viewmaintenancerequest', NULL, 1, '2010-04-20 15:03:36', NULL),
(25, 'Help', NULL, 1, '2010-04-20 15:03:36', NULL),
(26, 'Update', '/images/dashboard/onebit_20.gif', 1, '2010-04-20 15:03:36', NULL),
(27, 'Viewallmodules', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(28, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(29, 'Roleaccess', NULL, 1, '2010-04-20 15:03:36', NULL),
(32, 'Delete', '/images/dashboard/onebit_32.gif', 1, '2010-04-20 15:03:37', NULL),
(34, 'Createamenity', NULL, 1, '2010-04-20 15:03:37', NULL),
(35, 'Createapartment', NULL, 1, '2010-04-20 15:03:37', NULL),
(36, 'Createunitsingle', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:37', NULL),
(37, 'Createunitbulk', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:37', NULL),
(38, 'Createunitmodel', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:37', NULL),
(39, 'Createmodelrentschedule', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:37', NULL),
(40, 'Unitmodelindex', '/images/dashboard/onebit_01.gif', 1, '2010-04-20 15:03:37', NULL),
(41, 'Amenityindex', '/images/dashboard/onebit_01.gif', 1, '2010-04-20 15:03:37', NULL),
(42, 'Addusertolist', NULL, 1, '2010-04-20 15:03:37', NULL),
(43, 'Removeuserfromlist', NULL, 1, '2010-04-20 15:03:37', NULL),
(44, 'Confirmation', NULL, 1, '2010-04-20 15:03:37', NULL),
(45, 'Enterdiscounts', NULL, 1, '2010-04-20 15:03:37', NULL),
(46, 'Entermoveindate', NULL, 1, '2010-04-20 15:03:37', NULL),
(47, 'Searchaddtenet', NULL, 1, '2010-04-20 15:03:37', NULL),
(48, 'Selectaccountlink', NULL, 1, '2010-04-20 15:03:37', NULL),
(49, 'Selectrentschedule', NULL, 1, '2010-04-20 15:03:37', NULL),
(50, 'Startleasewizard', NULL, 1, '2010-04-20 15:03:37', NULL),
(51, 'Deleteapartment', NULL, 1, '2010-04-20 15:03:37', NULL),
(52, 'Viewunittenet', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:37', NULL),
(53, 'Addtounit', NULL, 1, '2010-04-20 15:03:37', NULL),
(54, 'Cancellease', NULL, 1, '2010-04-20 15:03:37', NULL),
(55, 'Updateamenity', NULL, 1, '2010-04-20 15:03:37', NULL),
(56, 'Updateapartment', NULL, 1, '2010-04-20 15:03:37', NULL),
(57, 'Updateunit', NULL, 1, '2010-04-20 15:03:37', NULL),
(58, 'Updateunitmodel', NULL, 1, '2010-04-20 15:03:37', NULL),
(59, 'Getregions', NULL, 1, '2010-04-20 15:03:37', NULL),
(60, 'Viewunit', NULL, 1, '2010-04-20 15:03:37', NULL),
(61, 'Viewallamenities', NULL, 1, '2010-04-20 15:03:37', NULL),
(62, 'Viewallapartments', NULL, 1, '2010-04-20 15:03:37', NULL),
(63, 'Viewallunitmodels', NULL, 1, '2010-04-20 15:03:37', NULL),
(64, 'Viewallunits', NULL, 1, '2010-04-20 15:03:37', NULL),
(65, 'Viewapartment', NULL, 1, '2010-04-20 15:03:37', NULL),
(66, 'Viewallmodelrentschedule', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:37', NULL),
(67, 'Viewlease', NULL, 1, '2010-04-20 15:03:37', NULL),
(68, 'Viewleaselist', NULL, 1, '2010-04-20 15:03:37', NULL),
(69, 'Viewmodelrentschedule', NULL, 1, '2010-04-20 15:03:37', NULL),
(70, 'Changepwd', NULL, 1, '2010-04-20 15:03:37', NULL),
(71, 'Changerole', NULL, 1, '2010-04-20 15:03:37', NULL),
(72, 'Logout', NULL, 1, '2010-04-20 15:03:37', NULL),
(73, 'Deleteevent', NULL, 1, '2010-04-25 15:03:18', NULL),
(74, 'Deleteguest', NULL, 1, '2010-04-25 15:03:18', NULL),
(75, 'Deleteeventtime', NULL, 1, '2010-04-25 15:03:18', NULL),
(76, 'Updateevent', NULL, 1, '2010-04-25 15:03:18', NULL),
(77, 'Createdeposit', NULL, 1, '2010-04-25 15:03:18', NULL),
(78, 'Createfee', NULL, 1, '2010-04-25 15:03:18', NULL),
(79, 'Updatedeposit', NULL, 1, '2010-04-25 15:03:18', NULL),
(80, 'Updatefee', NULL, 1, '2010-04-25 15:03:18', NULL),
(81, 'Viewaccounttransactions', NULL, 1, '2010-04-25 15:03:18', NULL),
(82, 'Viewalldeposits', NULL, 1, '2010-04-25 15:03:18', NULL),
(83, 'Viewallfees', NULL, 1, '2010-04-25 15:03:18', NULL),
(84, 'Selectfeedeposit', NULL, 1, '2010-04-25 15:03:18', NULL),
(85, 'Deleteallguests', NULL, 1, '2010-05-14 21:09:46', NULL),
(86, 'Createaccounttransaction', NULL, 1, '2010-05-14 21:09:46', NULL),
(87, 'Updatedepositaccountlink', NULL, 1, '2010-05-14 21:09:46', NULL),
(88, 'Updatefeeaccountlink', NULL, 1, '2010-05-14 21:09:46', NULL),
(89, 'Viewbill', NULL, 1, '2010-05-14 21:09:47', NULL),
(90, 'Viewpaymentdetail', NULL, 1, '2010-05-14 21:09:47', NULL),
(91, 'Viewtransaction', NULL, 1, '2010-05-14 21:09:47', NULL),
(92, 'Createleasefee', NULL, 1, '2010-05-14 21:09:47', NULL),
(93, 'Createleasedeposit', NULL, 1, '2010-05-14 21:09:47', NULL),
(94, 'Unitsforrent', NULL, 1, '2010-05-14 21:09:47', NULL),
(95, 'Viewunitgraphics', NULL, 1, '2010-05-14 21:09:47', NULL),
(96, 'Addpicture', '/images/dashboard/camera_add_48.gif', 1, '2010-05-14 21:09:13', NULL),
(97, 'Deleteunitmetadata', NULL, 1, '2010-05-24 12:12:27', NULL),
(98, 'Waitlist', '/images/24/pencil_48.gif', 1, '2010-05-29 14:02:47', '2010-05-29 14:21:50'),
(99, 'Viewunitmodel', NULL, 1, '2010-05-29 14:02:47', NULL),
(100, 'Waitlistapply', NULL, 1, '2010-05-30 14:02:24', NULL),
(101, 'Applyuser', NULL, 1, '2010-05-31 22:10:21', NULL),
(102, 'Show', NULL, 1, '2010-06-05 20:08:31', NULL),
(103, 'Process', NULL, 1, '2010-06-06 12:12:03', NULL),
(104, 'Aboutyou', NULL, 1, '2010-06-12 19:07:40', NULL),
(105, 'Applicantcurrentaddress', NULL, 1, '2010-06-19 21:09:41', NULL),
(106, 'Applicantpreviousaddress', NULL, 1, '2010-06-19 21:09:41', NULL),
(107, 'Applicantspouse', NULL, 1, '2010-06-19 21:09:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applicantPersonalInfo`
--

DROP TABLE IF EXISTS `applicantPersonalInfo`;
CREATE TABLE IF NOT EXISTS `applicantPersonalInfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `streetAddress` varchar(255) NOT NULL,
  `driversLicense` char(9) DEFAULT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `govtLicense` int(11) DEFAULT NULL,
  `formerLastName` varchar(255) DEFAULT NULL,
  `ssn` int(11) NOT NULL,
  `dob` date NOT NULL,
  `height` double NOT NULL,
  `weight` double NOT NULL,
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
  KEY `userId` (`userId`),
  KEY `fullName` (`fullName`),
  KEY `streetAddress` (`streetAddress`),
  KEY `driversLicense` (`driversLicense`),
  KEY `govtLicense` (`govtLicense`),
  KEY `ssn` (`ssn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant personal info' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `applicantPersonalInfo`
--


-- --------------------------------------------------------

--
-- Table structure for table `applicantSpouse`
--

DROP TABLE IF EXISTS `applicantSpouse`;
CREATE TABLE IF NOT EXISTS `applicantSpouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `fullName` varchar(250) DEFAULT NULL,
  `ssn` int(11) DEFAULT NULL,
  `driversLicense` int(11) DEFAULT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,
  `govtLicense` int(11) DEFAULT NULL,
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
  `userId` int(11) DEFAULT NULL,
  `name` char(15) NOT NULL,
  `page` varchar(50) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `payload` text NOT NULL,
  `current` tinyint(4) NOT NULL DEFAULT '0',
  `action` varchar(50) NOT NULL,
  `next` char(15) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL COMMENT 'Not used',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `action` (`action`),
  KEY `next` (`next`),
  FULLTEXT KEY `payload` (`payload`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table that holds the applicant steps through our application' AUTO_INCREMENT=26 ;

--
-- Dumping data for table `applicantTransactions`
--

REPLACE INTO `applicantTransactions` (`id`, `userId`, `name`, `page`, `complete`, `payload`, `current`, `action`, `next`, `dateCreated`, `dateUpdated`) VALUES
(1, 0, '', '', 0, '', 0, '', '', '2010-06-12 21:11:20', '2010-06-12 21:11:20'),
(2, 0, '', '', 0, '', 0, '', '', '2010-06-12 21:12:08', '2010-06-12 21:12:08'),
(3, 0, '', '', 0, '', 0, '', '', '2010-06-12 21:16:11', '2010-06-12 21:16:11'),
(4, 0, '', '', 0, '', 0, '', '', '2010-06-12 21:20:34', '2010-06-12 21:20:34'),
(5, 0, '', '', 0, '', 0, '', '', '2010-06-12 22:08:52', '2010-06-12 22:08:52'),
(6, 0, '', '', 0, '', 0, '', '', '2010-06-12 22:11:55', '2010-06-12 22:11:55'),
(7, 0, '', '', 0, '', 0, '', '', '2010-06-13 11:37:18', '2010-06-13 11:37:18'),
(8, 0, '', '', 0, '', 0, '', '', '2010-06-13 11:40:06', '2010-06-13 11:40:06'),
(9, 0, '', '', 0, '', 0, '', '', '2010-06-13 13:33:35', '2010-06-13 13:33:35'),
(10, 0, '', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:16:56', '2010-06-17 23:16:56'),
(11, 0, '', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:19:09', '2010-06-17 23:19:09'),
(12, 0, '', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:20:24', '2010-06-17 23:20:24'),
(13, 0, '', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:24:14', '2010-06-17 23:24:14'),
(14, 0, '', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:25:13', '2010-06-17 23:25:13'),
(15, 0, '', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:26:29', '2010-06-17 23:26:29'),
(16, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:27:32', '2010-06-17 23:27:32'),
(17, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:27:43', '2010-06-17 23:27:43'),
(18, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:28:27', '2010-06-17 23:28:27'),
(19, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:30:19', '2010-06-17 23:30:19'),
(20, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:31:41', '2010-06-17 23:31:41'),
(21, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:32:47', '2010-06-17 23:32:47'),
(22, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:35:35', '2010-06-17 23:35:35'),
(23, 0, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"0";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-17 23:36:50', '2010-06-17 23:36:50'),
(24, 0, 'one', 'apply', 1, 's:1:"6";', 0, '', 'applicant/apply', '2010-06-17 23:37:45', '2010-06-17 23:37:45'),
(25, NULL, 'one', 'apply', 0, 'a:8:{s:6:"module";s:9:"applicant";s:10:"controller";s:5:"apply";s:6:"action";s:5:"index";s:5:"model";s:1:"2";s:4:"unit";s:1:"2";s:9:"apartment";s:1:"1";s:11:"haveaccount";s:1:"1";s:6:"submit";s:8:"Continue";}', 1, '', 'applicant/apply', '2010-06-19 14:10:40', '2010-06-19 14:10:40');

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
-- Table structure for table `controllers`
--

DROP TABLE IF EXISTS `controllers`;
CREATE TABLE IF NOT EXISTS `controllers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All the controllers that we have' AUTO_INCREMENT=16 ;

--
-- Dumping data for table `controllers`
--

REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Create', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:36', NULL),
(2, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-04-20 15:03:36', NULL),
(3, 'Delete', '/images/dashboard/onebit_32.gif', 0, '2010-04-20 15:03:36', '2010-05-01 13:45:06'),
(4, 'Update', '/images/dashboard/onebit_20.gif', 0, '2010-04-20 15:03:36', '2010-05-01 13:45:31'),
(5, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(6, 'Error', NULL, 0, '2010-04-20 15:03:36', NULL),
(7, 'Search', '/images/24/search_48.gif', 1, '2010-04-20 15:03:36', '2010-05-28 16:45:37'),
(8, 'Leasewizard', NULL, 0, '2010-04-20 15:03:37', NULL),
(9, 'Tenet', NULL, 0, '2010-04-20 15:03:37', NULL),
(10, 'Join', NULL, 0, '2010-04-20 15:03:37', NULL),
(11, 'Login', NULL, 0, '2010-04-20 15:03:37', NULL),
(12, 'Add', NULL, 0, '2010-05-14 21:09:47', NULL),
(13, 'Backend', NULL, 0, '2010-05-22 12:12:17', NULL),
(14, 'Apply', NULL, 0, '2010-05-22 12:12:17', NULL),
(15, 'Bulk', NULL, 0, '2010-06-05 20:08:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The content of the modules folder, ie all the modules' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `modules`
--

REPLACE INTO `modules` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'calendar', '/images/dashboard/calendar.png', 1, '2010-04-20 15:03:36', NULL),
(2, 'default', '/images/dashboard/ok.gif', 1, '2010-04-20 15:03:36', NULL),
(3, 'financial', '/images/dashboard/dollar.gif', 1, '2010-04-20 15:03:36', NULL),
(4, 'logs', NULL, 0, '2010-04-20 15:03:36', NULL),
(5, 'maintenance', '/images/dashboard/spanner_48.gif', 1, '2010-04-20 15:03:36', NULL),
(6, 'messages', '/images/dashboard/messages.gif', 1, '2010-04-20 15:03:36', NULL),
(7, 'modules', NULL, 0, '2010-04-20 15:03:36', NULL),
(8, 'permission', '/images/dashboard/onebit_04.gif', 1, '2010-04-20 15:03:36', NULL),
(9, 'role', '/images/dashboard/role.gif', 1, '2010-04-20 15:03:36', NULL),
(10, 'unit', '/images/dashboard/apartment.gif', 1, '2010-04-20 15:03:36', NULL),
(11, 'user', '/images/dashboard/user_48.gif', 1, '2010-04-20 15:03:36', NULL),
(12, 'applicant', NULL, 0, '2010-05-20 22:10:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleId` int(11) NOT NULL,
  `controllerId` int(11) NOT NULL,
  `actionId` int(11) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `moduleId` (`moduleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Dumping data for table `permission`
--

REPLACE INTO `permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`) VALUES
(1, 1, 1, 1, 'Calendar Create Index', '2010-04-20 15:03:36', NULL),
(2, 1, 2, 1, 'Calendar Index Index', '2010-04-20 15:03:36', NULL),
(3, 1, 5, 1, 'Calendar View Index', '2010-04-20 15:03:36', NULL),
(4, 1, 5, 2, 'Calendar View Dailyview', '2010-04-20 15:03:36', NULL),
(5, 1, 5, 3, 'Calendar View Weekview', '2010-04-20 15:03:36', NULL),
(6, 1, 5, 4, 'Calendar View Viewevent', '2010-04-20 15:03:36', NULL),
(7, 2, 2, 1, 'Default Index Index', '2010-04-20 15:03:36', NULL),
(8, 2, 2, 5, 'Default Index Search', '2010-04-20 15:03:36', NULL),
(9, 2, 6, 6, 'Default Error Error', '2010-04-20 15:03:36', NULL),
(10, 2, 6, 7, 'Default Error Noaccess', '2010-04-20 15:03:36', NULL),
(11, 3, 1, 8, 'Financial Create Createaccount', '2010-04-20 15:03:36', NULL),
(12, 3, 1, 9, 'Financial Create Createaccountlink', '2010-04-20 15:03:36', NULL),
(13, 3, 1, 10, 'Financial Create Searchunit', '2010-04-20 15:03:36', NULL),
(14, 3, 1, 11, 'Financial Create Selectbill', '2010-04-20 15:03:36', NULL),
(15, 3, 1, 12, 'Financial Create Createbill', '2010-04-20 15:03:36', NULL),
(16, 3, 2, 1, 'Financial Index Index', '2010-04-20 15:03:36', NULL),
(17, 3, 4, 13, 'Financial Update Updateaccount', '2010-04-20 15:03:36', NULL),
(18, 3, 4, 14, 'Financial Update Updateaccountlink', '2010-04-20 15:03:36', NULL),
(19, 3, 5, 15, 'Financial View Viewallaccounts', '2010-04-20 15:03:36', NULL),
(20, 3, 5, 16, 'Financial View Viewaccount', '2010-04-20 15:03:36', NULL),
(21, 3, 5, 17, 'Financial View View All Account Links', '2010-04-20 15:03:36', '2010-05-02 15:11:15'),
(22, 4, 2, 1, 'Logs Index Index', '2010-04-20 15:03:36', NULL),
(23, 4, 2, 18, 'Logs Index Db', '2010-04-20 15:03:36', NULL),
(24, 4, 2, 19, 'Logs Index Text', '2010-04-20 15:03:36', NULL),
(25, 4, 2, 20, 'Logs Index Read', '2010-04-20 15:03:36', NULL),
(26, 4, 6, 6, 'Logs Error Error', '2010-04-20 15:03:36', NULL),
(27, 5, 1, 21, 'Maintenance Create Createmaintenancerequest', '2010-04-20 15:03:36', NULL),
(28, 5, 5, 22, 'Maintenance View Viewallmaintenancerequests', '2010-04-20 15:03:36', NULL),
(29, 5, 5, 23, 'Maintenance View Viewmymaintenancerequests', '2010-04-20 15:03:36', NULL),
(30, 5, 5, 24, 'Maintenance View Viewmaintenancerequest', '2010-04-20 15:03:36', NULL),
(31, 6, 1, 1, 'Messages Create Index', '2010-04-20 15:03:36', NULL),
(32, 6, 2, 1, 'Messages Index Index', '2010-04-20 15:03:36', NULL),
(33, 6, 3, 25, 'Messages Delete Help', '2010-04-20 15:03:36', NULL),
(34, 6, 3, 1, 'Messages Delete Index', '2010-04-20 15:03:36', NULL),
(35, 6, 4, 1, 'Messages Update Index', '2010-04-20 15:03:36', NULL),
(36, 6, 5, 1, 'Messages View Index', '2010-04-20 15:03:36', NULL),
(37, 7, 2, 1, 'Modules Index Index', '2010-04-20 15:03:36', NULL),
(38, 7, 6, 6, 'Modules Error Error', '2010-04-20 15:03:36', NULL),
(39, 7, 4, 1, 'Modules Update Index', '2010-04-20 15:03:36', NULL),
(40, 7, 4, 26, 'Modules Update Update', '2010-04-20 15:03:36', NULL),
(41, 7, 5, 1, 'Modules View Index', '2010-04-20 15:03:36', NULL),
(42, 7, 5, 27, 'Modules View Viewallmodules', '2010-04-20 15:03:36', NULL),
(43, 8, 2, 1, 'Permission Index Index', '2010-04-20 15:03:36', NULL),
(44, 8, 6, 6, 'Permission Error Error', '2010-04-20 15:03:36', NULL),
(45, 8, 7, 1, 'Permission Search Index', '2010-04-20 15:03:36', NULL),
(46, 8, 4, 1, 'Permission Update Index', '2010-04-20 15:03:36', NULL),
(47, 8, 5, 1, 'Permission View Index', '2010-04-20 15:03:36', NULL),
(48, 8, 5, 28, 'Permission View View', '2010-04-20 15:03:36', NULL),
(49, 9, 1, 1, 'Role Create Index', '2010-04-20 15:03:36', NULL),
(50, 9, 1, 29, 'Role Create Roleaccess', '2010-04-20 15:03:36', NULL),
(53, 9, 2, 1, 'Role Index Index', '2010-04-20 15:03:37', NULL),
(54, 9, 6, 6, 'Role Error Error', '2010-04-20 15:03:37', NULL),
(55, 9, 6, 7, 'Role Error Noaccess', '2010-04-20 15:03:37', NULL),
(56, 9, 3, 1, 'Role Delete Index', '2010-04-20 15:03:37', NULL),
(57, 9, 3, 32, 'Role Delete Delete', '2010-04-20 15:03:37', NULL),
(59, 9, 7, 1, 'Role Search Index', '2010-04-20 15:03:37', NULL),
(60, 9, 4, 1, 'Role Update Index', '2010-04-20 15:03:37', NULL),
(61, 9, 4, 26, 'Role Update Update', '2010-04-20 15:03:37', NULL),
(62, 9, 5, 1, 'Role View Index', '2010-04-20 15:03:37', NULL),
(63, 9, 5, 28, 'Role View View', '2010-04-20 15:03:37', NULL),
(64, 9, 5, 29, 'Role View Roleaccess', '2010-04-20 15:03:37', NULL),
(65, 10, 1, 1, 'Unit Create Index', '2010-04-20 15:03:37', NULL),
(66, 10, 1, 34, 'Unit Create Createamenity', '2010-04-20 15:03:37', NULL),
(67, 10, 1, 35, 'Unit Create Createapartment', '2010-04-20 15:03:37', NULL),
(68, 10, 1, 36, 'Unit Create Createunitsingle', '2010-04-20 15:03:37', NULL),
(69, 10, 1, 37, 'Unit Create Createunitbulk', '2010-04-20 15:03:37', NULL),
(70, 10, 1, 38, 'Unit Create Createunitmodel', '2010-04-20 15:03:37', NULL),
(71, 10, 1, 39, 'Unit Create Createmodelrentschedule', '2010-04-20 15:03:37', NULL),
(72, 10, 2, 1, 'Unit Index Index', '2010-04-20 15:03:37', NULL),
(73, 10, 2, 40, 'Unit Index Unitmodelindex', '2010-04-20 15:03:37', NULL),
(74, 10, 2, 41, 'Unit Index Amenityindex', '2010-04-20 15:03:37', NULL),
(75, 10, 6, 6, 'Unit Error Error', '2010-04-20 15:03:37', NULL),
(76, 10, 8, 42, 'Unit Leasewizard Addusertolist', '2010-04-20 15:03:37', NULL),
(77, 10, 8, 43, 'Unit Leasewizard Removeuserfromlist', '2010-04-20 15:03:37', NULL),
(78, 10, 8, 44, 'Unit Leasewizard Confirmation', '2010-04-20 15:03:37', NULL),
(79, 10, 8, 45, 'Unit Leasewizard Enterdiscounts', '2010-04-20 15:03:37', NULL),
(80, 10, 8, 46, 'Unit Leasewizard Entermoveindate', '2010-04-20 15:03:37', NULL),
(81, 10, 8, 47, 'Unit Leasewizard Searchaddtenet', '2010-04-20 15:03:37', NULL),
(82, 10, 8, 48, 'Unit Leasewizard Selectaccountlink', '2010-04-20 15:03:37', NULL),
(83, 10, 8, 49, 'Unit Leasewizard Selectrentschedule', '2010-04-20 15:03:37', NULL),
(84, 10, 8, 50, 'Unit Leasewizard Startleasewizard', '2010-04-20 15:03:37', NULL),
(85, 10, 3, 1, 'Unit Delete Index', '2010-04-20 15:03:37', NULL),
(86, 10, 3, 32, 'Unit Delete Delete', '2010-04-20 15:03:37', NULL),
(87, 10, 3, 51, 'Unit Delete Deleteapartment', '2010-04-20 15:03:37', NULL),
(88, 10, 9, 52, 'Unit Tenet Viewunittenet', '2010-04-20 15:03:37', NULL),
(89, 10, 9, 47, 'Unit Tenet Searchaddtenet', '2010-04-20 15:03:37', NULL),
(90, 10, 9, 53, 'Unit Tenet Addtounit', '2010-04-20 15:03:37', NULL),
(91, 10, 4, 1, 'Unit Update Index', '2010-04-20 15:03:37', NULL),
(92, 10, 4, 54, 'Unit Update Cancellease', '2010-04-20 15:03:37', NULL),
(93, 10, 4, 55, 'Unit Update Updateamenity', '2010-04-20 15:03:37', NULL),
(94, 10, 4, 56, 'Unit Update Updateapartment', '2010-04-20 15:03:37', NULL),
(95, 10, 4, 57, 'Unit Update Updateunit', '2010-04-20 15:03:37', NULL),
(96, 10, 4, 58, 'Unit Update Updateunitmodel', '2010-04-20 15:03:37', NULL),
(97, 10, 4, 59, 'Unit Update Getregions', '2010-04-20 15:03:37', NULL),
(98, 10, 5, 60, 'Unit View Viewunit', '2010-04-20 15:03:37', NULL),
(99, 10, 5, 61, 'Unit View Viewallamenities', '2010-04-20 15:03:37', NULL),
(100, 10, 5, 62, 'Unit View Viewallapartments', '2010-04-20 15:03:37', NULL),
(101, 10, 5, 63, 'Unit View Viewallunitmodels', '2010-04-20 15:03:37', NULL),
(102, 10, 5, 64, 'Unit View Viewallunits', '2010-04-20 15:03:37', NULL),
(103, 10, 5, 65, 'Unit View Viewapartment', '2010-04-20 15:03:37', NULL),
(104, 10, 5, 66, 'Unit View Viewallmodelrentschedule', '2010-04-20 15:03:37', NULL),
(105, 10, 5, 67, 'Unit View Viewlease', '2010-04-20 15:03:37', NULL),
(106, 10, 5, 68, 'Unit View Viewleaselist', '2010-04-20 15:03:37', NULL),
(107, 10, 5, 69, 'Unit View Viewmodelrentschedule', '2010-04-20 15:03:37', NULL),
(108, 11, 10, 1, 'User Join Index', '2010-04-20 15:03:37', NULL),
(109, 11, 1, 1, 'User Create Index', '2010-04-20 15:03:37', NULL),
(110, 11, 2, 1, 'User Index Index', '2010-04-20 15:03:37', NULL),
(111, 11, 6, 6, 'User Error Error', '2010-04-20 15:03:37', NULL),
(112, 11, 6, 7, 'User Error Noaccess', '2010-04-20 15:03:37', NULL),
(113, 11, 4, 1, 'User Update Index', '2010-04-20 15:03:37', NULL),
(114, 11, 4, 70, 'User Update Changepwd', '2010-04-20 15:03:37', NULL),
(115, 11, 4, 71, 'User Update Changerole', '2010-04-20 15:03:37', NULL),
(116, 11, 5, 1, 'User View Index', '2010-04-20 15:03:37', NULL),
(117, 11, 11, 1, 'User Login Index', '2010-04-20 15:03:37', NULL),
(118, 11, 11, 72, 'User Login Logout', '2010-04-20 15:03:37', NULL),
(119, 11, 11, 6, 'User Login Error', '2010-04-20 15:03:37', NULL),
(120, 1, 3, 73, 'Calendar Delete Deleteevent', '2010-04-25 15:03:18', NULL),
(121, 1, 3, 74, 'Calendar Delete Deleteguest', '2010-04-25 15:03:18', NULL),
(122, 1, 3, 75, 'Calendar Delete Deleteeventtime', '2010-04-25 15:03:18', NULL),
(123, 1, 4, 76, 'Calendar Update Updateevent', '2010-04-25 15:03:18', NULL),
(124, 3, 1, 77, 'Financial Create Createdeposit', '2010-04-25 15:03:18', NULL),
(125, 3, 1, 78, 'Financial Create Createfee', '2010-04-25 15:03:18', NULL),
(126, 3, 4, 79, 'Financial Update Updatedeposit', '2010-04-25 15:03:18', NULL),
(127, 3, 4, 80, 'Financial Update Updatefee', '2010-04-25 15:03:18', NULL),
(128, 3, 5, 81, 'Financial View Viewaccounttransactions', '2010-04-25 15:03:18', NULL),
(129, 3, 5, 82, 'Financial View Viewalldeposits', '2010-04-25 15:03:18', NULL),
(130, 3, 5, 83, 'Financial View Viewallfees', '2010-04-25 15:03:18', NULL),
(131, 5, 2, 1, 'Maintenance Index Index', '2010-04-25 15:03:18', NULL),
(132, 10, 8, 84, 'Unit Leasewizard Selectfeedeposit', '2010-04-25 15:03:19', NULL),
(133, 1, 3, 85, 'Calendar Delete Deleteallguests', '2010-05-14 21:09:46', NULL),
(134, 3, 1, 86, 'Financial Create Createaccounttransaction', '2010-05-14 21:09:46', NULL),
(135, 3, 4, 87, 'Financial Update Updatedepositaccountlink', '2010-05-14 21:09:46', NULL),
(136, 3, 4, 88, 'Financial Update Updatefeeaccountlink', '2010-05-14 21:09:46', NULL),
(137, 3, 5, 89, 'Financial View Viewbill', '2010-05-14 21:09:47', NULL),
(138, 3, 5, 90, 'Financial View Viewpaymentdetail', '2010-05-14 21:09:47', NULL),
(139, 3, 5, 91, 'Financial View Viewtransaction', '2010-05-14 21:09:47', NULL),
(140, 10, 1, 92, 'Unit Create Createleasefee', '2010-05-14 21:09:47', NULL),
(141, 10, 1, 93, 'Unit Create Createleasedeposit', '2010-05-14 21:09:47', NULL),
(142, 10, 5, 94, 'Unit View Unitsforrent', '2010-05-14 21:09:47', NULL),
(143, 10, 5, 95, 'Unit View Viewunitgraphics', '2010-05-14 21:09:47', NULL),
(144, 10, 12, 1, 'Unit Add Index', '2010-05-14 21:09:47', NULL),
(145, 10, 12, 96, 'Unit Add Addpicture', '2010-05-14 21:09:13', NULL),
(146, 12, 5, 1, 'Applicant View Index', '2010-05-20 22:10:40', NULL),
(147, 12, 13, 1, 'Applicant Backend Index', '2010-05-22 12:12:17', NULL),
(148, 12, 14, 1, 'Applicant Apply Index', '2010-05-22 12:12:17', NULL),
(149, 10, 3, 97, 'Unit Delete Deleteunitmetadata', '2010-05-24 12:12:27', NULL),
(150, 10, 7, 1, 'Unit Search Index', '2010-05-24 12:12:27', NULL),
(151, 12, 14, 98, 'Applicant Apply Waitlist', '2010-05-29 14:02:47', NULL),
(152, 10, 5, 99, 'Unit View Viewunitmodel', '2010-05-29 14:02:47', NULL),
(153, 12, 14, 100, 'Applicant Apply Waitlistapply', '2010-05-30 14:02:24', NULL),
(154, 12, 14, 101, 'Applicant Apply Applyuser', '2010-05-31 22:10:21', NULL),
(155, 3, 15, 1, 'Financial Bulk Index', '2010-06-05 20:08:31', NULL),
(156, 10, 5, 102, 'Unit View Show', '2010-06-05 20:08:31', NULL),
(157, 3, 6, 6, 'Financial Error Error', '2010-06-06 12:12:03', NULL),
(158, 3, 6, 7, 'Financial Error Noaccess', '2010-06-06 12:12:03', NULL),
(159, 3, 15, 103, 'Financial Bulk Process', '2010-06-06 12:12:03', NULL),
(160, 12, 14, 104, 'Applicant Apply Aboutyou', '2010-06-12 19:07:40', NULL),
(161, 12, 14, 105, 'Applicant Apply Applicantcurrentaddress', '2010-06-19 21:09:41', NULL),
(162, 12, 14, 106, 'Applicant Apply Applicantpreviousaddress', '2010-06-19 21:09:41', NULL),
(163, 12, 14, 107, 'Applicant Apply Applicantspouse', '2010-06-19 21:09:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rolePermission`
--

DROP TABLE IF EXISTS `rolePermission`;
CREATE TABLE IF NOT EXISTS `rolePermission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuple` (`roleId`,`permissionId`),
  KEY `roleId` (`roleId`),
  KEY `permissionId` (`permissionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Relation between roles and permissions' AUTO_INCREMENT=207 ;

--
-- Dumping data for table `rolePermission`
--

REPLACE INTO `rolePermission` (`id`, `roleId`, `permissionId`, `dateCreated`, `dateUpdated`) VALUES
(3, 2, 2, '2010-04-20 16:07:49', NULL),
(4, 3, 2, '2010-04-20 16:07:52', NULL),
(5, 3, 4, '2010-04-20 16:07:56', NULL),
(6, 2, 4, '2010-04-20 16:07:58', NULL),
(7, 2, 3, '2010-04-20 16:07:59', NULL),
(8, 2, 6, '2010-04-20 16:08:06', NULL),
(9, 2, 5, '2010-04-20 16:08:09', NULL),
(10, 3, 5, '2010-04-20 16:08:11', NULL),
(11, 3, 6, '2010-04-20 16:08:13', NULL),
(12, 3, 3, '2010-04-20 16:08:16', NULL),
(14, 2, 119, '2010-04-20 16:08:37', NULL),
(17, 2, 114, '2010-04-20 16:08:45', NULL),
(18, 2, 113, '2010-04-20 16:08:49', NULL),
(19, 2, 116, '2010-04-20 16:08:54', NULL),
(21, 3, 114, '2010-04-20 16:08:59', NULL),
(23, 3, 119, '2010-04-20 16:09:03', NULL),
(24, 3, 113, '2010-04-20 16:09:07', NULL),
(25, 3, 116, '2010-04-20 16:09:10', NULL),
(28, 2, 10, '2010-04-20 16:12:11', NULL),
(29, 3, 10, '2010-04-20 16:12:16', NULL),
(30, 2, 7, '2010-04-20 16:12:18', NULL),
(31, 3, 7, '2010-04-20 16:12:21', NULL),
(33, 3, 112, '2010-04-20 16:12:37', NULL),
(34, 2, 112, '2010-04-20 16:12:40', NULL),
(35, 2, 111, '2010-04-20 16:12:42', NULL),
(36, 3, 111, '2010-04-20 16:12:45', NULL),
(38, 2, 120, '2010-04-25 15:04:53', NULL),
(39, 3, 120, '2010-04-25 15:04:56', NULL),
(40, 2, 122, '2010-04-25 15:04:58', NULL),
(41, 3, 122, '2010-04-25 15:05:00', NULL),
(42, 2, 121, '2010-04-25 15:05:03', NULL),
(43, 3, 121, '2010-04-25 15:05:04', NULL),
(45, 4, 102, '2010-05-03 22:44:21', NULL),
(47, 4, 72, '2010-05-03 22:45:51', NULL),
(48, 4, 103, '2010-05-03 22:46:31', NULL),
(51, 1, 91, '2010-05-02 14:22:24', NULL),
(55, 1, 145, '2010-05-14 21:49:57', NULL),
(56, 6, 145, '2010-05-14 21:49:57', NULL),
(60, 1, 143, '2010-05-16 15:53:32', NULL),
(61, 4, 143, '2010-05-16 15:53:32', NULL),
(62, 5, 143, '2010-05-16 15:53:32', NULL),
(63, 6, 143, '2010-05-16 15:53:32', NULL),
(71, 2, 117, '2010-05-22 01:00:44', NULL),
(72, 3, 117, '2010-05-22 01:00:44', NULL),
(73, 4, 117, '2010-05-22 01:00:44', NULL),
(74, 3, 108, '2010-05-22 11:46:45', NULL),
(75, 4, 108, '2010-05-22 11:46:45', NULL),
(76, 1, 148, '2010-05-22 12:41:13', NULL),
(77, 2, 148, '2010-05-22 12:41:13', NULL),
(78, 3, 148, '2010-05-22 12:41:13', NULL),
(79, 4, 148, '2010-05-22 12:41:13', NULL),
(80, 5, 148, '2010-05-22 12:41:13', NULL),
(81, 6, 148, '2010-05-22 12:41:13', NULL),
(82, 7, 148, '2010-05-22 12:41:13', NULL),
(83, 8, 148, '2010-05-22 12:41:13', NULL),
(84, 1, 150, '2010-05-24 12:59:01', NULL),
(85, 2, 150, '2010-05-24 12:59:01', NULL),
(86, 3, 150, '2010-05-24 12:59:01', NULL),
(87, 4, 150, '2010-05-24 12:59:01', NULL),
(88, 5, 150, '2010-05-24 12:59:01', NULL),
(89, 6, 150, '2010-05-24 12:59:01', NULL),
(90, 7, 150, '2010-05-24 12:59:01', NULL),
(91, 8, 150, '2010-05-24 12:59:01', NULL),
(92, 2, 98, '2010-05-28 17:48:42', NULL),
(93, 3, 98, '2010-05-28 17:48:42', NULL),
(94, 4, 98, '2010-05-28 17:48:42', NULL),
(95, 5, 98, '2010-05-28 17:48:42', NULL),
(96, 6, 98, '2010-05-28 17:48:42', NULL),
(97, 7, 98, '2010-05-28 17:48:42', NULL),
(98, 8, 98, '2010-05-28 17:48:42', NULL),
(99, 1, 142, '2010-05-28 17:49:22', NULL),
(100, 2, 142, '2010-05-28 17:49:22', NULL),
(101, 3, 142, '2010-05-28 17:49:22', NULL),
(102, 4, 142, '2010-05-28 17:49:22', NULL),
(103, 5, 142, '2010-05-28 17:49:22', NULL),
(104, 6, 142, '2010-05-28 17:49:22', NULL),
(105, 7, 142, '2010-05-28 17:49:22', NULL),
(106, 8, 142, '2010-05-28 17:49:22', NULL),
(107, 3, 100, '2010-05-28 17:49:49', NULL),
(108, 4, 100, '2010-05-28 17:49:49', NULL),
(109, 5, 100, '2010-05-28 17:49:49', NULL),
(110, 6, 100, '2010-05-28 17:49:49', NULL),
(111, 7, 100, '2010-05-28 17:49:49', NULL),
(112, 8, 100, '2010-05-28 17:49:49', NULL),
(113, 1, 1, '2010-05-29 01:54:51', NULL),
(114, 2, 1, '2010-05-29 01:54:51', NULL),
(115, 3, 1, '2010-05-29 01:54:51', NULL),
(116, 5, 1, '2010-05-29 01:54:51', NULL),
(117, 6, 1, '2010-05-29 01:54:51', NULL),
(118, 7, 1, '2010-05-29 01:54:51', NULL),
(119, 1, 9, '2010-05-29 01:57:12', NULL),
(120, 2, 9, '2010-05-29 01:57:12', NULL),
(121, 3, 9, '2010-05-29 01:57:12', NULL),
(122, 4, 9, '2010-05-29 01:57:12', NULL),
(123, 5, 9, '2010-05-29 01:57:12', NULL),
(124, 6, 9, '2010-05-29 01:57:12', NULL),
(125, 7, 9, '2010-05-29 01:57:12', NULL),
(126, 8, 9, '2010-05-29 01:57:12', NULL),
(127, 1, 75, '2010-05-29 02:04:03', NULL),
(128, 2, 75, '2010-05-29 02:04:03', NULL),
(129, 3, 75, '2010-05-29 02:04:03', NULL),
(130, 4, 75, '2010-05-29 02:04:03', NULL),
(131, 5, 75, '2010-05-29 02:04:03', NULL),
(132, 6, 75, '2010-05-29 02:04:03', NULL),
(133, 7, 75, '2010-05-29 02:04:03', NULL),
(134, 8, 75, '2010-05-29 02:04:03', NULL),
(135, 2, 151, '2010-05-29 14:15:17', NULL),
(136, 3, 151, '2010-05-29 14:15:17', NULL),
(137, 4, 151, '2010-05-29 14:15:17', NULL),
(138, 5, 151, '2010-05-29 14:15:17', NULL),
(139, 6, 151, '2010-05-29 14:15:17', NULL),
(140, 7, 151, '2010-05-29 14:15:17', NULL),
(141, 8, 151, '2010-05-29 14:15:17', NULL),
(142, 1, 153, '2010-05-30 14:48:45', NULL),
(143, 2, 153, '2010-05-30 14:48:45', NULL),
(144, 3, 153, '2010-05-30 14:48:45', NULL),
(145, 4, 153, '2010-05-30 14:48:45', NULL),
(146, 5, 153, '2010-05-30 14:48:45', NULL),
(147, 6, 153, '2010-05-30 14:48:45', NULL),
(148, 7, 153, '2010-05-30 14:48:45', NULL),
(149, 8, 153, '2010-05-30 14:48:45', NULL),
(150, 1, 118, '2010-05-30 20:17:19', NULL),
(151, 2, 118, '2010-05-30 20:17:19', NULL),
(152, 3, 118, '2010-05-30 20:17:19', NULL),
(153, 4, 118, '2010-05-30 20:17:19', NULL),
(154, 5, 118, '2010-05-30 20:17:19', NULL),
(155, 6, 118, '2010-05-30 20:17:19', NULL),
(156, 7, 118, '2010-05-30 20:17:19', NULL),
(157, 8, 118, '2010-05-30 20:17:19', NULL),
(158, 1, 154, '2010-05-31 22:02:47', NULL),
(159, 2, 154, '2010-05-31 22:02:47', NULL),
(160, 3, 154, '2010-05-31 22:02:47', NULL),
(161, 4, 154, '2010-05-31 22:02:47', NULL),
(162, 5, 154, '2010-05-31 22:02:47', NULL),
(163, 6, 154, '2010-05-31 22:02:47', NULL),
(164, 7, 154, '2010-05-31 22:02:47', NULL),
(165, 8, 154, '2010-05-31 22:02:47', NULL),
(166, 7, 155, '2010-06-05 20:41:18', NULL),
(167, 1, 158, '2010-06-06 12:46:14', NULL),
(168, 2, 158, '2010-06-06 12:46:14', NULL),
(169, 3, 158, '2010-06-06 12:46:14', NULL),
(170, 4, 158, '2010-06-06 12:46:14', NULL),
(171, 5, 158, '2010-06-06 12:46:14', NULL),
(172, 6, 158, '2010-06-06 12:46:14', NULL),
(173, 7, 158, '2010-06-06 12:46:14', NULL),
(174, 8, 158, '2010-06-06 12:46:14', NULL),
(175, 1, 157, '2010-06-06 12:46:25', NULL),
(176, 2, 157, '2010-06-06 12:46:25', NULL),
(177, 3, 157, '2010-06-06 12:46:25', NULL),
(178, 4, 157, '2010-06-06 12:46:25', NULL),
(179, 5, 157, '2010-06-06 12:46:25', NULL),
(180, 6, 157, '2010-06-06 12:46:25', NULL),
(181, 7, 157, '2010-06-06 12:46:25', NULL),
(182, 8, 157, '2010-06-06 12:46:25', NULL),
(183, 7, 159, '2010-06-06 16:14:23', NULL),
(184, 1, 160, '2010-06-12 19:58:59', NULL),
(185, 2, 160, '2010-06-12 19:58:59', NULL),
(186, 5, 160, '2010-06-12 19:58:59', NULL),
(187, 6, 160, '2010-06-12 19:58:59', NULL),
(188, 8, 160, '2010-06-12 19:58:59', NULL),
(189, 2, 110, '2010-06-17 23:18:13', NULL),
(190, 3, 110, '2010-06-17 23:18:13', NULL),
(191, 8, 110, '2010-06-17 23:18:13', NULL),
(192, 1, 161, '2010-06-19 21:27:30', NULL),
(193, 2, 161, '2010-06-19 21:27:30', NULL),
(194, 5, 161, '2010-06-19 21:27:30', NULL),
(195, 6, 161, '2010-06-19 21:27:30', NULL),
(196, 8, 161, '2010-06-19 21:27:30', NULL),
(197, 1, 162, '2010-06-19 21:27:47', NULL),
(198, 2, 162, '2010-06-19 21:27:47', NULL),
(199, 5, 162, '2010-06-19 21:27:47', NULL),
(200, 6, 162, '2010-06-19 21:27:47', NULL),
(201, 8, 162, '2010-06-19 21:27:47', NULL),
(202, 1, 163, '2010-06-19 21:28:02', NULL),
(203, 2, 163, '2010-06-19 21:28:02', NULL),
(204, 5, 163, '2010-06-19 21:28:02', NULL),
(205, 6, 163, '2010-06-19 21:28:02', NULL),
(206, 8, 163, '2010-06-19 21:28:02', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`moduleId`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rolePermission`
--
ALTER TABLE `rolePermission`
  ADD CONSTRAINT `rolePermission_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rolePermission_ibfk_2` FOREIGN KEY (`permissionId`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
