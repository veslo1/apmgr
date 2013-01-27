INSERT INTO `apmgr`.`messages` (`message` ,`identifier` ,`category` ,`language` ,`locked` ,`dateCreated` ,`dateUpdated`) VALUES 
('Please enter a different unit number.', 'numberExists', 'error', 'en_US', '1', '2010-09-05', NULL ),
('Record Updated Successfully', 'recordUpdatedSuccessfully', 'success', 'en_US', '1', '2010-09-05', NULL );

INSERT INTO `apmgr`.`rolePermission` (`roleId` ,`permissionId` ,`dateCreated`,`dateUpdated`) VALUES 
('2','203', '2010-09-05', NULL ),
('8','203', '2010-09-05', NULL ),
('2','226', '2010-09-05', NULL ),
('4','226', '2010-09-05', NULL ),
('8','226', '2010-09-05', NULL );

INSERT INTO accountLink (name, debitAccountId, creditAccountId,dateCreated,dateUpdated) VALUES
('rentRevenue', 2, 1, '2010-09-05', null),
('rentDiscount', 3, 2, '2010-09-05', null),
('leaseCancellationRentPortion', 1, 1, '2010-09-05', null),
('leaseCancellationDiscountPortion', 2, 4, '2010-09-05', null),
('paidRent',5,2, '2010-09-05', null);