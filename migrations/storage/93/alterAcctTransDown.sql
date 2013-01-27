ALTER TABLE `accountTransaction`
ADD COLUMN `referenceNumber` int(11) NOT NULL;


ALTER TABLE `paymentDetail`
CHANGE `paymentNumber` `paymentNumber` int( 11 ) NOT NULL COMMENT 'stores the check or cc or money order number';
