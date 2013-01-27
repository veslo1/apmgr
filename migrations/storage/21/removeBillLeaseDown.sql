SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `billLease` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `billId` int(10) unsigned NOT NULL,
  `leaseScheduleId` int(10) unsigned NOT NULL,
  `leaseId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `billId` (`billId`),
  KEY `leaseScheduleId` (`leaseScheduleId`),
  KEY `leaseId` (`leaseId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;
