ALTER TABLE `unitModel`
  DROP `size`,
  DROP `numBeds`,
  DROP `numBaths`,
  DROP `numFloors`;

ALTER TABLE `unitModelAmenity` CHANGE `unitModelId` `unitId` INT( 11 ) UNSIGNED NOT NULL; 

ALTER TABLE unit
ADD COLUMN `size` int(11) unsigned NOT NULL COMMENT 'In the us this is sq ft.  We''ll need to translate this field according to local measurements', 
ADD COLUMN `numBeds` tinyint(3) unsigned NOT NULL,
ADD COLUMN `numBaths` decimal(2,1) unsigned NOT NULL,
ADD COLUMN `numFloors` tinyint(3) unsigned NOT NULL COMMENT '1 story, 2 story, etc';

RENAME TABLE `unitModelAmenity` TO `unitAmenity`;