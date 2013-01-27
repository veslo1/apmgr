UPDATE actions
SET icon='/images/dashboard/actionBar/role/viewmodules.png'
WHERE name="Viewmodules";

-- myunit
UPDATE actions
SET icon='/images/dashboard/actionBar/unit/myunit.png'
WHERE name="Myunit";

-- set for myunit for tenant
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 374, '2011-01-24 14:08:49', NULL);

-- add logout for tenant
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 220, '2011-01-24 14:08:49', NULL);

-- unit index index
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 133, '2011-01-24 14:08:49', NULL);

DELETE FROM actions
WHERE id IN ( 188,208,209,211,212,157,185,207,214,215,190 );

/* clean up any duplicate permissions
 fuck you mysql http://bugs.mysql.com/bug.php?id=6980
*/
DELETE FROM permission
WHERE id IN (
    SELECT p.id 
    FROM (SELECT * FROM `permission`) AS p
    LEFT JOIN actions ON p.actionId = actions.id
    WHERE actions.id IS NULL
);

/* myunit */
UPDATE actions
SET icon=NULL
WHERE name="Myunit";

UPDATE actions
SET icon='/images/dashboard/actionBar/lease/myleaselist.png'
WHERE name="Myleaselist";

UPDATE actions
SET icon='/images/dashboard/actionBar/lease/viewlease.png'
WHERE name="Mylease";

UPDATE actions
SET icon='/images/dashboard/actionBar/lease/viewmyleasebill.png'
WHERE name="Viewmyleasebill";

-- Viewmyleasedocuments
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( 6 , 'Viewmyleasedocuments', NULL, '1', '2011-01-25 14:00:39', NULL );
SET @mid = (SELECT id FROM modules WHERE name='unit');
SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (11, @mid, @cid, 6, 'Unit Lease Viewmyleasedocuments ', '2011-01-25 14:08:49', NULL);

-- Viewmyleasedocument
INSERT INTO `apmgr`.`actions` ( `id` , `name` , `icon` , `display` , `dateCreated` , `dateUpdated` )
VALUES ( 7 , 'Viewmyleasedocument', NULL, '1', '2011-01-25 14:00:39', NULL );
SET @mid = (SELECT id FROM modules WHERE name='unit');
SET @cid = (SELECT id FROM controllers WHERE name='Lease');

INSERT INTO `apmgr`.`permission` (`id`, `moduleId`, `controllerId`, `actionId`, `alias`, `dateCreated`, `dateUpdated`)
VALUES (12, @mid, @cid, 7, 'Unit Lease Viewmyleasedocument', '2011-01-25 14:08:49', NULL);

/* set for myleaselist for tenant*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 371, '2011-01-25 14:08:49', NULL);

/* my lease */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 377, '2011-01-25 14:08:49', NULL);

/* view mylease documents */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 389, '2011-01-25 14:08:49', NULL);

/* view document */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 367, '2011-01-25 14:08:49', NULL);

/* viewmyleasedocuments */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 11, '2011-01-25 14:08:49', NULL);

/* viewmyleasedocument */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 12, '2011-01-25 14:08:49', NULL);

/* viewmyleasebill */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 378, '2011-01-26 14:08:49', NULL);

/* viewmypayments */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 379, '2011-01-26 14:08:49', NULL);

/* Remove user module and applicant/index access for guest and viewer  */
DELETE FROM rolePermission
WHERE permissionId IN (178,195,53)
AND roleId IN (3,4);

UPDATE modules
SET display=0
WHERE name IN ('messages','calendar','role','settings');

UPDATE actions
SET icon='/images/dashboard/actionBar/account/viewaccounttransactions.png'
WHERE name="Viewaccounttransactions";

UPDATE actions
SET icon='/images/dashboard/actionBar/account/createtrans.png'
WHERE name="Createaccounttransaction";

UPDATE controllers
SET icon='/images/dashboard/reports.png'
WHERE name="Report";

/* Tenant maintenance access */
/* maintenance index */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 81, '2011-01-28 14:08:49', NULL);

/* create maintenance request */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 327, '2011-01-28 14:08:49', NULL);

/* view maintenance request */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 329, '2011-01-28 14:08:49', NULL);

/* view my maintenance requests */
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 331, '2011-01-28 14:08:49', NULL);


/* view my maintenance maintenance index*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 9, 340, '2011-01-28 14:08:49', NULL);

/* Admin access to maintenance */
/* maintenance index */
/*INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 81, '2011-01-29 14:08:49', NULL);
*/

/* view my maintenance maintenance index*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 340, '2011-01-29 14:08:49', NULL);

/* view all maintenance requests*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 328, '2011-01-29 14:08:49', NULL);

/* create maintenance request - admin*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 326, '2011-01-29 14:08:49', NULL);

/* view assigned requests*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 332, '2011-01-29 14:08:49', NULL);

/* admin - view account transactions*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 324, '2011-01-29 14:08:49', NULL);

/* admin - create account transactions*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 323, '2011-01-29 14:08:49', NULL);

/* admin - maint reports*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 346, '2011-01-29 14:08:49', NULL);

/* admin - unit reports*/
INSERT INTO `apmgr`.`rolePermission` (`id`, `roleId`, `permissionId`,`dateCreated`, `dateUpdated`)
VALUES (NULL, 1, 342, '2011-01-29 14:08:49', NULL);

UPDATE reports
SET name="incomingTenantsReport", cacheIdentifier="incomingTenants", urlPath="incomingtenants"
WHERE name="incomingTenetsReport";

UPDATE reports
SET name="outgoingTenantsReport", cacheIdentifier="outgoingTenants", urlPath="outgoingtenants"
WHERE name="outgoingTenetsReport";

UPDATE rentSettings
SET prorationEnabled=0;

/* Set the financialAccountSetting cash account for paying a bill */
INSERT INTO `apmgr`.`financialAccountSetting` (`id`, `settingName`, `accountId`, `description`, `dateCreated`, `dateUpdated`)
VALUES (1, 'leaseRentCashAccount', '5', 'Account to deposit the rent payments', '2011-01-26 19:54:36', NULL);

CREATE UNIQUE INDEX actionsnameIndex ON actions(name);
CREATE UNIQUE INDEX controllersnameIndex ON controllers(name);
CREATE UNIQUE INDEX modulesnameIndex ON modules(name);

DROP INDEX name ON actions;
DROP INDEX name ON controllers;
DROP INDEX name ON modules;