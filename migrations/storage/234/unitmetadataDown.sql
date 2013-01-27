ALTER TABLE file
ADD COLUMN unitId int(11) unsigned NOT NULL;

CREATE INDEX unitId ON file(unitId);

ALTER TABLE file
ADD CONSTRAINT `unitMetaData_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

RENAME TABLE file TO unitMetaData;

DROP TABLE leaseFile;
DROP TABLE unitFile;