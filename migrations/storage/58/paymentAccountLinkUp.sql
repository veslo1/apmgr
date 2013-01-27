INSERT INTO account (id,name, orientation,number,dateCreated,dateUpdated) VALUES (5,'Cash','debit',5,NOW(),NOW());
INSERT INTO accountLink (name, debitAccountId, creditAccountId,dateCreated,dateUpdated) VALUES ('paidRent',5,2,NOW(),NOW());

