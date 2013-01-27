ALTER TABLE `lease`
CHANGE `leaseStartDate` `effectiveDate` DATETIME NOT NULL;

ALTER TABLE `lease`
DROP COLUMN `leaseEndDate`;

ALTER TABLE `lease`
ADD COLUMN `cancellationLastDay` date DEFAULT NULL COMMENT 'if cancelled, the last day the tenets will be at the apt';

ALTER TABLE `leaseWizard`
DROP `moveInDate`;