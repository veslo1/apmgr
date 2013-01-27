/* add forfeit fee table*/
DROP TABLE IF EXISTS `forfeitedFee`;
CREATE TABLE IF NOT EXISTS `forfeitedFee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,  
  `billId` int(10) unsigned NOT NULL,  
  `amount` decimal(10,2) unsigned NOT NULL,
  `feeId` int(10) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,  
  PRIMARY KEY (`id`),  
  INDEX (`billId`),
  INDEX `feeIdIndex`(`feeId`),
  INDEX `transactionIdIndex`(`transactionId`),
  CONSTRAINT `forfeitedFee_ibfk_1` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `forfeitedFee_ibfk_2` FOREIGN KEY (`feeId`) REFERENCES `fee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `forfeitedFee_ibfk_3` FOREIGN KEY (`transactionId`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/* add transaction to refund  */
ALTER TABLE `refund`
ADD COLUMN  `transactionId` int(10) unsigned NOT NULL,
ADD INDEX `transactionIdIndex`(`transactionId`),
ADD CONSTRAINT `refund_ibfk_3` FOREIGN KEY (`transactionId`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/* alter constraint */
ALTER TABLE `financialAccountSetting`
DROP FOREIGN KEY `financialAccountSetting`,
DROP INDEX `accountId`;

ALTER TABLE `financialAccountSetting`
ADD INDEX `accountIdIndex`(`accountId`),
ADD CONSTRAINT `fas_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*	financialAccountSetting has defined accountId as unique, and you have already used the `accountId` 5 , so you will have to change this */
INSERT INTO `apmgr`.`financialAccountSetting` (`settingName` ,`accountId` ,`description` ,`dateCreated` ,`dateUpdated`) VALUES ('forfeitCashAccount', '5', 'forfeitCashAccountDescription', '2010-09-11 14:02:58', NULL);