/* Feature 223*/
CREATE TABLE `applicantPreleaseFeeBill` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `applicantId` int(11) NOT NULL,
 `feeId` int(10) unsigned NOT NULL,
 `billId` int(10) unsigned NOT NULL,
 `amount` decimal(10,2) NOT NULL,
 `dateCreated` datetime NOT NULL,
 `dateUpdated` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `applicantId` (`applicantId`),
 KEY `feeId` (`feeId`),
 KEY `billId` (`billId`),
 CONSTRAINT `applicantpreleasefeebill_ibfk_1` FOREIGN KEY (`feeId`) REFERENCES `fee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `applicantpreleasefeebill_ibfk_2` FOREIGN KEY (`billId`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `applicantpreleasefeebill_ibfk_3` FOREIGN KEY (`applicantId`) REFERENCES `applicant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='applicant fees post application';