mysql -udev -pdev apmgr -e "DROP DATABASE apmgr;  CREATE DATABASE apmgr;  USE apmgr;
DROP TABLE IF EXISTS migration_version;
CREATE TABLE IF NOT EXISTS migration_version (
 version int(11) NOT NULL,
 current int(11) NOT NULL default 0,
 filePath varchar(50) NOT NULL,
 dateCreated datetime NOT NULL,
 dateUpdated datetime default NULL,
 PRIMARY KEY  (version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO migration_version(version,current, filePath,dateCreated) VALUES(0,1,'/storage/0',NOW())"
