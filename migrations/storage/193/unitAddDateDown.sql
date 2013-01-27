ALTER TABLE unit DROP COLUMN dateAvailable;
DELETE FROM messages WHERE identifier='emptyDateAvailable';
DELETE FROM messages WHERE identifier='invalidNumberRange';
