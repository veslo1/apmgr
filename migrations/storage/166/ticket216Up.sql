DROP TABLE applicantRentalCriminalHistoryAnswer;
DROP TABLE applicantRentalCriminalHistoryQuestion;

ALTER TABLE applicantRentalCriminalHistory
ADD COLUMN propertyComment text NULL DEFAULT NULL;

ALTER TABLE applicantRentalCriminalHistory
MODIFY crimeComment text NULL DEFAULT NULL;