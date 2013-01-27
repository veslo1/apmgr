DELETE FROM permission WHERE alias='Role View Roleaccess';

INSERT INTO `apmgr`.`rolePermission` ( `id` ,`roleId` , `permissionId` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , '1', '192', NOW( ) , NULL );