UPDATE controllers
SET icon = "/images/dashboard/controllerBar/maintenanceModule/maintsetting.png"
WHERE name = "Setting";

DELETE FROM reports
WHERE name = 'cancelledLease';