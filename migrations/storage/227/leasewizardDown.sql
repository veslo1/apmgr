ALTER TABLE leaseWizard
DROP INDEX leaseId,
DROP FOREIGN KEY `leaseIdKey`,
DROP COLUMN leaseId;

ALTER TABLE leaseWizard
DROP INDEX fromLeaseId,
DROP FOREIGN KEY `fromLeaseIdKey`,
DROP COLUMN fromLeaseId;