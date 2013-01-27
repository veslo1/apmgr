ALTER TABLE applicantRentalCriminalHistory
DROP COLUMN propertyComment;

ALTER TABLE applicantRentalCriminalHistory
MODIFY crimeComment varchar(255) NOT NULL;

CREATE TABLE `applicantRentalCriminalHistoryQuestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions';

 CREATE TABLE `applicantRentalCriminalHistoryAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantRentalCriminalHistoryId` int(11) NOT NULL,
  `applicantRentalCriminalHistoryQuestionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantRentalCriminalHistoryId` (`applicantRentalCriminalHistoryId`),
  KEY `applicantRentalCriminalHistoryQuestionId` (`applicantRentalCriminalHistoryQuestionId`),
  CONSTRAINT `applicantRentalCriminalHistoryAnswer_ibfk_1` FOREIGN KEY (`applicantRentalCriminalHistoryId`) REFERENCES `applicantRentalCriminalHistory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applicantRentalCriminalHistoryAnswer_ibfk_2` FOREIGN KEY (`applicantRentalCriminalHistoryQuestionId`) REFERENCES `applicantRentalCriminalHistoryQuestion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal answer'; 