ALTER TABLE `reports` ADD COLUMN `cacheIdentifier` VARCHAR(50) NOT NULL AFTER `name`;
UPDATE `reports` SET `cacheIdentifier`='rentRoll',`dateUpdated`='2010-11-06 12:35:00' WHERE `reports`.`id`=1;