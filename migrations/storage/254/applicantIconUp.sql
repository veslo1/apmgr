UPDATE actions
SET icon='/images/dashboard/actionBar/applicant/waitlist.gif'
WHERE name="Waitlist";

UPDATE actions
SET icon='/images/dashboard/actionBar/applicant/application.gif'
WHERE name="Application";

UPDATE controllers
SET icon='/images/dashboard/controllerBar/applicantModule/dashboard.png'
WHERE name="Dashboard";

UPDATE actions
SET icon='/images/dashboard/actionBar/applicant/fees.gif'
WHERE name="Fees";

UPDATE actions
SET icon='/images/dashboard/actionBar/applicant/viewallapplicants.png'
WHERE name="viewallapplicants";

DROP TABLE applicantAnswers;

DROP TABLE rentalAnswers;
DROP TABLE rentalQuestions;

CREATE TABLE `applicantSurvey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,  
  `wereYouReferred` varchar(255) NOT NULL,
  `howDidYouFindUs` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicantId` (`applicantId`),
  CONSTRAINT `applicantSurvey_ibfk_1` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Referral form answers' AUTO_INCREMENT=1;