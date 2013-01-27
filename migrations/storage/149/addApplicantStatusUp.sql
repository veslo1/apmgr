/* add applicant status table*/
DROP TABLE IF EXISTS `applicantWorkflowStatus`;
DROP TABLE IF EXISTS `applicantStatus`;

CREATE TABLE IF NOT EXISTS `applicantStatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(30) NOT NULL,   
  PRIMARY KEY (`id`),    
  INDEX `nameIndex`(`name`)   /* in case we need to search on this later */
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/* add applicant workflow status table*/
DROP TABLE IF EXISTS `applicantWorkflowStatus`;
CREATE TABLE IF NOT EXISTS `applicantWorkflowStatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,  
  `applicantId` int(11) NOT NULL,
  `applicantStatusId` int(11) unsigned NOT NULL,
  `userId` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,  
  PRIMARY KEY (`id`),  
  INDEX `applicantIdIndex`(`applicantId`),
  INDEX `applicantStatusIdIndex`(`applicantStatusId`),
  INDEX `userIdIndex`(`userId`),  
  CONSTRAINT `applicantWorkflowStatus_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applicantWorkflowStatus_ibfk_2` FOREIGN KEY (`applicantStatusId`) REFERENCES `applicantStatus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applicantWorkflowStatus_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;