ALTER TABLE  `prospects` CHANGE  `howDidYouHear`  `howDidYouHear` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE  `prospects` CHANGE  `rentRangeFrom`  `rentRangeFrom` DOUBLE NULL ,CHANGE  `rentRangeTo`  `rentRangeTo` DOUBLE NULL;
ALTER TABLE  `prospects` CHANGE  `possibleMoveInDate`  `possibleMoveInDate` DATE NOT NULL;
ALTER TABLE  `prospects` CHANGE  `occupants`  `occupants` INT( 11 ) NOT NULL;
ALTER TABLE  `prospects` ADD  `phone` VARCHAR( 30 ) NOT NULL AFTER  `email`;
ALTER TABLE  `prospects` CHANGE  `rentRangeFrom`  `rentRangeFrom` DOUBLE NULL DEFAULT  '0',
CHANGE  `rentRangeTo`  `rentRangeTo` DOUBLE NULL DEFAULT  '0';
