-- Patch 198 that killed 196
UPDATE `apmgr`.`controllers` SET `icon` =NULL, `display` = '0', `dateUpdated` = NOW() WHERE `controllers`.`id` =34;
