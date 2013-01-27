/*	Collection of tables that I find with errors
 Just in case ...
 TRUNCATE TABLE `deposit`;
*/ 
ALTER TABLE `deposit` 
DROP COLUMN `debitAccountId`,
DROP COLUMN `creditAccountId`;

ALTER TABLE `deposit`
ADD `debitAccountId` INT UNSIGNED NOT NULL ,
ADD `creditAccountId` INT UNSIGNED NOT NULL ,
ADD INDEX ( `debitAccountId`) ,
ADD INDEX (`creditAccountId` ),
ADD CONSTRAINT `deposit_ibfk_1` FOREIGN KEY (`debitAccountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `deposit_ibfk_2` FOREIGN KEY (`creditAccountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `fee`
DROP COLUMN `debitAccountId`,
DROP COLUMN `creditAccountId`;

ALTER TABLE `fee`
ADD `debitAccountId` INT UNSIGNED NOT NULL ,
ADD `creditAccountId` INT UNSIGNED NOT NULL ,
ADD INDEX ( `debitAccountId`) ,
ADD INDEX (`creditAccountId` ),
ADD CONSTRAINT `fee_ibfk_1` FOREIGN KEY (`debitAccountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fee_ibfk_2` FOREIGN KEY (`creditAccountId`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `eventsNotification` CHANGE `confirmed` `confirmed` TINYINT( 1 ) NOT NULL DEFAULT '0';
