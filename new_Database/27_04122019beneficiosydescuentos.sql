CREATE TABLE `discounts` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`description` VARCHAR(250) NOT NULL,
	`name` VARCHAR(25) NOT NULL,
	`percentage` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `requirements` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(25) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `cursos_discounts` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`curso_id` INT NOT NULL,
	`discount_id` INT NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`curso_id`),
	INDEX (`discount_id`)
) ENGINE = InnoDB;

CREATE TABLE `discount_requirement` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`requirement_id` INT NOT NULL,
	`discount_id` INT NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`requirement_id`),
	INDEX (`discount_id`)
) ENGINE = InnoDB;

CREATE TABLE `solicitud_requirement` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`requirement_id` INT NOT NULL,
	`solicitud_id` INT NOT NULL,
	`discount_id` INT NOT NULL,
	`file` VARCHAR(250) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`requirement_id`),
	INDEX (`solicitud_id`),
	INDEX (`discount_id`)
) ENGINE = InnoDB;

CREATE TABLE `solicitud_discount` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`solicitud_id` INT NOT NULL,
	`discount_id` INT NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`solicitud_id`),
	INDEX (`discount_id`)
) ENGINE = InnoDB;


ALTER TABLE `cursos_discounts`
  ADD CONSTRAINT `fk_cursos_discounts_curso_id` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id_curso`),
  ADD CONSTRAINT `fk_cursos_discounts_discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`);

ALTER TABLE `discount_requirement`
  ADD CONSTRAINT `fk_discount_requirement_requirement_id` FOREIGN KEY (`requirement_id`) REFERENCES `requirements` (`id`),
  ADD CONSTRAINT `fk_discount_requirement_discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`);

ALTER TABLE `solicitud_requirement`
  ADD CONSTRAINT `fk_solicitud_requirement_requirement_id` FOREIGN KEY (`requirement_id`) REFERENCES `requirements` (`id`),
  ADD CONSTRAINT `fk_solicitud_requirement_solicitud_id` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`idSolicitud`),
ADD CONSTRAINT `fk_solicitud_requirement_discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`);

ALTER TABLE `solicitud_discount`
  ADD CONSTRAINT `fk_solicitud_solicitud_discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `fk_solicitud_discount_solicitud_id` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`idSolicitud`);

INSERT INTO permiso(`idPermiso`,`url`) VALUES(11,'discounts');
INSERT INTO permiso(`idPermiso`,`url`) VALUES(12,'requirements');


/*
ALTER TABLE `solicitud_requirement` ADD `discount_id` INT NOT NULL AFTER `file`, ADD INDEX (`discount_id`);
ALTER TABLE `solicitud_requirement`
	ADD CONSTRAINT `fk_solicitud_requirement_discount_id` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`);
*/
