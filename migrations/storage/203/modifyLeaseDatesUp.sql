ALTER TABLE `lease`
CHANGE `effectiveDate` `leaseStartDate` DATETIME NOT NULL;

ALTER TABLE `lease`
ADD `leaseEndDate` DATETIME NOT NULL AFTER `leaseStartDate`;

ALTER TABLE `lease`
DROP `cancellationLastDay`;

ALTER TABLE `leaseWizard`
ADD `moveInDate` DATETIME NULL DEFAULT NULL;