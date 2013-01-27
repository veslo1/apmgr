/* Renamed this earlier - not sure why it is still here.... */
CREATE TABLE IF NOT EXISTS `unitAmenity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `unitId` int(11) unsigned NOT NULL REFERENCES unit (id),
  `amenityId` int(11) unsigned NOT NULL REFERENCES amenity (id),
  PRIMARY KEY (`id`),
  KEY `unitId` (`unitId`,`amenityId`),
  KEY `amenityId` (`amenityId`) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;