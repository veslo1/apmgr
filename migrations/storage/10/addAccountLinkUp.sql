SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `fee` 
ADD `debitAccountId` INT UNSIGNED NOT NULL ,
ADD `creditAccountId` INT UNSIGNED NOT NULL ,
ADD INDEX ( `debitAccountId` , `creditAccountId` );

ALTER TABLE `deposit` 
ADD `debitAccountId` INT UNSIGNED NOT NULL ,
ADD `creditAccountId` INT UNSIGNED NOT NULL ,
ADD INDEX ( `debitAccountId` , `creditAccountId` ); 
