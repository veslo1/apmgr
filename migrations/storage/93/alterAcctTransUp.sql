ALTER TABLE `accountTransaction`
DROP `referenceNumber`;

ALTER TABLE `paymentDetail`
CHANGE `paymentNumber` `paymentNumber` VARCHAR( 20 ) NOT NULL COMMENT 'stores the check or cc or money order number';