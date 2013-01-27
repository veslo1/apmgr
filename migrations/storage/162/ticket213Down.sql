CREATE TABLE `applicantEmergencyContactChoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `choice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions'; 

CREATE TABLE `applicantEmergencyContactChoiceAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `applicantId` int(11) NOT NULL,
  `applicantEmergencyContactChoiceId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantEmergencyContactChoiceId` (`applicantEmergencyContactChoiceId`),
  KEY `applicantId` (`applicantId`),
  CONSTRAINT `applicantEmergencyContactChoiceAnswer_ibfk_2` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `applicantEmergencyContactChoiceAnswer_ibfk_1` FOREIGN KEY (`applicantEmergencyContactChoiceId`) REFERENCES `applicantEmergencyContactChoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact answer';

ALTER TABLE applicantEmergencyContact
DROP COLUMN personEnterDwelling;


ALTER TABLE applicantPersonalInfo
MODIFY identification int(11) NOT NULL;