ALTER TABLE `financialAccountSetting`
ADD INDEX `nameIndex` (settingName);

INSERT INTO `apmgr`.`financialAccountSetting` (`settingName` ,`accountId` ,`description` ,`dateCreated` ,`dateUpdated`) VALUES ('refundCashAccount', '5', 'refundCashAccountDescription', '2010-09-11 14:02:58', NULL);