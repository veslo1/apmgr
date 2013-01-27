DROP TABLE IF EXISTS `prospects`;
CREATE TABLE `prospects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `contactMode` int(11) NOT NULL,
  `howDidYouHear` text NOT NULL,
  `rentRange` double NOT NULL,
  `modelType` int(11) NOT NULL,
  `possibleMoveInDate` date DEFAULT NULL,
  `pets` int(11) NOT NULL,
  `occupants` int(11) DEFAULT '0',
  `notes` text,
  `status` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `firstName` (`firstName`(3)),
  KEY `lastName` (`lastName`(3))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Used in the application for sales and marketing';
