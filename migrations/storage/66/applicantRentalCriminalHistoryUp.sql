DROP TABLE IF EXISTS `applicantRentalCriminalHistoryAnswer`;
DROP TABLE IF EXISTS `applicantRentalCriminalHistoryQuestion`;
DROP TABLE IF EXISTS `applicantRentalCriminalHistory`;

CREATE TABLE IF NOT EXISTS `applicantRentalCriminalHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL, 
  `crimeComment` varchar(255) NOT NULL,  
  PRIMARY KEY (`id`),
  INDEX (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant credit history info';

CREATE TABLE IF NOT EXISTS `applicantRentalCriminalHistoryQuestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `question` varchar(255) NOT NULL,    
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions';


CREATE TABLE IF NOT EXISTS `applicantRentalCriminalHistoryAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantRentalCriminalHistoryId` int(11) NOT NULL,
  `applicantRentalCriminalHistoryQuestionId` int(11) NOT NULL,     
  PRIMARY KEY (`id`),
  INDEX (`applicantRentalCriminalHistoryId`),
  INDEX (`applicantRentalCriminalHistoryQuestionId`),
  FOREIGN KEY (`applicantRentalCriminalHistoryId`) REFERENCES `applicantRentalCriminalHistory`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`applicantRentalCriminalHistoryQuestionId`) REFERENCES `applicantRentalCriminalHistoryQuestion`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal answer';

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 1 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'beenEvicted' );

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 2 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'movedBeforeEndOfLease' );

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 3 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'declaredBankruptcy' );

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 4 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'suedForRent' );

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 5 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'suedForPropertyDamage' );

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 6 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'resolvedCrime' );

INSERT INTO `apmgr`.`applicantRentalCriminalHistoryQuestion` ( `id` , `dateCreated` , `dateUpdated` , `question` ) VALUES
( 7 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'notResolvedCrime' );
