CREATE TABLE IF NOT EXISTS `apmgr`.`unitMetaData` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`unitId` INT NOT NULL ,
	`path` VARCHAR( 250 ) NOT NULL ,
	`size` INT NOT NULL ,
	`dateCreated` DATETIME NOT NULL ,
	`dateUpdated` DATETIME NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Unit metadata information';
ALTER TABLE `unitMetaData` ADD INDEX ( `unitId` );
ALTER TABLE `unitMetaData` CHANGE `unitId` `unitId` INT( 11 ) UNSIGNED NOT NULL;
ALTER TABLE `unitMetaData` ADD FOREIGN KEY ( `unitId` ) REFERENCES `apmgr`.`unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;