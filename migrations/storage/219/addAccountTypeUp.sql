DROP TABLE IF EXISTS `accountType`;
CREATE TABLE IF NOT EXISTS `accountType` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NULL,
  `name` varchar(50) UNIQUE NOT NULL,    
  PRIMARY KEY (`id`) ,
  INDEX (`name`)   
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `apmgr`.`accountType` ( `id` ,`dateCreated` ,`dateUpdated` ,`name`)
VALUES (1 , '2010-12-07 19:33:15', NULL , 'asset');

INSERT INTO `apmgr`.`accountType` ( `id` ,`dateCreated` ,`dateUpdated` ,`name`)
VALUES (2 , '2010-12-07 19:33:15', NULL , 'expense');

INSERT INTO `apmgr`.`accountType` ( `id` ,`dateCreated` ,`dateUpdated` ,`name`)
VALUES (3 , '2010-12-07 19:33:15', NULL , 'liability');


INSERT INTO `apmgr`.`accountType` ( `id` ,`dateCreated` ,`dateUpdated` ,`name`)
VALUES (4 , '2010-12-07 19:33:15', NULL , 'revenue');

INSERT INTO `apmgr`.`accountType` ( `id` ,`dateCreated` ,`dateUpdated` ,`name`)
VALUES (5 , '2010-12-07 19:33:15', NULL , 'stockholderEquity');

ALTER TABLE account
ADD COLUMN accountTypeId int(10) unsigned NOT NULL,
ADD INDEX (accountTypeId);

REPLACE INTO `account` (`id`, `dateCreated`, `dateUpdated`, `name`, `number`, `orientation`, `accountTypeId`) VALUES
(1, '2010-05-04 14:07:52', '2010-05-15 13:53:02', 'Rent Revenue', 1, 'credit', 4),
(2, '2010-05-15 13:52:26', '2010-05-15 14:04:09', 'Rent Receivable', 2, 'debit',4),
(3, '2010-05-15 13:53:42', '2010-05-15 13:53:42', 'Rent Discount', 3, 'debit', 2),
(4, '2010-05-15 13:55:15', '2010-05-15 13:55:15', 'Cancelled Rent', 4, 'debit', 2),
(5, '2010-08-06 16:23:28', '2010-08-06 16:23:28', 'Cash', 5, 'debit', 1),
(8, '2010-08-06 17:18:45', NULL, 'Application Fee Receivable', 6, 'debit', 1),
(9, '2010-08-06 17:19:29', NULL, 'Application Fee Revenue', 7, 'credit', 4),
(10, '2010-08-06 17:26:53', NULL, 'Administration Fee Receivable', 8, 'debit', 1),
(11, '2010-08-06 17:26:56', NULL, 'Administration Fee Revenue', 9, 'credit', 4);

ALTER TABLE account
ADD FOREIGN KEY (accountTypeId) REFERENCES `apmgr`.`accountType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 