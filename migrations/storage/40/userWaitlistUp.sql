DROP TABLE IF EXISTS userWaitlist;

CREATE TABLE IF NOT EXISTS `apmgr`.`userWaitlist` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`userId` INT NOT NULL ,
`modelId` INT NOT NULL COMMENT 'The model id the user was applying to',
`comments` TEXT NOT NULL ,
`dateCreated` DATETIME NOT NULL ,
`dateUpdated` DATETIME NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'User waitlist table';

ALTER TABLE `userWaitlist` ADD INDEX ( `modelId` ) ;
ALTER TABLE `userWaitlist` CHANGE `modelId` `modelId` INT( 11 ) UNSIGNED NOT NULL COMMENT 'The model id the user was applying to';
ALTER TABLE `userWaitlist` ADD FOREIGN KEY ( `userId` ) REFERENCES `apmgr`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
-- ALTER TABLE `userWaitlist` DROP FOREIGN KEY `userWaitlist_ibfk_1` ;

ALTER TABLE `userWaitlist` ADD FOREIGN KEY ( `modelId` ) REFERENCES `apmgr`.`unitModel` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;