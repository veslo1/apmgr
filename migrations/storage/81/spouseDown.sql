ALTER TABLE `applicantSpouse` DROP `identification`;
ALTER TABLE `applicantSpouse` ADD `driversLicense` INT NOT NULL AFTER `ssn`;
ALTER TABLE `applicantSpouse` ADD `govtLicense` INT NOT NULL AFTER `driversLIcense`; 