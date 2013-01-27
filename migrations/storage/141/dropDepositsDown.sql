ALTER TABLE fee
DROP COLUMN refundable;

DROP TABLE IF EXISTS `refund`;

DROP TABLE IF EXISTS `deposit`;
CREATE TABLE `deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(50) UNIQUE NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,  
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `leaseDeposit`;
CREATE TABLE `leaseDeposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `leaseId` int(10) unsigned NOT NULL,  
  `depositId` int(10) unsigned NOT NULL,  
  `amount` decimal(10,2) unsigned NOT NULL, 
  PRIMARY KEY (`id`),  
  INDEX (`leaseId`), 
  INDEX (`depositId`),  
  CONSTRAINT `leaseDeposit_ibfk_1` FOREIGN KEY (`leaseId`) REFERENCES `lease` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaseDeposit_ibfk_2` FOREIGN KEY (`depositId`) REFERENCES `deposit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;