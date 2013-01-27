SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `rentSettings`;
CREATE TABLE `rentSettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `prorationEnabled` tinyint(4) NOT NULL,
  `rentDueDay` int(10) unsigned NOT NULL,
  `prorationType` enum('thirtyday','actual','year') NOT NULL,
  `prorationApplyMonth` int(10) unsigned NOT NULL DEFAULT '2' COMMENT 'currently should only be used for months 1 and 2',
  `secondMonthDue` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'is second month due at the lease signing?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

REPLACE INTO `rentSettings` (id,dateCreated,dateUpdated,prorationEnabled,rentDueDay,prorationType,prorationApplyMonth,secondMonthDue ) VALUES 
(1, '2010-05-11 15:33:06 ','2010-05-11 15:33:06',1,1,'thirtyday',2,0);

SET FOREIGN_KEY_CHECKS=1;
