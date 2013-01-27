 ALTER TABLE `applicantAddress` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
 ALTER TABLE `applicantAnswers` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
 ALTER TABLE `applicantAuthorization` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
 ALTER TABLE `applicantCreditHistory` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
 ALTER TABLE `applicantEmergencyContact` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
 ALTER TABLE `applicantEmergencyContactChoiceAnswer` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
 
ALTER TABLE `applicantPersonalInfo` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
ALTER TABLE `applicantRentalCriminalHistory` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
ALTER TABLE `applicantSpouse` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
ALTER TABLE `applicantTransactions` CHANGE `userId` `applicantId` INT( 11 ) NULL DEFAULT NULL ;
ALTER TABLE `applicantVehicles` CHANGE `userId` `applicantId` INT( 11 ) NOT NULL ;
