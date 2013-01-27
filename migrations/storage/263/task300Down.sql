DROP TABLE IF EXISTS `prospectsUnitIdAnswers`;
ALTER TABLE  `prospects` ENGINE = MyISAM;
ALTER TABLE `prospects` ADD `modelType` int(11) NOT NULL;