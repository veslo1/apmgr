DELETE FROM `messages` WHERE `identifier`='metadatadeletefail';
DELETE FROM `messages` WHERE `identifier`='unitmetadatadeleted';
ALTER TABLE `unitMetaData` DROP `deleted` ;
