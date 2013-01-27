ALTER TABLE unitModel
ADD COLUMN `size` int(11) unsigned NOT NULL COMMENT "In the us this is sq ft.  We''ll need to translate this field according to local measurements", 
ADD COLUMN `numBeds` tinyint(3) unsigned NOT NULL,
ADD COLUMN `numBaths` decimal(2,1) unsigned NOT NULL,
ADD COLUMN `numFloors` tinyint(3) unsigned NOT NULL COMMENT '1 story, 2 story, etc';

ALTER TABLE `unitAmenity`
DROP FOREIGN KEY`unitAmenity_ibfk_1`,
CHANGE `unitId` `unitModelId` INT( 10 ) UNSIGNED NOT NULL,
ADD CONSTRAINT `unitAmenity_ibfk_4` FOREIGN KEY (`unitModelId`) REFERENCES `unitModel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `unit`
  DROP `size`,
  DROP `numBeds`,
  DROP `numBaths`,
  DROP `numFloors`;

RENAME TABLE `unitAmenity` TO `unitModelAmenity` ;