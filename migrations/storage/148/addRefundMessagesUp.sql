ALTER TABLE `messages`
CHANGE `identifier` `identifier` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; 

INSERT INTO `apmgr`.`messages` (`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`) VALUES 
('Fee not refundable', 'feeNotRefundable', 'error', 'en_US', '1', '2010-09-05', NULL ),
('Fee amount is zero or less', 'feeAmountZero', 'error', 'en_US', '1', '2010-09-05', NULL ),
('Invalid refund amount', 'invalidRefundAmount', 'error', 'en_US', '1', '2010-09-05', NULL ),
("Missing debit account on the account transaction.  Please check the fee\'s accounts.", 'missingDebitAccount', 'error', 'en_US', '1', '2010-09-05', NULL ),
('Missing credit account on the account transaction.  Please check the financial account settings.', 'missingCreditAccount', 'error', 'en_US', '1', '2010-09-05', NULL ),
('The max refund/forfeited amount allowed is less than the entered amount.  Please enter a lower amount.', 'maxRefundAmountLessThanRefundAmount', 'error', 'en_US', '1', '2010-09-05', NULL ),
('Fee not found', 'feeNotFound', 'error', 'en_US', '1', '2010-09-05', NULL );