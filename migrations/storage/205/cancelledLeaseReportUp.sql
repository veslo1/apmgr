UPDATE controllers
SET icon = "/images/dashboard/controllerBar/maintenanceModule/maintsetting.png"
WHERE name = "Setting";

INSERT INTO `apmgr`.`reports` ( `id` , `name` , `cacheIdentifier` , `moduleId` , `cacheTtl` , `urlPath` , `dateCreated` , `dateUpdated` )
VALUES ( NULL , 'cancelledLease', 'cancelledLease', '12', '60', 'cancelledlease', '2010-11-24 20:04:21', NULL );