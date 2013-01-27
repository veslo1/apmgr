-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 02, 2010 at 04:40 PM
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
-- Table structure for table `role`
--

-- Dumping data for table `role`
--

REPLACE INTO `role` (`id`, `name`, `protected`, `dateCreated`, `dateUpdated`) VALUES
(1, 'admin', 1, '2010-02-06 18:20:09', '2010-02-06 18:20:13'),
(2, 'member', 1, '2010-02-06 18:20:27', NOW() ),
(3, 'viewer', 1, '2010-02-06 18:20:37', NOW()),
(4, 'guest', 1, '2010-05-01 15:17:12', '2010-05-01 15:17:12');
DELETE FROM `role` WHERE `id`>=5;
SET FOREIGN_KEY_CHECKS=1;
