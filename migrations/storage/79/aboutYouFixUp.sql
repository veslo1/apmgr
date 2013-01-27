 ALTER TABLE `applicantPersonalInfo`
  DROP `driversLicense`,
  DROP `govtLicense`;
 ALTER TABLE `applicantPersonalInfo` ADD `identification` INT( 11 ) NOT NULL AFTER `streetAddress` ;