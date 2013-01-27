/* Reverse 208 */
UPDATE `actions`
SET icon = NULL
WHERE name IN ('Createamenity','Viewallamenities','Viewallapartments','Createunitsingle','Createunitbulk');

/* Reverse 209 */
DELETE FROM messages WHERE identifier IN ('nameExists');