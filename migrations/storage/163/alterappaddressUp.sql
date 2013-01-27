ALTER TABLE applicantAddress
DROP COLUMN phone;

ALTER TABLE applicantAddress
ADD COLUMN zip int(11) AFTER state;