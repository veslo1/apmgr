CREATE TABLE `applicantWorkHistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL, 
  `employerName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL,  
  `zip` int(11) NOT NULL, 
  `employerPhone` varchar(10) NOT NULL,  
  `monthlyIncome` decimal(10,2) NOT NULL,
  `dateStarted` date NOT NULL,
  `dateEnded` date NOT NULL,
  `supervisorName` varchar(255) NOT NULL,
  `supervisorPhone` varchar(10) NOT NULL, 
  `isCurrentEmployer` tinyint(1) DEFAULT 0,  
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant work history info';