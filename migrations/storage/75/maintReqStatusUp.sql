SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `maintenanceRequestAssignedStatus`;
DROP TABLE IF EXISTS `maintenanceRequestComment`;
DROP TABLE IF EXISTS `maintenanceRequest`;
DROP TABLE IF EXISTS `maintenanceStatus`;
DROP TABLE IF EXISTS `maintenanceRequestHistory`;
DROP VIEW IF EXISTS `maintenanceRequestView`;

CREATE TABLE `maintenanceStatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,  
  `status` varchar(255) UNIQUE NOT NULL,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='possible maintenance statuses';

INSERT INTO `apmgr`.`maintenanceStatus` ( `id` , `dateCreated` , `dateUpdated` , `status` ) VALUES
( 1 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'new' );

INSERT INTO `apmgr`.`maintenanceStatus` ( `id` , `dateCreated` , `dateUpdated` , `status` ) VALUES
( 2 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'pending' );

INSERT INTO `apmgr`.`maintenanceStatus` ( `id` , `dateCreated` , `dateUpdated` , `status` ) VALUES
( 3 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'rejected' );

INSERT INTO `apmgr`.`maintenanceStatus` ( `id` , `dateCreated` , `dateUpdated` , `status` ) VALUES
( 4 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'resolved' );

INSERT INTO `apmgr`.`maintenanceStatus` ( `id` , `dateCreated` , `dateUpdated` , `status` ) VALUES
( 5 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'feedback' );

CREATE TABLE `maintenanceRequest` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime NOT NULL,
 `unitId` int(10) unsigned NOT NULL,
 `requestorId` int(10) NOT NULL,
 `title` varchar(50) NOT NULL,
 `description` varchar(1000) NOT NULL,
 `permissionToEnter` tinyint(1) NOT NULL DEFAULT '0', 
 PRIMARY KEY (`id`),
 INDEX `unitId` (`unitId`),
 INDEX  `requestorId` (`requestorId`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `maintenanceRequestAssignedStatus` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime NOT NULL,
 `maintenanceRequestId` int(10) unsigned NOT NULL,
 `maintenanceStatusId` int(10) unsigned NOT NULL,
 `userId` int(10) NOT NULL,
 `assignedTo` int(10) NOT NULL,
 `currentStatus` tinyint(1) NOT NULL DEFAULT 0,
 PRIMARY KEY (`id`),
 INDEX  `maintenanceRequestId` (`maintenanceRequestId`),
 INDEX  `maintenanceStatusId` (`maintenanceStatusId`),
 INDEX  `userId` (`userId`),
 INDEX  `assignedTo` (`assignedTo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `maintenanceRequestComment` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime NOT NULL,
 `maintenanceRequestId` int(10) unsigned NOT NULL,
 `comment` varchar(1000) NOT NULL,
 `userId` int(10) NOT NULL,
 PRIMARY KEY (`id`),
 INDEX  `maintenanceRequestId` (`maintenanceRequestId`),
 INDEX  `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `maintenanceRequest`
  ADD CONSTRAINT `maintenanceRequest_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maintenanceRequest_ibfk_2` FOREIGN KEY (`requestorId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;  

ALTER TABLE `maintenanceRequestAssignedStatus`
  ADD CONSTRAINT `maintenanceRequestAssignedStatus_ibfk_1` FOREIGN KEY (`maintenanceRequestId`) REFERENCES `maintenanceRequest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maintenanceRequestAssignedStatus_ibfk_2` FOREIGN KEY (`maintenanceStatusId`) REFERENCES `maintenanceStatus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maintenanceRequestAssignedStatus_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maintenanceRequestAssignedStatus_ibfk_4` FOREIGN KEY (`assignedTo`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `maintenanceRequestComment`
  ADD CONSTRAINT `maintenanceRequestComment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
INSERT INTO `apmgr`.`messages` (
`id` , `message` , `identifier` , `category` , `language` , `locked` , `dateCreated` , `dateUpdated` ) VALUES
( NULL , 'Error posting the form. Please contact technical support.', 'postError', 'error', 'en_US', '1', '2010-06-01', NULL ),
( NULL , 'Invalid Id.', 'invalidId', 'error', 'en_US', '1', '2010-06-01', NULL );  ;  
  
SET FOREIGN_KEY_CHECKS=1;
