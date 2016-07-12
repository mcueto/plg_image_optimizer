CREATE TABLE IF NOT EXISTS `#__imageoptimizer` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`link` text NOT NULL,
  `config` text NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- INSERT INTO `#__imageoptimizer` (`http://`, `lang`) VALUES ('Hello World', 'en-GB');
