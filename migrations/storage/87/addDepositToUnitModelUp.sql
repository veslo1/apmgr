SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE `unitModel`
ADD COLUMN `depositId` INT( 10 ) UNSIGNED NOT NULL COMMENT 'the deposit for the unit model',
ADD INDEX ( `depositId` );

ALTER TABLE `unitModel`
ADD CONSTRAINT `unitModel_ibfk_1` FOREIGN KEY (`depositId`) REFERENCES `deposit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
  