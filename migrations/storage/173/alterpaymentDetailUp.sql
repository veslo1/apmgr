/* Feature 223 */
ALTER TABLE paymentDetail
MODIFY paymentType enum('cash','creditcard','check','moneyorder','transfer') NOT NULL;

INSERT INTO `apmgr`.`messages` (`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`)
VALUES ('Error saving account transaction.', 'errorSavingAccountTransaction' , 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL),
       ('Error saving payment detail.', 'errorSavingPaymentDetail', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL),
       ('Error saving payment.', 'errorSavingPayment', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL),
       ('Error saving bill.', 'errorSavingBill', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL),
       ('Missing Applicant Fee Bill.', 'missingApplicantFeeBill', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL);    