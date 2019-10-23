CREATE TABLE `estado_admisions` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50)NOT NULL,
	`descripcion` VARCHAR(150) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `estado_admisions` (`id`, `nombre`, `descripcion`) VALUES (1, 'pendiente', 'estado por defecto');
INSERT INTO `estado_admisions` (`id`, `nombre`, `descripcion`) VALUES (2, 'admitido', 'se registro una admision');

ALTER TABLE `inscripcion` ADD `estado_admision_id` INT NOT NULL DEFAULT '1' AFTER `estado_finanzas_id`, ADD INDEX (`estado_admision_id`);

ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_estado_admisions` FOREIGN KEY (`estado_admision_id`) REFERENCES `estado_admisions` (`id`);
