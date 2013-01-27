DROP TABLE IF EXISTS `applicantEmergencyContactSelection`;
DROP TABLE IF EXISTS `applicantEmergencyContact`;

CREATE TABLE `applicantEmergencyContact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `contactName` varchar(255) NULL, 
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,  
  `zip` int(11) NOT NULL,   
  `mainPhone` varchar(10) NOT NULL,
  `workPhone` varchar(10) NULL,  
  `relationship` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact info';

CREATE TABLE IF NOT EXISTS `applicantEmergencyContactChoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `choice` varchar(255) NOT NULL,    
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant rental/criminal questions';


CREATE TABLE IF NOT EXISTS `applicantEmergencyContactChoiceAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `applicantEmergencyContactChoiceId` int(11) NOT NULL,     
  PRIMARY KEY (`id`),
  INDEX (`applicantEmergencyContactChoiceId`),  
  FOREIGN KEY (`applicantEmergencyContactChoiceId`) REFERENCES `applicantEmergencyContactChoice`(`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant emergency contact answer';

INSERT INTO `apmgr`.`applicantEmergencyContactChoice` ( `id` , `dateCreated` , `dateUpdated` , `choice` ) VALUES
( 1 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'abovePerson' );

INSERT INTO `apmgr`.`applicantEmergencyContactChoice` ( `id` , `dateCreated` , `dateUpdated` , `choice` ) VALUES
( 2 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'yourSpouse' );

INSERT INTO `apmgr`.`applicantEmergencyContactChoice` ( `id` , `dateCreated` , `dateUpdated` , `choice` ) VALUES
( 3 , '2010-06-22 15:42:02', '2010-06-22 15:42:06', 'parentChild' );