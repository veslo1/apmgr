-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2010 at 03:06 PM
-- Server version: 5.1.45
-- PHP Version: 5.3.2
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

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
(10, 'Searchunit', NULL, 1, '2010-04-20 15:03:36', NULL),
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
(84, 'Selectfeedeposit', NULL, 1, '2010-04-25 15:03:18', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All the controllers that we have' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `controllers`
--

REPLACE INTO `controllers` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Create', '/images/dashboard/onebit_48.gif', 1, '2010-04-20 15:03:36', NULL),
(2, 'Index', '/images/dashboard/onebit_01.gif', 1, '2010-04-20 15:03:36', NULL),
(3, 'Delete', '/images/dashboard/onebit_32.gif', 1, '2010-04-20 15:03:36', NULL),
(4, 'Update', '/images/dashboard/onebit_20.gif', 1, '2010-04-20 15:03:36', NULL),
(5, 'View', '/images/dashboard/onebit_02.gif', 1, '2010-04-20 15:03:36', NULL),
(6, 'Error', NULL, 0, '2010-04-20 15:03:36', NULL),
(7, 'Search', NULL, 0, '2010-04-20 15:03:36', NULL),
(8, 'Leasewizard', NULL, 0, '2010-04-20 15:03:37', NULL),
(9, 'Tenet', NULL, 0, '2010-04-20 15:03:37', NULL),
(10, 'Join', NULL, 0, '2010-04-20 15:03:37', NULL),
(11, 'Login', NULL, 0, '2010-04-20 15:03:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `identifier` char(15) NOT NULL,
  `category` enum('error','warning','success') NOT NULL,
  `language` char(5) NOT NULL DEFAULT 'en_US' COMMENT 'The language this token was created.',
  `locked` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Lock this field to prevent deletion',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

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
(31, 'An error happened while saving the alias.', 'pmSaveFail', 'error', 'en_US', 1, '2010-02-20 15:56:16', NULL),
(32, 'The Dates are missing', 'datesMissing', 'error', 'en_US', 1, '2010-03-20 11:38:39', NULL),
(33, 'The event was saved', 'eventSaved', 'success', 'en_US', 1, '2010-03-20 15:35:20', NULL),
(34, 'The event could not be saved.', 'eventSaveFail', 'warning', 'en_US', 1, '2010-03-20 15:37:21', NULL),
(35, 'An exception happened !', 'exceptionCaught', 'warning', 'en_US', 1, '2010-03-20 15:39:48', NULL),
(36, 'This record does not belongs to you', 'notYourRecord', 'error', 'en_US', 1, '2010-04-14 23:41:01', NULL),
(37, 'You need to sign in order to perform this operation.', 'noLogin', 'error', 'en_US', 1, '2010-04-13 17:10:02', NULL),
(38, 'The specified event is no longer active', 'etMissing', 'error', 'en_US', 1, '2010-04-24 22:15:32', NULL),
(40, 'The specified event doesn''t exists', 'evdnexist', 'error', 'en_US', 1, '2010-04-24 22:26:58', NULL),
(41, 'The event time record  was deleted', 'eventDeleted', 'success', 'en_US', 0, '2010-04-24 22:27:37', '2010-04-24 22:29:06'),
(42, 'The event time record couldn''t be deleted', 'etDelFail', 'error', 'en_US', 1, '2010-04-24 22:28:37', '2010-04-24 22:29:42'),
(43, 'The operation cannot continue. There is only one occurence left', 'etDeleteBlock', 'warning', 'en_US', 1, '2010-04-24 22:51:43', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The content of the modules folder, ie all the modules' AUTO_INCREMENT=12 ;

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
(11, 'user', '/images/dashboard/user_48.gif', 1, '2010-04-20 15:03:36', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

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
(21, 3, 5, 17, 'Financial View Viewallaccountlinks', '2010-04-20 15:03:36', NULL),
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
(132, 10, 8, 84, 'Unit Leasewizard Selectfeedeposit', '2010-04-25 15:03:19', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Relation between roles and permissions' AUTO_INCREMENT=44 ;

--
-- Dumping data for table `rolePermission`
--

REPLACE INTO `rolePermission` (`id`, `roleId`, `permissionId`, `dateCreated`, `dateUpdated`) VALUES
(1, 2, 1, '2010-04-20 16:07:44', NULL),
(2, 3, 1, '2010-04-20 16:07:47', NULL),
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
(13, 2, 110, '2010-04-20 16:08:35', NULL),
(14, 2, 119, '2010-04-20 16:08:37', NULL),
(15, 2, 117, '2010-04-20 16:08:40', NULL),
(16, 2, 118, '2010-04-20 16:08:42', NULL),
(17, 2, 114, '2010-04-20 16:08:45', NULL),
(18, 2, 113, '2010-04-20 16:08:49', NULL),
(19, 2, 116, '2010-04-20 16:08:54', NULL),
(20, 3, 110, '2010-04-20 16:08:57', NULL),
(21, 3, 114, '2010-04-20 16:08:59', NULL),
(22, 3, 117, '2010-04-20 16:09:01', NULL),
(23, 3, 119, '2010-04-20 16:09:03', NULL),
(24, 3, 113, '2010-04-20 16:09:07', NULL),
(25, 3, 116, '2010-04-20 16:09:10', NULL),
(26, 2, 9, '2010-04-20 16:12:07', NULL),
(27, 3, 9, '2010-04-20 16:12:09', NULL),
(28, 2, 10, '2010-04-20 16:12:11', NULL),
(29, 3, 10, '2010-04-20 16:12:16', NULL),
(30, 2, 7, '2010-04-20 16:12:18', NULL),
(31, 3, 7, '2010-04-20 16:12:21', NULL),
(32, 3, 108, '2010-04-20 16:12:29', NULL),
(33, 3, 112, '2010-04-20 16:12:37', NULL),
(34, 2, 112, '2010-04-20 16:12:40', NULL),
(35, 2, 111, '2010-04-20 16:12:42', NULL),
(36, 3, 111, '2010-04-20 16:12:45', NULL),
(37, 3, 118, '2010-04-20 16:54:46', NULL),
(38, 2, 120, '2010-04-25 15:04:53', NULL),
(39, 3, 120, '2010-04-25 15:04:56', NULL),
(40, 2, 122, '2010-04-25 15:04:58', NULL),
(41, 3, 122, '2010-04-25 15:05:00', NULL),
(42, 2, 121, '2010-04-25 15:05:03', NULL),
(43, 3, 121, '2010-04-25 15:05:04', NULL);

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
  ADD CONSTRAINT `rolePermission_ibfk_2` FOREIGN KEY (`permissionId`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rolePermission_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
