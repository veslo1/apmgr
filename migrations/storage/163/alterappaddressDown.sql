ALTER TABLE applicantAddress
ADD COLUMN phone char(10) NULL;

ALTER TABLE applicantAddress
DROP COLUMN zip;