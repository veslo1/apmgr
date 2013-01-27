RENAME TABLE tenant TO tenet;

UPDATE actions
SET name = replace(name,'tenant','tenet');

UPDATE controllers
SET name = replace(name,'Tenant','Tenet');