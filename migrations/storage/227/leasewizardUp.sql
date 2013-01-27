ALTER TABLE leaseWizard
ADD COLUMN leaseId int(10) unsigned DEFAULT NULL,
ADD INDEX(leaseId),
ADD CONSTRAINT leaseIdKey FOREIGN KEY(`leaseId`) REFERENCES `lease`(`id`);

ALTER TABLE leaseWizard
ADD COLUMN fromLeaseId int(10) unsigned DEFAULT NULL,
ADD INDEX(fromLeaseId),
ADD CONSTRAINT fromLeaseIdKey FOREIGN KEY(`fromLeaseId`) REFERENCES `lease`(`id`);

DELETE FROM messages WHERE identifier='noModelScheduleExists';