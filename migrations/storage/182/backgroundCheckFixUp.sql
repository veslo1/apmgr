ALTER TABLE applicantBackgroundCheck DROP INDEX applicantId_2;
ALTER TABLE `applicantBackgroundCheck` CHANGE `userId` `userId` INT( 11 ) NULL DEFAULT '1' COMMENT 'This is the user that performs the change.Default 1, the admin';
ALTER TABLE `applicantBackgroundCheck` CHANGE `status` `status` ENUM( 'passed', 'notrun', 'rejected' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'notrun';