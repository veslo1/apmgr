-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2010 at 09:12 PM
-- Server version: 5.0.90
-- PHP Version: 5.2.12-pl0-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apmgr`
--

--
-- Dumping data for table `modules`
--

REPLACE INTO `modules` (`id`, `name`, `icon`, `display`, `dateCreated`, `dateUpdated`) VALUES
(1, 'logs', '/images/dashboard/info.gif', 1, '2010-03-23 21:09:29', NULL),
(2, 'city', '/images/dashboard/CitySearch.gif', 1, '2010-03-23 21:09:29', NULL),
(3, 'default', '/images/dashboard/ok.gif', 1, '2010-03-23 21:09:29', NULL),
(4, 'messages', '/images/dashboard/messages.gif', 1, '2010-03-23 21:09:29', NULL),
(5, 'user', '/images/dashboard/user_48.gif', 1, '2010-03-23 21:09:29', NULL),
(6, 'unit', '/images/dashboard/home_48.gif', 0, '2010-03-23 21:09:29', NULL),
(7, 'payment', NULL, 0, '2010-03-23 21:09:29', NULL),
(8, 'role', '/images/dashboard/role.gif', 1, '2010-03-23 21:09:29', NULL),
(9, 'permission', '/images/dashboard/onebit_04.gif', 1, '2010-03-23 21:09:29', NULL),
(10, 'country', '/images/dashboard/country.gif', 1, '2010-03-23 21:09:29', NULL),
(11, 'calendar', '/images/dashboard/calendar.gif', 1, '2010-03-23 21:09:29', '2010-03-23 21:08:50'),
(12, 'modules', '/images/dashboard/google_48.gif', 1, '2010-03-23 21:09:29', NULL),
(13, 'apartment', '/images/dashboard/apartment.gif', 1, '2010-03-23 21:09:29', NULL),
(14, 'province', '/images/dashboard/onebit_09.gif', 1, '2010-03-23 21:09:30', NULL),
(15, 'financial', NULL, 0, '2010-03-23 21:09:30', NULL),
(16, 'maintenance', NULL, 0, '2010-03-23 21:09:30', NULL);

