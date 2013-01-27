-- Drop credit card columns and payment number so we don't store any sensitive data to trigger pci compliance
ALTER TABLE `paymentDetail` 
DROP COLUMN `paymentNumber`,
DROP COLUMN `ccName`,
DROP COLUMN `ccExpirationDate`;