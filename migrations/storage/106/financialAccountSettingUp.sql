CREATE TABLE `financialAccountSetting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settingName` varchar(25) NOT NULL,
  `accountId` int(10) unsigned NOT NULL,
  `description` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accountId` (`accountId`),
  CONSTRAINT `financialAccountSetting` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores (cash) account used for various fees';

INSERT INTO financialAccountSetting (`settingName`,`accountId`,`description`,`dateCreated`,`dateUpdated`) VALUES ( 'applicantFeeCashAccount',1,'applicantFeeCashAccountDesc','2010-08-14',null );