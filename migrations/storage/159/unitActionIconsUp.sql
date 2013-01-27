/* Feature 208 */
UPDATE `actions`
SET icon = '/images/dashboard/actionBar/amenity/createamenity.png'
WHERE name = 'Createamenity';

UPDATE `actions`
SET icon = '/images/dashboard/actionBar/amenity/viewallamenities.png'
WHERE name = 'Viewallamenities';

UPDATE `actions`
SET icon = '/images/dashboard/actionBar/apartment/viewallapartments.png'
WHERE name = 'Viewallapartments';

UPDATE `actions`
SET icon = '/images/dashboard/actionBar/unit/createunitsingle.png'
WHERE name = 'Createunitsingle';

UPDATE `actions`
SET icon = '/images/dashboard/actionBar/unit/createunitbulk.png'
WHERE name = 'Createunitbulk';

UPDATE `actions`
SET icon = '/images/dashboard/actionBar/unit/viewallunits.png'
WHERE name = 'Viewallunits';

/* Fix bug 209 in amenity save */
INSERT INTO `apmgr`.`messages` (`id` ,`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`)
VALUES (NULL , 'Name exists. Please enter a different name.', 'nameExists', 'error', 'en_US', '1', '2010-09-26 15:54:40', NULL);