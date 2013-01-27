DROP TABLE IF EXISTS `forfeitedFee`;

ALTER TABLE `refund`
DROP FOREIGN KEY `refund_ibfk_3`,
DROP COLUMN  `transactionId`;

DELETE FROM financialAccountSetting WHERE settingName = 'forfeitCashAccount';

ALTER TABLE `financialAccountSetting`
DROP INDEX `accountIdIndex`,
DROP FOREIGN KEY `fas_ibfk_1`;

ALTER TABLE `financialAccountSetting`
ADD INDEX (`accountId`),
ADD CONSTRAINT `fas_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;