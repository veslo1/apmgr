ALTER TABLE  `prospects` ENGINE = INNODB;

DROP TABLE IF EXISTS `prospects`;

CREATE TABLE IF NOT EXISTS `prospects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `contactMode` int(11) NOT NULL,
  `howDidYouHear` text,
  `rentRangeFrom` double DEFAULT '0',
  `rentRangeTo` double DEFAULT '0',
  `possibleMoveInDate` date NOT NULL,
  `pets` int(11) NOT NULL,
  `occupants` int(11) NOT NULL,
  `notes` text,
  `status` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstName` (`firstName`(3)),
  KEY `lastName` (`lastName`(3))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Used in the application for sales and marketing' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `prospectsUnitIdAnswers`;

CREATE TABLE  `prospectsUnitIdAnswers` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`prospectId` INT NOT NULL ,
`unitModelId` INT NOT NULL ,
`dateCreated` DATETIME NOT NULL ,
`dateUpdated` DATETIME NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT =  'Options that the user selects';

ALTER TABLE  `prospectsUnitIdAnswers` ADD INDEX (  `prospectId` );

ALTER TABLE  `prospectsUnitIdAnswers` ADD FOREIGN KEY (  `prospectId` ) REFERENCES  `prospects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;