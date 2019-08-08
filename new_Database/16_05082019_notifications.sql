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

/**SE crean las acciones principales*/
INSERT INTO `action` (`id`, `nombre`) VALUES (1, 'CV cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (2, 'DJ cargada');
INSERT INTO `action` (`id`, `nombre`) VALUES (3, 'DNI cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (4, 'bachiller cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (5, 'maestria cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (6, 'doctorado cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (7, 'solicitud cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (8, 'proyecto de investigacion cargado');
INSERT INTO `action` (`id`, `nombre`) VALUES (9, 'hoja de datos cargado');

CREATE TABLE `caenedup_caen2`.`notification_configs` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`usuario_id` INT(10) UNSIGNED NOT NULL,
	`init_watch` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	INDEX (`usuario_id`)
) ENGINE = InnoDB;

ALTER TABLE `solicitud`
 ADD `notification_mensaje` 
 VARCHAR(50) NULL DEFAULT '' AFTER `check_hdatos`;

CREATE TABLE `notifications_solicituds` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `notifications_id` int(11) NOT NULL
) ENGINE=InnoDB;


--
-- Filtros para la tabla `notifications_solicituds`
--
ALTER TABLE `notifications_solicituds`
  ADD CONSTRAINT `notifications_solicituds_ibfk_1` FOREIGN KEY (`notifications_id`) REFERENCES `notifications` (`id`),
  ADD CONSTRAINT `notifications_solicituds_ibfk_2` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`idSolicitud`);


--
-- Filtros para la tabla `read_notifications`
--
ALTER TABLE `read_notifications`
  ADD CONSTRAINT `read_notifications_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`);



--
-- Filtros para la tabla `notification_configs`
--
ALTER TABLE `notification_configs`
  ADD CONSTRAINT `notification_configs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);


--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipousuario` (`id`);
