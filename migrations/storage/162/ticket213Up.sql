DROP TABLE applicantEmergencyContactChoiceAnswer;
DROP TABLE applicantEmergencyContactChoice;

ALTER TABLE applicantEmergencyContact
ADD COLUMN personEnterDwelling varchar(500) NOT NULL;

ALTER TABLE applicantPersonalInfo
MODIFY identification varchar(30) NOT NULL;