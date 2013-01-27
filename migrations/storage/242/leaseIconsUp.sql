UPDATE actions
SET icon = "/images/onebit_49.png"
WHERE name = "Createleasefee";

DELETE FROM actions
WHERE name = "Createleasedeposit";

INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Myleaselist', NULL , '1', '2011-01-09 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Myleaselist', '2011-01-09 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='tenant');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);