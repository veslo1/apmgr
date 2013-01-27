/* Feature 223*/
INSERT INTO `apmgr`.`messages` (`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`)
VALUES ('Applicant fee to apply amount greater than bill amount.', 'transferGreaterThanBillAmount', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL),
       ('Applicant fee to apply is already applied towards a bill.  Please select another fee to apply.', 'transferAlreadyAppliedToBill', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL);