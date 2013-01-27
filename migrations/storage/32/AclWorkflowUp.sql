-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2010 at 12:43 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

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
(96, 'Addpicture', '/images/dashboard/camera_add_48.gif', 1, '2010-05-14 21:09:13', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All the controllers that we have' AUTO_INCREMENT=15 ;

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
(7, 'Search', NULL, 0, '2010-04-20 15:03:36', NULL),
(8, 'Leasewizard', NULL, 0, '2010-04-20 15:03:37', NULL),
(9, 'Tenet', NULL, 0, '2010-04-20 15:03:37', NULL),
(10, 'Join', NULL, 0, '2010-04-20 15:03:37', NULL),
(11, 'Login', NULL, 0, '2010-04-20 15:03:37', NULL),
(12, 'Add', NULL, 0, '2010-05-14 21:09:47', NULL),
(13, 'Backend', NULL, 0, '2010-05-22 12:12:17', NULL),
(14, 'Apply', NULL, 0, '2010-05-22 12:12:17', NULL);

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
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `countryId` int(6) DEFAULT '1',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Relation between roles and permissions' AUTO_INCREMENT=84 ;

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
(16, 2, 118, '2010-04-20 16:08:42', NULL),
(17, 2, 114, '2010-04-20 16:08:45', NULL),
(18, 2, 113, '2010-04-20 16:08:49', NULL),
(19, 2, 116, '2010-04-20 16:08:54', NULL),
(20, 3, 110, '2010-04-20 16:08:57', NULL),
(21, 3, 114, '2010-04-20 16:08:59', NULL),
(23, 3, 119, '2010-04-20 16:09:03', NULL),
(24, 3, 113, '2010-04-20 16:09:07', NULL),
(25, 3, 116, '2010-04-20 16:09:10', NULL),
(26, 2, 9, '2010-04-20 16:12:07', NULL),
(27, 3, 9, '2010-04-20 16:12:09', NULL),
(28, 2, 10, '2010-04-20 16:12:11', NULL),
(29, 3, 10, '2010-04-20 16:12:16', NULL),
(30, 2, 7, '2010-04-20 16:12:18', NULL),
(31, 3, 7, '2010-04-20 16:12:21', NULL),
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
(43, 3, 121, '2010-04-25 15:05:04', NULL),
(44, 4, 98, '2010-05-03 22:43:56', NULL),
(45, 4, 102, '2010-05-03 22:44:21', NULL),
(46, 4, 100, '2010-05-03 22:44:41', NULL),
(47, 4, 72, '2010-05-03 22:45:51', NULL),
(48, 4, 103, '2010-05-03 22:46:31', NULL),
(51, 1, 91, '2010-05-02 14:22:24', NULL),
(54, 1, 1, '2010-05-02 14:40:10', NULL),
(55, 1, 145, '2010-05-14 21:49:57', NULL),
(56, 6, 145, '2010-05-14 21:49:57', NULL),
(60, 1, 143, '2010-05-16 15:53:32', NULL),
(61, 4, 143, '2010-05-16 15:53:32', NULL),
(62, 5, 143, '2010-05-16 15:53:32', NULL),
(63, 6, 143, '2010-05-16 15:53:32', NULL),
(64, 1, 142, '2010-05-16 15:53:49', NULL),
(65, 2, 142, '2010-05-16 15:53:49', NULL),
(66, 3, 142, '2010-05-16 15:53:49', NULL),
(67, 4, 142, '2010-05-16 15:53:49', NULL),
(68, 5, 142, '2010-05-16 15:53:49', NULL),
(69, 6, 142, '2010-05-16 15:53:49', NULL),
(70, 7, 142, '2010-05-16 15:53:49', NULL),
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
(83, 8, 148, '2010-05-22 12:41:13', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rolePermission`
--
ALTER TABLE `rolePermission`
  ADD CONSTRAINT `rolePermission_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rolePermission_ibfk_2` FOREIGN KEY (`permissionId`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
