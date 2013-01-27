-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 02, 2010 at 04:40 PM
-- Server version: 5.1.45
-- PHP Version: 5.3.2

SET FOREIGN_KEY_CHECKS=0;


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
UPDATE `role` SET `protected`=0 ,`dateUpdated` = NOW() WHERE id=2;
UPDATE `role` SET `protected`=0 , `dateUpdated` = NOW() WHERE id=3;

INSERT INTO `role` (`id`, `name`, `protected`, `dateCreated`, `dateUpdated`) VALUES
(5, 'administrative assistant', 1, '2010-05-02 15:08:45', '2010-05-02 15:08:45'),
(6, 'property manager', 1, '2010-05-02 15:09:19', '2010-05-02 15:09:19'),
(7, 'business services specialist', 1, '2010-05-02 15:09:38', '2010-05-02 15:09:38');
SET FOREIGN_KEY_CHECKS=1;
