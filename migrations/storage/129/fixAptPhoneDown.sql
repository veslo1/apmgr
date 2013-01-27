ALTER TABLE `apartment` CHANGE `phone` `phone` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

DELETE FROM messages WHERE identifier IN ('noRecordFound','noUnitModels');