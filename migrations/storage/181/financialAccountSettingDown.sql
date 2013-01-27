DELETE FROM financialAccountSetting WHERE `settingName`= 'applicantPreleaseFeeCashAccount';

ALTER TABLE financialAccountSetting
MODIFY COLUMN `settingName` varchar(25);