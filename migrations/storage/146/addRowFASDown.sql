ALTER TABLE `financialAccountSetting`
DROP INDEX `nameIndex`;

DELETE FROM financialAccountSetting WHERE settingName = 'refundCashAccount';