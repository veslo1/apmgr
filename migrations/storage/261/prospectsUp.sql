ALTER TABLE `prospects` DROP `rentRange`;
ALTER TABLE  `prospects` ADD  `rentRangeFrom` DOUBLE NOT NULL AFTER  `howDidYouHear` ,
ADD  `rentRangeTo` DOUBLE NOT NULL AFTER  `rentRangeFrom`;