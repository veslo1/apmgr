ALTER TABLE unit ADD COLUMN dateAvailable DATE NULL DEFAULT NULL;
INSERT INTO `apmgr`.`messages` (`message`,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`) VALUES ('Is Available is checked but Empty Date Available is empty.  Please select a date', 'emptyDateAvailable', 'error', 'en_US', '1', '2010-11-11', NULL );
INSERT INTO `apmgr`.`messages` (`message`,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`) VALUES ('Invalid Number Range.  Please check that the range does not already exist', 'invalidNumberRange', 'error', 'en_US', '1', '2010-11-11', NULL );