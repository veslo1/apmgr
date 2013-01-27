-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2010 at 03:45 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) UNIQUE NOT NULL,
  `value` varchar(90) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='General settings table , just for single value elements.' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

REPLACE INTO `settings` (`id`, `name`, `value`, `dateCreated`, `dateUpdated`) VALUES
(1, 'companyName', 'Fake Systems', '2010-06-26 14:56:10', '2010-06-26 14:56:10');
