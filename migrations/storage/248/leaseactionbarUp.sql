UPDATE actions
SET icon='/images/dashboard/actionBar/lease/startleasewizard.png'
WHERE name="Startleasewizard";

UPDATE actions
SET icon='/images/dashboard/actionBar/lease/viewleaselist.png'
WHERE name="Viewleaselist";

UPDATE actions
SET icon='/images/dashboard/actionBar/lease/viewlease.png'
WHERE name="Viewlease";

UPDATE actions
SET icon = "/images/dashboard/actionBar/lease/createleasefee.png"
WHERE name = "Createleasefee";

DELETE FROM actions
WHERE name = "Createleasedeposit";

-- Viewevictions
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewevictions', '/images/dashboard/actionBar/lease/viewallevictions.png' , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewevictions', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Vieweviction
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Vieweviction', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Vieweviction', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Createeviction
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Createeviction', '/images/dashboard/actionBar/lease/createeviction.png', '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Createeviction', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Viewallevictiondocuments
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewallevictiondocuments', '/images/dashboard/actionBar/lease/viewallevictiondocuments.png', '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewallevictiondocuments', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Addevictiondocument
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Addevictiondocument', '/images/dashboard/actionBar/lease/addevictiondocument.png' , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Addevictiondocument', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Viewevictiondocument
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewevictiondocument', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewevictiondocument', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Deleteevictiondocument
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Deleteevictiondocument', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Deleteevictiondocument', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Adddocument
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Adddocument', '/images/dashboard/actionBar/lease/adddocument.png'  , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Adddocument', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Viewalldocuments
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewalldocuments', '/images/dashboard/actionBar/lease/viewallleasedocuments.png', '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewalldocuments', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Viewdocument
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewdocument', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewdocument', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Mylease
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Mylease', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Mylease', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Myleaselist
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Myleaselist', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Myleaselist', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Myrentbill
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Myrentbill', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Myrentbill', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Payleasebillconfirmation
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Payleasebillconfirmation', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Payleasebillconfirmation', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Payleasebills
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Payleasebills', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Payleasebills', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Selectleasebills
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Selectleasebills', '/images/dashboard/actionBar/lease/dollar.png' , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Selectleasebills', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Viewmyleasebill
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewmyleasebill', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewmyleasebill', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);

-- Viewmypayments
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'Viewmypayments', NULL , '1', '2011-01-19 14:00:39', NULL );

SET @aid = LAST_INSERT_ID();

SET @mid = (SELECT id FROM modules WHERE name='unit');

SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (NULL, @mid, @cid, @aid, 'Unit Lease Viewmypayments', '2011-01-19 14:08:49', NULL);

SET @pid = LAST_INSERT_ID();

SET @rid = (SELECT id FROM role WHERE name='admin');

INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, @rid, @pid, '2011-01-09 14:08:49', NULL);