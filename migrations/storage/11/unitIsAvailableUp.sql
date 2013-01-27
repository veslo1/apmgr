ALTER TABLE `unit` 
ADD `isAvailable` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `unitModelId` ,
ADD INDEX ( `isAvailable` ); 

