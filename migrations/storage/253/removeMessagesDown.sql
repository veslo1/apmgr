-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2011 at 08:51 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5

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
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `identifier` varchar(50) NOT NULL,
  `category` enum('error','warning','success') NOT NULL,
  `language` char(5) NOT NULL DEFAULT 'en_US' COMMENT 'The language this token was created.',
  `locked` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Lock this field to prevent deletion',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=126 ;

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
(43, 'The operation cannot continue. There is only one occurence left', 'etDeleteBlock', 'warning', 'en_US', 1, '2010-04-24 22:51:43', NULL),
(44, 'The limit of allowed files has been reached', 'quotaLimit', 'error', 'en_US', 1, '2010-05-08 23:24:19', NULL),
(45, 'The directory couldn''t be created. Please ask for permissions.', 'directoryFail', 'warning', 'en_US', 1, '2010-05-08 23:40:49', NULL),
(46, 'The unit id is missing', 'unitIdMissing', 'error', 'en_US', 1, '2010-05-08 23:41:51', NULL),
(47, 'The transfer could not succeed', 'transferFail', 'error', 'en_US', 1, '2010-05-09 14:37:47', NULL),
(48, 'Ok', 'noModelSchedule', 'error', 'en_US', 1, '2010-05-14 00:11:09', NULL),
(50, 'The specified file exists', 'fileExists', 'error', 'en_US', 1, '2010-05-15 13:42:17', NULL),
(51, 'Access Denied. ', 'accessDenied', 'error', 'en_US', 1, '0000-00-00 00:00:00', NULL),
(52, 'Error saving.  Please contact technical support.', 'errorSaving', 'error', 'en_US', 1, '0000-00-00 00:00:00', NULL),
(53, 'The operation couldn''t continue', 'metadatadeletefail', 'error', 'en_US', 1, '2010-05-23 11:47:13', NULL),
(54, 'Picture deleted', 'unitmetadatadeleted', 'success', 'en_US', 1, '2010-05-23 11:51:13', NULL),
(55, 'The specified username already exists.\r\nPlease choose another', 'usernameExists', 'error', 'en_US', 1, '2010-05-29 22:44:02', NULL),
(56, 'There was an error when your account was created.\r\nSystem administrators had been alerted and your account will be reviewed. We will contact you.', 'userNameFailRole', 'warning', 'en_US', 1, '2010-05-29 22:47:06', NULL),
(57, 'An error happened while you were filling up your application.\r\nOperation failed', 'errorDuringApplyProc', 'error', 'en_US', 1, '2010-05-30 19:07:59', NULL),
(58, 'The model you were applying was disabled.\r\nOperation failed', 'modelIdWasRemoved', 'error', 'en_US', 1, '2010-05-30 19:10:56', NULL),
(59, 'You have been applied in the wait list correctly', 'userAppliedToWaitlist', 'success', 'en_US', 1, '2010-05-30 19:13:27', NULL),
(60, 'The user does not exists', 'usernotfound', 'error', 'en_US', 1, '2010-05-31 22:48:07', NULL),
(61, 'There seems to be a problem in our application. The system administration has been alerted.', 'notWrittableError', 'error', 'en_US', 1, '2010-06-04 22:31:19', NULL),
(62, 'The file was succesfully created', 'fileCreated', 'success', 'en_US', 1, '2010-06-05 10:29:13', NULL),
(63, 'The CSV file has been uploaded.', 'csvFileUploaded', 'success', 'en_US', 1, '2010-06-05 23:48:52', NULL),
(64, 'The uploaded file is no longer available', 'csvFileMissing', 'error', 'en_US', 1, '2010-06-06 16:11:06', NULL),
(65, 'The given unit is not valid', 'unitIdNotValid', 'error', 'en_US', 1, '2010-06-08 20:50:50', NULL),
(66, 'The apartment id is missing', 'apartmentIdMissing', 'error', 'en_US', 1, '2010-06-08 21:23:41', NULL),
(67, 'The Aparment is not valid', 'apartmentIdNotValid', 'error', 'en_US', 1, '2010-06-08 21:29:36', NULL),
(68, 'The model id is missing', 'modelIdIsMissing', 'error', 'en_US', 1, '2010-06-08 21:44:27', NULL),
(69, 'The model is not valid', 'modelIdNotValid', 'error', 'en_US', 1, '2010-06-08 21:46:32', NULL),
(70, 'The unit is not for rent', 'unitIsNotForRent', 'error', 'en_US', 1, '2010-06-11 17:56:31', NULL),
(71, 'You are not on the process to apply', 'noApplicantSessionDetected', 'error', 'en_US', 1, '2010-06-13 17:06:14', NULL),
(72, 'An error occured while saving your information. Please retry.', 'aboutyouWarning', 'warning', 'en_US', 1, '2010-06-17 21:41:13', NULL),
(73, 'The specified setting does not exists', 'settingDoesNotExists', 'error', 'en_US', 1, '2010-06-26 15:36:15', NULL),
(74, 'Error posting the form. Please contact technical support.', 'postError', 'error', 'en_US', 1, '0000-00-00 00:00:00', NULL),
(75, 'The setting was saved', 'settingSaved', 'success', 'en_US', 1, '2010-07-11 14:23:35', NULL),
(76, 'There are no records to show yet', 'noRecordsToPaginate', 'warning', 'en_US', 1, '2010-07-11 14:46:37', NULL),
(77, 'The setting was disabled', 'settingDeleted', 'success', 'en_US', 1, '2010-07-11 17:10:50', NULL),
(78, 'The setting could not be disabled', 'errorSettingDelete', 'error', 'en_US', 1, '2010-07-11 17:12:31', NULL),
(79, 'Payments uploaded successfully. ', 'paymentsUploaded', 'success', 'en_US', 1, '2010-08-08 00:00:00', NULL),
(80, 'Error uploading payments.', 'errorUploadingPayments', 'error', 'en_US', 1, '2010-08-08 00:00:00', NULL),
(81, 'No account link set. ', 'noAccountLinkSet', 'error', 'en_US', 1, '2010-08-13 00:00:00', NULL),
(82, 'Error posting payment', 'errorPostingPayment', 'error', 'en_US', 1, '2010-08-13 00:00:00', NULL),
(83, 'No rows to process.  Please check that rows in the file have not already been processed', 'noRowsToProcess', 'error', 'en_US', 1, '2010-08-13 00:00:00', NULL),
(84, 'Error posting payments.  Please view the unprocessed or errors table, fix the errors in the spreadsheet and reupload.', 'errorBulkRentUploadData', 'error', 'en_US', 1, '2010-08-13 00:00:00', NULL),
(85, 'Error Saving.  Please configure the default assigned group in the maintenance settings ', 'missingMaintenanceSetting', 'error', 'en_US', 1, '2010-08-13 00:00:00', NULL),
(86, 'Error Saving.  You are not assigned to a current lease so you cannot open any maintenance requests.', 'maintReqNoUnit', 'error', 'en_US', 1, '2010-08-13 00:00:00', NULL),
(87, 'You don''t have any due fee''s', 'noDueFees', 'success', 'en_US', 1, '2010-08-21 13:08:44', NULL),
(88, 'Record Created Successfully!', 'recordCreatedSuccessfully', 'success', 'en_US', 1, '2010-08-22 00:00:00', NULL),
(89, 'The payment system is disabled', 'paymentDissabled', 'warning', 'en_US', 1, '2010-08-25 00:26:28', NULL),
(90, 'The record does not exist for the selected ID.', 'noRecordFound', 'error', 'en_US', 1, '2010-08-08 00:00:00', NULL),
(91, 'No unit models found.  Please create unit models first and return to this page.', 'noUnitModels', 'error', 'en_US', 1, '2010-08-08 00:00:00', NULL),
(92, 'Please enter a different unit number.', 'numberExists', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(93, 'Record Updated Successfully', 'recordUpdatedSuccessfully', 'success', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(94, 'Fee not refundable', 'feeNotRefundable', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(95, 'Fee amount is zero or less', 'feeAmountZero', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(96, 'Invalid refund amount', 'invalidRefundAmount', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(97, 'Missing debit account on the account transaction.  Please check the fee''s accounts.', 'missingDebitAccount', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(98, 'Missing credit account on the account transaction.  Please check the financial account settings.', 'missingCreditAccount', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(99, 'The max refund/forfeited amount allowed is less than the entered amount.  Please enter a lower amount.', 'maxRefundAmountLessThanRefundAmount', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(100, 'Fee not found', 'feeNotFound', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(101, 'Missing User Id', 'missingUserId', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(102, 'Same Applicant Id', 'sameApplicantId', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(103, 'Missing Applicant Id', 'missingApplicantId', 'error', 'en_US', 1, '2010-09-05 00:00:00', NULL),
(104, 'Name exists. Please enter a different name.', 'nameExists', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(105, 'Bill Id or Fee Id is missing.', 'missingBillFeeIds', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(106, 'Refund Created Successfully.', 'refundCreatedSuccessfully', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(107, 'Forfeit Created Successfully.', 'forfeitCreatedSuccessfully', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(108, 'Error creating bill.', 'errorCreatingBill', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(109, 'Error saving prelease fee.', 'errorSavingPreleaseFee', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(110, 'Error saving account transaction.', 'errorSavingAccountTransaction', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(111, 'Error saving payment detail.', 'errorSavingPaymentDetail', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(112, 'Error saving payment.', 'errorSavingPayment', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(113, 'Error saving bill.', 'errorSavingBill', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(114, 'Missing Applicant Fee Bill.', 'missingApplicantFeeBill', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(115, 'Applicant fee to apply amount greater than bill amount.', 'transferGreaterThanBillAmount', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(116, 'Applicant fee to apply is already applied towards a bill.  Please select another fee to apply.', 'transferAlreadyAppliedToBill', 'error', 'en_US', 1, '2010-09-26 15:54:40', NULL),
(117, 'Record Deleted!', 'recordDeleted', 'success', 'en_US', 1, '2010-11-02 00:00:40', NULL),
(118, 'Is Available is checked but Empty Date Available is empty.  Please select a date', 'emptyDateAvailable', 'error', 'en_US', 1, '2010-11-11 00:00:00', NULL),
(119, 'Invalid Number Range.  Please check that the range does not already exist', 'invalidNumberRange', 'error', 'en_US', 1, '2010-11-11 00:00:00', NULL),
(120, 'Duplicate Months.  Please verify that months are unique', 'duplicateMonth', 'error', 'en_US', 1, '2010-11-11 00:00:00', NULL),
(121, 'Payment retrieved properly', 'paymentCreated', 'success', 'en_US', 1, '2010-11-15 22:41:53', NULL),
(122, 'No apartment found.  Please create an apartment.', 'noApartment', 'error', 'en_US', 1, '2010-11-11 00:00:00', NULL),
(123, 'File not found.', 'fileNotFound', 'error', 'en_US', 1, '2010-08-08 00:00:00', NULL),
(124, 'File deleted successfully.', 'fileDeleted', 'success', 'en_US', 1, '2010-08-08 00:00:00', NULL),
(125, 'Error deleting file.', 'errorDeletingFile', 'error', 'en_US', 1, '2010-08-08 00:00:00', NULL);
SET FOREIGN_KEY_CHECKS=1;