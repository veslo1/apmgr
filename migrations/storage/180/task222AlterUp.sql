-- If this migration fails again, you will have to review it jorge (this is a note to myself) , so far it failed under Mac
ALTER TABLE `applicantBackgroundCheck` ADD `userId` INT NOT NULL AFTER `status` ,ADD INDEX ( `userId` );
UPDATE `applicantBackgroundCheck` SET userId=1;
ALTER TABLE `applicantBackgroundCheck` CHANGE `userId` `userId` INT( 11 ) NOT NULL DEFAULT '1' COMMENT 'This is the user that performs the change.Default 1, the admin';
-- ALTER TABLE `applicantBackgroundCheck` ADD FOREIGN KEY ( `userId` ) REFERENCES `apmgr`.`user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE `applicantBackgroundCheck` ADD CONSTRAINT `applicantBackgroundCheck_ibfk_2` FOREIGN KEY (`userId`)  REFERENCES `user`(`id`)  ON DELETE CASCADE ON UPDATE CASCADE;
-- We will only have one applicantId
ALTER TABLE `applicantBackgroundCheck` ADD UNIQUE (`applicantId`);
