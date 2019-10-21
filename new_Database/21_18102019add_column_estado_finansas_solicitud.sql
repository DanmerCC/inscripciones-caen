CREATE TABLE `estado_finanzas_solicitud` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `nombre` VARCHAR(150) NOT NULL ,
       PRIMARY KEY (`id`)) ENGINE = InnoDB;


INSERT 
  INTO `estado_finanzas_solicitud` (`id`,
       `nombre`) 
VALUES (NULL, 'sin revision'),(NULL, 'validado'),(NULL, 'observado');



ALTER TABLE `solicitud` ADD `estado_finanzas_id` INT NOT NULL DEFAULT '1' AFTER `tipo_financiamiento`;

ALTER TABLE `solicitud`
  ADD CONSTRAINT `estado_finanzas_id` FOREIGN KEY (`estado_finanzas_id`) REFERENCES `estado_finanzas_solicitud` (`id`);


CREATE TABLE `fin_observaciones_solicitud` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comentario` VARCHAR(255) NOT NULL DEFAULT '',
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  `solicitud_id` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `fin_observaciones_solicitud` ADD INDEX(`solicitud_id`);

ALTER TABLE `fin_observaciones_solicitud`
  ADD CONSTRAINT `fk_fin_observaciones_solicitud_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_fin_observaciones_solicitud_id` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`idSolicitud`);


INSERT INTO `auth_permisos` (`id`, `nombre`) VALUES (2, 'change_solicitud_estado_finanzas');
