-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2010 at 09:03 PM
-- Server version: 5.0.90
-- PHP Version: 5.2.12-pl0-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

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
(35, 'An exception happened !', 'exceptionCaught', 'warning', 'en_US', 1, '2010-03-20 15:39:48', NULL);
