CREATE TABLE `caenedup_caen2`.`notifications` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`tipo_usuario_id` INT NOT NULL,
	`action_id` INT NOT NULL,
	`time` TIMESTAMP NOT NULL,
	`mensaje` VARCHAR(500) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE = InnoDB;

ALTER TABLE `notifications` ADD INDEX(`tipo_usuario_id`);
ALTER TABLE `notifications` ADD INDEX(`action_id`);

CREATE TABLE `caenedup_caen2`.`read_notifications` (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`usuario_id` INT(10) UNSIGNED NOT NULL ,
	`notification_id` INT NOT NULL ,
	PRIMARY KEY (`id`), INDEX (`usuario_id`),
	INDEX (`notification_id`)
) ENGINE = InnoDB;

CREATE TABLE `caenedup_caen2`.`action` (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`nombre` VARCHAR(50) NOT NULL ,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;


CREATE TABLE `caenedup_caen2`.`notification_configs` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`usuario_id` INT(10) UNSIGNED NOT NULL,
	`init_watch` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	INDEX (`usuario_id`)
) ENGINE = InnoDB;
