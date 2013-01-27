/* Duplicate index since unique apparently already adds an index */
ALTER TABLE accountType
DROP INDEX `name_2`;

/* Doesn't appear account name is searched on */
ALTER TABLE account
DROP INDEX `name`;

/* add index on datePosted since it is used in queries */
CREATE INDEX datePosted ON accountTransaction(datePosted);

/* add index on dueDate since it is used in queries */
CREATE INDEX dueDate ON bill(dueDate);

/* Doesn't appear account name is searched on */
ALTER TABLE fee
DROP INDEX `name`;

/* add index on enabled since it is used in queries */
CREATE INDEX enabled ON fee(enabled);

/* add index on refundable since it is used in queries */
CREATE INDEX refundable ON fee(refundable);

/* add index on leaseEndDate since it is used in queries */
CREATE INDEX leaseEndDate ON lease(leaseEndDate);

/* add index on isCancelled since it is used in queries */
CREATE INDEX isCancelled ON lease(isCancelled);