DROP TABLE leaseDeposit;
DROP TABLE deposit;

ALTER TABLE fee
ADD COLUMN refundable TINYINT(1) NOT NULL DEFAULT 0;

DROP TABLE IF EXISTS `refund`;
CREATE TABLE IF NOT EXISTS `refund` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,  
  `billId` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,  
  PRIMARY KEY (`id`),  
  INDEX (`billId`),  
  CONSTRAINT `refund_ibfk_1` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;