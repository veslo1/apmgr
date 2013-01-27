
SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `leaseWizard`
  ADD COLUMN `accountLinkId` int(11) DEFAULT NULL,
  ADD COLUMN `referenceNumber` int(11) DEFAULT NULL,
  ADD COLUMN `comment` varchar(200) DEFAULT NULL;

ALTER TABLE `leaseWizard`
  DROP `deposit`,  
  DROP `fee`,
  DROP `userId`;

SET FOREIGN_KEY_CHECKS=1;

