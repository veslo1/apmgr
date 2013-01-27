ALTER TABLE `unitModel`
ADD COLUMN depositId int(10) unsigned NOT NULL COMMENT 'the deposit for the unit model',
ADD INDEX depositId(`depositId`),
ADD CONSTRAINT `unitModel_ibfk_1` FOREIGN KEY(`depositId`) REFERENCES deposit(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

