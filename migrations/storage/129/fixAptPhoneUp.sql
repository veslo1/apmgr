ALTER TABLE `apartment` CHANGE `phone` `phone` CHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

INSERT INTO `apmgr`.`messages` (`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`) VALUES 
('The record does not exist for the selected ID.', 'noRecordFound', 'error', 'en_US', '1', '2010-08-08', NULL ),
('No unit models found.  Please create unit models first and return to this page.', 'noUnitModels', 'error', 'en_US', '1', '2010-08-08', NULL );