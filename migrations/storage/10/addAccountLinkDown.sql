ALTER TABLE `fee` 
DROP COLUMN `debitAccountId`,
DROP COLUMN `creditAccountId`;

ALTER TABLE `deposit` 
DROP COLUMN `debitAccountId`,
DROP COLUMN `creditAccountId`;

