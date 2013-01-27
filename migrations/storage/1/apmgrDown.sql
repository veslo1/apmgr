DROP DATABASE IF EXISTS apmgr;
--
-- Table structure for table `migration_version`
--
CREATE DATABASE apmgr;
USE apmgr;
DROP TABLE IF EXISTS `migration_version`;
CREATE TABLE IF NOT EXISTS `migration_version` (
 `version` int(11) NOT NULL,
 `current` int(11) NOT NULL default '0',
 `filePath` varchar(50) NOT NULL,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime default NULL,
 PRIMARY KEY  (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dumping data for table `migration_version`
--
INSERT INTO `migration_version`(`version`,`current`,`filePath`,`dateCreated`,`dateUpdated`) VALUES (1,0,'/storage/1',NOW(),NOW());
INSERT INTO `migration_version`(`version`,`current`,`filePath`,`dateCreated`,`dateUpdated`) VALUES (2,0,'/storage/2',NOW(),NOW());