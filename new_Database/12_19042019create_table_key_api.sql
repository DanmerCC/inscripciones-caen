CREATE TABLE `keys` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`key` VARCHAR(40) NOT NULL,
	`level` INT(2) NOT NULL,
	`ignore_limits` TINYINT(1) NOT NULL DEFAULT '0',
	`date_created` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
