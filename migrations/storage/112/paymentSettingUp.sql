-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 19, 2010 at 09:28 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `value` varchar(90) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='General settings table , just for single value elements.' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `settings`
--

REPLACE INTO `settings` (`id`, `name`, `value`, `dateCreated`, `dateUpdated`) VALUES
(1, 'companyName', 'Fake Systems', '2010-06-26 14:56:10', '2010-06-26 14:56:10'),
(2, 'x_login', '4td58YJq', '2010-07-24 16:35:17', '2010-07-24 16:35:17'),
(3, 'x_description', 'Application Fee', '2010-07-24 16:36:06', '2010-07-24 16:36:06'),
(4, 'transaction_key', '4q8Ur5N3T498dvDg', '2010-07-24 16:37:01', '2010-07-24 16:37:01'),
(5, 'test_mode', 'false', '2010-07-24 16:37:58', '2010-07-24 16:37:58'),
(6, 'x_show_form', 'PAYMENT_FORM', '2010-07-24 16:38:15', '2010-07-24 16:38:15'),
(7, 'cc_payment', 'CC', '2010-07-24 16:38:46', '2010-07-24 16:38:46'),
(8, 'echeck_payment', 'ECHECK', '2010-07-24 16:38:59', '2010-07-24 16:38:59'),
(9, 'x_receipt_link_method', 'POST', '2010-07-24 16:39:17', '2010-07-24 16:39:17'),
(10, 'x_receipt_link_text', 'Go back to Apmgr', '2010-07-24 16:39:34', '2010-07-24 16:39:34'),
(11, 'x_receipt_link_url', 'http://apmgr.com/applicant/apply/confirmation', '2010-07-24 16:44:51', '2010-07-24 16:44:51'),
(12, 'authorize_url', 'https://test.authorize.net/gateway/transact.dll', '2010-07-24 16:45:44', '2010-07-24 16:45:44'),
(13, 'paymentSystem', '1', '2010-08-19 21:27:08', '2010-08-19 21:27:08');