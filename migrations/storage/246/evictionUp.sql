CREATE TABLE IF NOT EXISTS `eviction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,  
  `tenantId` int(10) unsigned NOT NULL,
  `isEvicted` tinyint(1),
  PRIMARY KEY (`id`) ,  
  INDEX tenantIndex(`tenantId`),
  CONSTRAINT `eviction_tenantId_key` FOREIGN KEY (`tenantId`) REFERENCES `tenant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `evictionComment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,  
  `evictionId` int(10) unsigned NOT NULL,
  `userId` int(11) NOT NULL,
  `comment` varchar(2000),
  PRIMARY KEY (`id`) ,  
  INDEX commentEvictIndex(`evictionId`),
  CONSTRAINT `comment_evictId_key` FOREIGN KEY (`evictionId`) REFERENCES `eviction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_userId_key` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `evictionDocument` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,  
  `evictionId` int(10) unsigned NOT NULL,
  `fileId` int(11) NOT NULL,
  PRIMARY KEY (`id`) ,  
  INDEX docEvictIndex(`evictionId`),
  INDEX docFileIndex(`fileId`),
  CONSTRAINT `evicdoc_evictionId_key` FOREIGN KEY (`evictionId`) REFERENCES `eviction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evicdoc_fileId_key` FOREIGN KEY (`fileId`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
