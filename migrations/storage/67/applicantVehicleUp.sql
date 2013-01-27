CREATE TABLE IF NOT EXISTS `applicantVehicles` ( 
`id` INT AUTO_INCREMENT NOT NULL, 
`userId` INT NOT NULL, 
`brand` VARCHAR(50) NULL, 
`license` CHAR(9) NULL, 
`state` ENUM('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') DEFAULT NULL, 
`dateCreated` DATETIME NOT NULL, 
`dateUpdated` DATETIME DEFAULT NULL,
PRIMARY KEY (`id`),
KEY (`userId`),
KEY (`brand`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COMMENT='Applicants vehicles or his occupants vehicles';
