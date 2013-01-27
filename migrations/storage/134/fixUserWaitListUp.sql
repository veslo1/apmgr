TRUNCATE TABLE userWaitlist;
ALTER TABLE `userWaitlist`
ADD CONSTRAINT `userWaitList_ibfk_2` FOREIGN KEY ( `userId` ) REFERENCES `apmgr`.`user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;