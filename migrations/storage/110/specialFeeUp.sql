DELETE FROM fee WHERE id=1;

INSERT INTO `apmgr`.`fee` (
`id` ,
`dateCreated` ,
`dateUpdated` ,
`name` ,
`amount` ,
`enabled` ,
`debitAccountId` ,
`creditAccountId`
)
VALUES (
'1', '2010-08-16 21:48:06', NULL , 'Required Applicant Fee', '0', '1', '1', '2'
);

INSERT INTO `apmgr`.`applicantFeeSetting` (
`id` ,
`feeId` ,
`dateCreated` ,
`dateUpdated`
)
VALUES (
'1', '1', '2010-08-16 21:59:56', NULL
);