CREATE INDEX name_2 ON accountType(name);

CREATE INDEX name ON account(name);

ALTER TABLE accountTransaction
DROP INDEX datePosted;

ALTER TABLE bill
DROP INDEX dueDate;

CREATE INDEX name ON fee(name);

ALTER TABLE fee
DROP INDEX enabled;

ALTER TABLE fee
DROP INDEX refundable;

ALTER TABLE lease
DROP INDEX leaseEndDate;

ALTER TABLE lease
DROP INDEX isCancelled;