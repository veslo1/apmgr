SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `leaseWizard`
  DROP FOREIGN KEY leaseWizard_ibfk_4,
  DROP COLUMN `accountLinkId`,
  DROP COLUMN `referenceNumber`,
  DROP COLUMN `comment`;  

ALTER TABLE `leaseWizard` 
  ADD COLUMN `deposit` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, 
  ADD COLUMN `fee` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  ADD COLUMN `userId` INT(11) NOT NULL AFTER `unitId`,
  ADD INDEX ( `userId` ),
  ADD CONSTRAINT `leaseWizard_ibfk_5` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
SET FOREIGN_KEY_CHECKS=1;

