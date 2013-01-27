DROP TABLE `applicantStatuses`;

ALTER TABLE `applicantWorkflowStatus`
  DROP `statusId`,
  DROP `previousStatus`;

ALTER TABLE `applicantWorkflowStatus` ADD `status` ENUM( 'pending', 'rejected', 'accepted' ) NOT NULL ,ADD `previousStatus` ENUM( 'pending', 'rejected', 'accepted' ) NOT NULL ;

ALTER TABLE `applicantWorkflowStatus` CHANGE `dateCreated` `dateCreated` DATETIME NULL DEFAULT NULL COMMENT 'Date this record was created';

ALTER TABLE `applicantWorkflowStatus` ADD `current` BOOLEAN NOT NULL DEFAULT '0';
