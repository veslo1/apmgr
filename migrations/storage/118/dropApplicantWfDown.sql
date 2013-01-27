	CREATE TABLE `applicantWorkflowStatus` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `applicantId` int(11) DEFAULT NULL,
 `dateCreated` datetime DEFAULT NULL COMMENT 'Date this record was created',
 `description` text COMMENT 'Description of why the change was triggered',
 `status` enum('pending','rejected','accepted') NOT NULL,
 `previousStatus` enum('pending','rejected','accepted') NOT NULL,
 `current` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `applicantId` (`applicantId`),
 FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='History of the status of a user in the system';