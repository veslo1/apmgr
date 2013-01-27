ALTER TABLE  `prospects` ADD  `rentRange` DOUBLE NOT NULL AFTER  `howDidYouHear`;
ALTER TABLE `prospects` DROP `rentRangeFrom`;
ALTER TABLE `prospects` DROP `rentRangeTo`;