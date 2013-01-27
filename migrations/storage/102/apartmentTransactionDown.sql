--
-- Table structure for table `apartmentTransaction`
--

CREATE TABLE IF NOT EXISTS `apartmentTransaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `apartmentId` int(10) unsigned NOT NULL,
  `unitId` int(10) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `apartmentId` (`apartmentId`),
  KEY `unitId` (`unitId`),
  KEY `transactionId` (`transactionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `userApartmentAccess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `apartmentId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `apartmentId` (`apartmentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Holds the apartments the logged in user can access' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `userApartmentAccess`
--

REPLACE INTO `userApartmentAccess` (`id`, `dateCreated`, `dateUpdated`, `userId`, `apartmentId`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2);
SET FOREIGN_KEY_CHECKS=1;