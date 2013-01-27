-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2010 at 07:36 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

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
(105, 'Currentaddress', NULL, 1, '2010-06-19 21:09:41', '2010-07-03 18:17:50'),
(106, 'Previous Address', NULL, 1, '2010-06-19 21:09:41', '2010-07-03 18:19:19'),
(107, 'Spouse', NULL, 1, '2010-06-19 21:09:41', '2010-07-03 18:20:40'),
(108, 'Rental Criminal History', NULL, 1, '2010-06-26 14:02:07', '2010-07-03 18:20:15'),
(109, 'Current Work History', NULL, 1, '2010-06-26 14:02:07', '2010-07-03 18:18:17'),
(110, 'Previous Work History', NULL, 1, '2010-06-26 14:02:07', '2010-07-03 18:19:45'),
(111, 'Credithistory', NULL, 1, '2010-06-26 14:02:07', '2010-07-03 18:17:22'),
(112, 'Occupants', NULL, 1, '2010-06-26 14:02:07', NULL),
(113, 'Vehicles', NULL, 1, '2010-06-26 14:02:07', NULL),
(114, 'Emergency Contact', NULL, 1, '2010-06-26 14:02:07', '2010-07-03 18:18:53'),
(115, 'Whyyourented', NULL, 1, '2010-06-26 14:02:07', NULL),
(116, 'Authorization', NULL, 1, '2010-06-26 14:02:07', '2010-07-03 13:49:09');

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
  `phone` varchar(9) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='applicant address info' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `applicantAddress`
--

REPLACE INTO `applicantAddress` (`id`, `applicantId`, `address`, `city`, `state`, `phone`, `rent`, `apartmentName`, `ownerName`, `apartmentPhone`, `moveInDate`, `moveOutDate`, `reasonForLeaving`, `isCurrentResidence`, `dateCreated`, `dateUpdated`) VALUES
(1, 9, 'Vergara 1945 3º', 'Banfield', 'TX', '', 800.00, 'Vergara', 'Calcagno', '352751531', '2004-12-15', '2010-11-30', 'Calcagno is a complete asshole', 1, '2010-07-03 19:20:16', '2010-07-03 19:20:16');
SET FOREIGN_KEY_CHECKS=1;
