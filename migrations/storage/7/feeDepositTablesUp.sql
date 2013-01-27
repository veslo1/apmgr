SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `fee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(50) UNIQUE NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,  
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(50) UNIQUE NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,  
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 

CREATE TABLE `leaseFee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `leaseId` int(10) unsigned NOT NULL,  
  `feeId` int(10) unsigned NOT NULL,  
  `amount` decimal(10,2) unsigned NOT NULL, 
  PRIMARY KEY (`id`),  
  INDEX (`leaseId`), 
  INDEX (`feeId`),  
  CONSTRAINT `leaseFee_ibfk_1` FOREIGN KEY (`leaseId`) REFERENCES `lease` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaseFee_ibfk_2` FOREIGN KEY (`feeId`) REFERENCES `fee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

SET FOREIGN_KEY_CHECKS=1;
