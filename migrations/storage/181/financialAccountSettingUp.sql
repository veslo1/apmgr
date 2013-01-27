ALTER TABLE financialAccountSetting
MODIFY COLUMN `settingName` varchar(50);

INSERT INTO financialAccountSetting (`settingName`,`accountId`,`description`,`dateCreated`,`dateUpdated`) VALUES ( 'applicantPreleaseFeeCashAccount',1,'applicantPreleaseFeeCashAccountDesc','2010-08-14',null );