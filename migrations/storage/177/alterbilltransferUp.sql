ALTER TABLE billTransfer
ADD COLUMN `transactionId` int(10) unsigned NOT NULL,
ADD INDEX `transactionIdIndex`(`transactionId`),  
ADD CONSTRAINT `billTransfer_ibfk_3` FOREIGN KEY (`transactionId`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;