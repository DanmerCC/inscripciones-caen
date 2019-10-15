CREATE TABLE `fin_observaciones` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comentario` VARCHAR(255) NOT NULL DEFAULT '',
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  `inscripcion_id` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `fin_observaciones` ADD INDEX(`inscripcion_id`);

ALTER TABLE `fin_observaciones`
  ADD CONSTRAINT `fk_fin_observaciones_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_fin_observaciones_inscripcion_id` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion` (`id_inscripcion`);
  