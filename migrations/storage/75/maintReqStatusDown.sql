--
-- Table structure for table `maintenanceRequest`
--
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `maintenanceRequestAssignedStatus`;
DROP TABLE IF EXISTS `maintenanceRequestComment`;
DROP TABLE IF EXISTS `maintenanceRequest`;
DROP TABLE IF EXISTS `maintenanceStatus`;
DROP TABLE IF EXISTS `maintenanceRequestHistory`;
DROP VIEW IF EXISTS `maintenanceRequestView`;

CREATE TABLE IF NOT EXISTS `maintenanceRequest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL REFERENCES unit (id),
  `requestorId` int(10) unsigned NOT NULL REFERENCES user (id),
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` enum('new','assigned','completed') NOT NULL,
  `assignedTo` int(10) unsigned DEFAULT NULL REFERENCES user (id),
  PRIMARY KEY (`id`),
  KEY `unitId` (`unitId`,`requestorId`,`status`,`assignedTo`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequest`
--


-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequestComment`
--

CREATE TABLE IF NOT EXISTS `maintenanceRequestComment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `maintenanceRequestId` int(10) unsigned NOT NULL REFERENCES maintenanceRequest (id),
  `comment` varchar(1000) NOT NULL,
  `userId` int(10) unsigned NOT NULL REFERENCES user (id),
  PRIMARY KEY (`id`),
  KEY `maintenanceRequestId` (`maintenanceRequestId`,`userId`)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `maintenanceRequestComment`
--


-- --------------------------------------------------------

--
-- Table structure for table `maintenanceRequestHistory`
--


CREATE TABLE IF NOT EXISTS `maintenanceRequestHistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(10) unsigned NOT NULL REFERENCES unit (id),
  `requestorId` int(10) unsigned NOT NULL REFERENCES user (id),
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` enum('new','assigned','completed') NOT NULL,
  `assignedTo` int(10) unsigned DEFAULT NULL REFERENCES user (id),
  `maintenanceRequestId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unitId` (`unitId`,`requestorId`,`status`,`assignedTo`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `maintenanceRequestView` AS select `mr`.`id` AS `id`,`mr`.`dateCreated` AS `dateCreated`,`mr`.`dateUpdated` AS `dateUpdated`,`mr`.`unitId` AS `unitId`,`mr`.`requestorId` AS `requestorId`,`mr`.`title` AS `title`,`mr`.`description` AS `description`,`mr`.`status` AS `status`,`mr`.`assignedTo` AS `assignedTo`,`unit`.`number` AS `unitNumber`,`requestor`.`firstName` AS `requestorFirstName`,`requestor`.`lastName` AS `requestorLastName`,`assigned`.`firstName` AS `assignedFirstName`,`assigned`.`lastName` AS `assignedLastName` from (((`maintenanceRequest` `mr` join `unit` on((`mr`.`unitId` = `unit`.`id`))) join `user` `requestor` on((`mr`.`requestorId` = `requestor`.`id`))) left join `user` `assigned` on((`mr`.`assignedTo` = `assigned`.`id`)));

DELETE FROM messages WHERE identifier='postError';
DELETE FROM messages WHERE identifier='invalidId';
SET FOREIGN_KEY_CHECKS=1;