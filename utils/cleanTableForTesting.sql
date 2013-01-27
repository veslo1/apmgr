DELIMITER $$

DROP PROCEDURE IF EXISTS `cleanTableForTesting`$$
CREATE PROCEDURE `cleanTableForTesting` ()
BEGIN
	DELETE FROM account;
    DELETE FROM accountLink;
    DELETE FROM accountTransaction;
	DELETE FROM amenity;
	DELETE FROM apartment;
	DELETE FROM applicant;
        DELETE FROM applicantPreleaseFeeBill;
	DELETE FROM applicantStatus;
	DELETE FROM bill;
        DELETE FROM fee;
    DELETE FROM lease;
    DELETE FROM leaseFee;
    DELETE FROM leaseSchedule;
    DELETE FROM modelRentSchedule;
    DELETE FROM modelRentScheduleItem;
    DELETE FROM paymentDetail;
    DELETE FROM transaction;
	DELETE FROM user;
	DELETE FROM userWaitlist;
	DELETE FROM unit;
	DELETE FROM file;
	DELETE FROM unitFile;
	DELETE FROM unitModel;
	DELETE FROM unitModelAmenity;
	DELETE FROM fee;
    DELETE FROM maintenanceRequest;
    DELETE FROM maintenanceRequestAssignedStatus;
    DELETE FROM maintenanceRequestComment;
    DELETE FROM maintenanceStatus;
    DELETE FROM reports;
    DELETE FROM recover;    
	DELETE FROM modules WHERE id=20;
	DELETE FROM controllers WHERE id=20;
	DELETE FROM actions WHERE id=200;
END$$

DELIMITER ;
