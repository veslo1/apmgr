SET FOREIGN_KEY_CHECKS = 0;
 
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(150) NOT NULL,
  `username` varchar(90) NOT NULL,
  `password` varchar(250) NOT NULL,
  `emailAddress` varchar(250) NOT NULL,
  `phone` varchar(90) DEFAULT NULL,
  `mobile` varchar(90) DEFAULT NULL,
  `fax` varchar(90) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='The user table.';

INSERT INTO `user` VALUES (1,'Jorge','Vazquez','jvazquez','dddd5d7b474d2c78ebbb833789c4bfd721edf4bf','jorgeomar.vazquez@gmail.com',NULL,NULL,NULL,0,'2009-09-27 16:58:26','2009-09-27 16:58:30'),(2,'Chango','Lolo','clololo','dddd5d7b474d2c78ebbb833789c4bfd721edf4bf','lolo@gmail.com',NULL,NULL,NULL,0,'2009-09-28 21:03:18','2009-09-28 21:03:18'),(3,'Cholo','Chango','cchango','dddd5d7b474d2c78ebbb833789c4bfd721edf4bf','chango@gmail.com',NULL,NULL,NULL,0,'2009-09-28 21:03:52','2009-09-28 21:03:52'),(5,'John','Lopez','jlopez','dddd5d7b474d2c78ebbb833789c4bfd721edf4bf','jorgeomar.vazquez@gmail.com',NULL,NULL,NULL,0,'2009-09-28 21:03:52','2009-12-17 19:10:05'),(6,'John','Connor','jconnor','dddd5d7b474d2c78ebbb833789c4bfd721edf4bf','jconnor@debserverp4.com.ar',NULL,NULL,NULL,0,'2010-12-05 20:32:14','2010-12-05 20:32:14'),(7,'Alfred','Royse','aroyse','dddd5d7b474d2c78ebbb833789c4bfd721edf4bf','aroyse@debserverp4.com.ar',NULL,NULL,NULL,0,'2010-12-07 22:39:44','2010-12-07 22:39:44');

DROP TABLE IF EXISTS `userRole`;
CREATE TABLE `userRole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`),
  KEY `role_id` (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='This interrelation tables shows the roles that a user has';

INSERT INTO `userRole` VALUES (1,1,1,'2009-09-27 16:58:40','2009-09-27 16:58:43'),(2,2,3,'2009-09-28 21:03:18','2009-09-28 21:03:18'),(3,3,3,'2009-09-28 21:03:52','2009-09-28 21:03:52'),(4,5,2,'2009-10-03 18:02:59','2009-12-19 15:41:39'),(5,6,8,'2010-12-05 20:32:14','2010-12-05 20:32:14'),(6,7,8,'2010-12-07 22:39:44','2010-12-07 22:39:44');

ALTER TABLE `userRole` ADD CONSTRAINT `userRole_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `userRole` ADD CONSTRAINT `userRole_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS = 0;