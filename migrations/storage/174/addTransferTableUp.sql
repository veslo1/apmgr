/* Feature 223 */
CREATE TABLE `billTransfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,    
  `fromBillId` int(10) unsigned NOT NULL,
  `toBillId` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),  
  KEY `fromBillIdKey` (`fromBillId`),
  KEY `toBillIdKey` (`toBillId`),  
  CONSTRAINT `billtransfer_ibfk_1` FOREIGN KEY (`fromBillId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `billtransfer_ibfk_2` FOREIGN KEY (`toBillId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='holds the '   