DROP TABLE IF EXISTS `applicantFeeName`;
DROP TABLE IF EXISTS `applicantFeeParent`;
DROP TABLE IF EXISTS `applicantFeeValue`;
DROP TABLE IF EXISTS `applicantSetting`;

REPLACE INTO `account` (`id`, `dateCreated`, `dateUpdated`, `name`, `number`, `orientation`) VALUES
(1, '2010-05-04 14:07:52', '2010-05-15 13:53:02', 'Rent Revenue', 1, 'credit'),
(2, '2010-05-15 13:52:26', '2010-05-15 14:04:09', 'Rent Receivable', 2, 'debit'),
(3, '2010-05-15 13:53:42', '2010-05-15 13:53:42', 'Rent Discount', 3, 'debit'),
(4, '2010-05-15 13:55:15', '2010-05-15 13:55:15', 'Cancelled Rent', 4, 'debit'),
(5, '2010-08-06 16:23:28', '2010-08-06 16:23:28', 'Cash', 5, 'debit'),
(8, '2010-08-06 17:18:45', NULL, 'Application Fee Receivable', 6, 'debit'),
(9, '2010-08-06 17:19:29', NULL, 'Application Fee Revenue', 7, 'credit'),
(10, '2010-08-06 17:26:53', NULL, 'Administration Fee Receivable', 8, 'debit'),
(11, '2010-08-06 17:26:56', NULL, 'Administration Fee Revenue', 9, 'credit');

ALTER TABLE `fee` ADD `enabled` INT NOT NULL DEFAULT '1' AFTER `amount` ;

REPLACE INTO `fee` (`id`, `dateCreated`, `dateUpdated`, `name`, `amount`, `enabled`, `debitAccountId`, `creditAccountId`) VALUES
(1, '2010-08-06 17:31:28', '2010-08-06 17:31:28', 'Application Fee', 50.00, 1, 8, 9),
(2, '2010-08-06 17:32:02', '2010-08-06 17:32:02', 'Administrative Fee', 10.00, 1, 10, 11);

-- The applicant fee setting table
DROP TABLE IF EXISTS `applicantFeeSetting`;
CREATE TABLE IF NOT EXISTS `applicantFeeSetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feeId` int(10) unsigned NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feeId` (`feeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relation between the applicant fee''s and the fee table' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicantFeeSetting`
--
ALTER TABLE `applicantFeeSetting`
  ADD CONSTRAINT `applicantFeeSetting_ibfk_1` FOREIGN KEY (`feeId`) REFERENCES `fee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;