CREATE TABLE `fin_authorizacion_inscrito` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`inscripcion_id` INT NOT NULL,
	`author_usuario_id` INT(10) UNSIGNED NOT NULL,
	`tipo_id` INT NOT NULL,
	`comentario` VARCHAR(255) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`),
	INDEX (`inscripcion_id`),
	INDEX (`usuario_id`),
	INDEX (`tipo_id`)
) ENGINE = InnoDB;

CREATE TABLE `fin_tipo_authorizacion` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50) NOT NULL,
	`descripcion` VARCHAR(150) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX (`nombre`),
	INDEX (`descripcion`)
) ENGINE = InnoDB;


ALTER TABLE `fin_authorizacion_inscrito`
  ADD CONSTRAINT `fk_fin_authorizacion_inscrito_inscripcion_id` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion` (`id_inscripcion`),
  ADD CONSTRAINT `fk_fin_tipo_authorizacion_author_usuario_id` FOREIGN KEY (`author_usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_fin_tipo_authorizacion_tipo_id` FOREIGN KEY (`tipo_id`) REFERENCES `fin_tipo_authorizacion` (`id`);
  
INSERT INTO `fin_tipo_authorizacion` (`id`, `nombre`, `descripcion`) VALUES (NULL, 'os/carta', 'orden de servicio o carta'), (NULL, 'fraccionamiento', 'fraccionamiento')
