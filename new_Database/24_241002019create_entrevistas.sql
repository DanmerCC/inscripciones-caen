CREATE TABLE `caenedup_caen2`.`intvw_state_programmed_interviews` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50) NOT NULL,
	`descripcion` VARCHAR(150) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
	`intvw_state_programmed_interviews` (`id`, `nombre`, `descripcion`)
VALUES
	(1, 'pendiente', 'estado por defecto'),
	(2,'realizada','se marca al empezar la entrevista') 
	
	
CREATE TABLE `caenedup_caen2`.`intvw_programmed_interviews` (
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

ALTER TABLE `intvw_programmed_interviews`
  ADD CONSTRAINT `fk_intvw_programmed_interviews_alumno_id` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `fk_intvw_programmed_interviews_inscripcion_id` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion` (`id_inscripcion`),
  ADD CONSTRAINT `fk_intvw_programmed_interviews_estado_id` FOREIGN KEY (`estado_id`) REFERENCES `intvw_state_programmed_interviews` (`id`);
