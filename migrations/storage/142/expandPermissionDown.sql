/* Scanner was truncating so expanding column size - ignore needed so it won't bitch on downgrade about truncated data*/
ALTER IGNORE TABLE `permission` CHANGE `alias` `alias` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; 