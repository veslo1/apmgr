UPDATE actions
SET icon='/images/dashboard/066613-sky-blue-white-pearl-icon-people-things-lamp1.png'
WHERE name="Waitlist";

UPDATE actions
SET icon='/images/dashboard/066658-sky-blue-white-pearl-icon-people-things-people-student-study.png'
WHERE name="Application";

UPDATE controllers
SET icon='/images/dashboard/066613-sky-blue-white-pearl-icon-people-things-lamp1.png'
WHERE name="Dashboard";

UPDATE actions
SET icon='/images/dashboard/087011-sky-blue-white-pearl-icon-business-dollar.png'
WHERE name="Fees";

UPDATE actions
SET icon='/images/dashboard/actionBar/applicant/viewapplicants.png'
WHERE name="viewallapplicants";

DROP TABLE applicantSurvey;

CREATE TABLE `applicantAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) DEFAULT NULL,
  `answerId` int(11) DEFAULT NULL,
  `extraQuestionOne` text,
  `extraQuestionTwo` text,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `questionId` (`questionId`),
  KEY `answerId` (`answerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Answers that the user may provide' AUTO_INCREMENT=1 ;