DROP TABLE IF EXISTS `userDeactivations`;
CREATE TABLE IF NOT EXISTS `userDeactivations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL COMMENT 'The user that is disabled/enabled',
  `author` int(11) NOT NULL COMMENT 'The person that performs this task',
  `description` text NOT NULL COMMENT 'The motive why the user was enabled/disabled',
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userDeactivations`
--
ALTER TABLE `userDeactivations`
  ADD CONSTRAINT `userdeactivations_ibfk_2` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userdeactivations_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
