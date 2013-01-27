-- Down script
-- change state back to non enum and drop phone number
ALTER TABLE `apartment`
MODIFY COLUMN `state` varchar(50),
DROP COLUMN `phone`;