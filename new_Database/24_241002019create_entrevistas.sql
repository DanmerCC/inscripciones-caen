CREATE TABLE `intvw_state_programmed_interviews` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50) NOT NULL,
	`descripcion` VARCHAR(150) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
	`intvw_state_programmed_interviews` (`id`, `nombre`, `descripcion`)
VALUES
	(1, 'pendiente', 'estado por defecto'),
	(2,'realizada','se marca al empezar la entrevista');
	
	
CREATE TABLE `intvw_programmed_interviews` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`alumno_id` INT NOT NULL,
	`inscripcion_id` INT NOT NULL,
	`estado_id` INT NOT NULL,
	`fecha_programado` DATETIME NOT NULL,
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`alumno_id`),
	INDEX (`inscripcion_id`),
	INDEX (`estado_id`)
) ENGINE = InnoDB;

ALTER TABLE `intvw_programmed_interviews` ADD UNIQUE(`inscripcion_id`);

ALTER TABLE `intvw_programmed_interviews`
  ADD CONSTRAINT `fk_intvw_programmed_interviews_alumno_id` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `fk_intvw_programmed_interviews_inscripcion_id` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion` (`id_inscripcion`),
  ADD CONSTRAINT `fk_intvw_programmed_interviews_estado_id` FOREIGN KEY (`estado_id`) REFERENCES `intvw_state_programmed_interviews` (`id`);

ALTER TABLE `inscripcion`  ADD `state_interview_id` INT NULL DEFAULT NULL  AFTER `estado_admision_id`;
ALTER TABLE `inscripcion` ADD INDEX(`state_interview_id`);

ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_state_interview_id` FOREIGN KEY (`state_interview_id`) REFERENCES `intvw_state_programmed_interviews` (`id`);

INSERT INTO `permiso` (`idPermiso`, `url`) VALUES ('9', 'entrevistas');

CREATE TABLE `adms_evaluaciones` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`inscripcion_id` INT NOT NULL,
	`alumno_id` INT NOT NULL,
	`programa_id` INT NOT NULL,
	`doc_adjunto` VARCHAR(255) NOT NULL,
	`created_user_id` INT NOT NULL,
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modificated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	INDEX (`inscripcion_id`),
	INDEX (`alumno_id`),
	INDEX (`programa_id`),
	INDEX (`created_user_id`)
) ENGINE = InnoDB;
