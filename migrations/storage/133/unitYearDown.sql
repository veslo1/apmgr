UPDATE unit SET yearRenovated=0000 WHERE yearRenovated='';
ALTER TABLE `unit` CHANGE `yearBuilt` `yearBuilt` YEAR( 4 ) NOT NULL; 
ALTER TABLE `unit` CHANGE `yearRenovated` `yearRenovated` YEAR( 4 ) NOT NULL; 