CREATE TABLE IF NOT EXISTS `applicantSetting` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` CHAR( 15 ) NOT NULL ,
`value` VARCHAR( 40 ) NOT NULL ,
`dateCreated` DATETIME NOT NULL ,
`dateUpdated` DATETIME NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Settings for applicant';