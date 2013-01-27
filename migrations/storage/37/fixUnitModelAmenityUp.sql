-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2010 at 10:27 AM
-- Server version: 5.1.46
-- PHP Version: 5.3.2


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `amenity`
--

DROP TABLE IF EXISTS `amenity`;
CREATE TABLE IF NOT EXISTS `amenity` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `name` varchar(50) UNIQUE NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds the amenities of the apt such as ceiling fan, furnishe' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `amenity`
--


-- --------------------------------------------------------

--
-- Table structure for table `unitModel`
--

DROP TABLE IF EXISTS `unitModel`;
CREATE TABLE IF NOT EXISTS `unitModel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `size` int(11) unsigned NOT NULL COMMENT "In the us this is sq ft.  We'll need to translate this field according to local measurements",
  `numBeds` tinyint(3) unsigned NOT NULL,
  `numBaths` decimal(2,1) unsigned NOT NULL,
  `numFloors` tinyint(3) unsigned NOT NULL COMMENT '1 story, 2 story, etc',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `unitModel`
--


-- --------------------------------------------------------

--
-- Table structure for table `unitModelAmenity`
--

DROP TABLE IF EXISTS `unitModelAmenity`;
CREATE TABLE IF NOT EXISTS `unitModelAmenity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitModelId` int(10) unsigned NOT NULL,
  `amenityId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueRecord` (`unitModelId`,`amenityId`),
  INDEX (`unitModelId`),
  INDEX (`amenityId`),
  CONSTRAINT `unitModelAmenity_ibfk_1` FOREIGN KEY (`unitModelId`) REFERENCES `unitModel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `unitModelAmenity_ibfk_2` FOREIGN KEY (`amenityId`) REFERENCES `amenity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

SET FOREIGN_KEY_CHECKS=1;