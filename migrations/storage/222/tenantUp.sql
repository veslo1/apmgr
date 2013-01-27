RENAME TABLE tenet TO tenant;

UPDATE actions
SET name = replace(name,'tenet','tenant');

UPDATE controllers
SET name = replace(name,'Tenet','Tenant');