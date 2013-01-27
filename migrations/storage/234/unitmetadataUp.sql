ALTER TABLE unitMetaData
DROP FOREIGN KEY `unitMetaData_ibfk_1`,
DROP COLUMN unitId;

RENAME TABLE unitMetaData TO file;

CREATE TABLE `leaseFile` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime DEFAULT NULL, 
 `leaseId` int(10) unsigned NOT NULL,
 `fileId` int(11) NOT NULL,  
 PRIMARY KEY (`id`),
 KEY `leaseId` (`leaseId`),
 KEY `fileId` (`fileId`), 
 CONSTRAINT `leaseFile_ibfk_1` FOREIGN KEY (`leaseId`) REFERENCES `lease` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `leaseFile_ibfk_2` FOREIGN KEY (`fileId`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `unitFile` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime DEFAULT NULL, 
 `unitId` int(10) unsigned NOT NULL,
 `fileId` int(11) NOT NULL,  
 PRIMARY KEY (`id`),
 KEY `unitId` (`unitId`),
 KEY `fileId` (`fileId`), 
 CONSTRAINT `unitFile_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `unitFile_ibfk_2` FOREIGN KEY (`fileId`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;