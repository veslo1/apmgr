CREATE TABLE `maintenanceSettings` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime NOT NULL,
 `roleId` int(11) NOT NULL,
 `defaultAssignedTo` int(10) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `maintenanceSettings`
  ADD CONSTRAINT `maintenanceSettings_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maintenanceSettings_ibfk_2` FOREIGN KEY (`defaultAssignedTo`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  