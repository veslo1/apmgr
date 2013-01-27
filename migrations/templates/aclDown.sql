ALTER TABLE permission DROP FOREIGN KEY permission_ibfk_1;
ALTER TABLE rolePermission DROP FOREIGN KEY rolePermission_ibfk_1;
ALTER TABLE rolePermission DROP FOREIGN KEY rolePermission_ibfk_2;
ALTER TABLE reports DROP FOREIGN KEY reports_ibfk_1;

DROP TABLE IF EXISTS `actions`;

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(90) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '1',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(2)),
  KEY `icon` (`icon`(6))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `controllers`;

CREATE TABLE `controllers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All the controllers that we have';

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(5))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The content of the modules folder, ie all the modules';



DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleId` int(11) NOT NULL,
  `controllerId` int(11) NOT NULL,
  `actionId` int(11) NOT NULL,
  `alias` varchar(90) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `moduleId` (`moduleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rolePermission`;

CREATE TABLE `rolePermission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuple` (`roleId`,`permissionId`),
  KEY `roleId` (`roleId`),
  KEY `permissionId` (`permissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relation between roles and permissions';

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `cacheIdentifier` varchar(50) NOT NULL,
  `moduleId` int(11) NOT NULL,
  `cacheTtl` int(11) DEFAULT '60',
  `urlPath` varchar(50) NOT NULL COMMENT 'The partial url for this report',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(5)),
  KEY `moduleId` (`moduleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Report interface' AUTO_INCREMENT=16 ;


[%s]

ALTER TABLE reports ADD CONSTRAINT reports_ibfk_1 FOREIGN KEY ( moduleId ) REFERENCES modules (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE permission ADD CONSTRAINT permission_ibfk_1 FOREIGN KEY ( moduleId ) REFERENCES modules (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE rolePermission ADD CONSTRAINT rolePermission_ibfk_1 FOREIGN KEY ( roleId ) REFERENCES role (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE rolePermission ADD CONSTRAINT rolePermission_ibfk_2 FOREIGN KEY ( permissionId ) REFERENCES permission (id) ON DELETE CASCADE ON UPDATE CASCADE;