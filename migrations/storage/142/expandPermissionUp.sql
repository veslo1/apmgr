/* Scanner was truncating so expanding column size */
ALTER TABLE `permission` CHANGE `alias` `alias` VARCHAR( 90 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; 