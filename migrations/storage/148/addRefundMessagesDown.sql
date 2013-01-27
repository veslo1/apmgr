DELETE FROM messages WHERE identifier IN ( 'feeNotRefundable', 'feeNotFound','feeAmountZero', 'invalidRefundAmount', 'missingDebitAccount', 'missingCreditAccount', 'maxRefundAmountLessThanRefundAmount' );

ALTER TABLE `messages`
CHANGE `identifier` `identifier` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;