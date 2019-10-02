CREATE TABLE `caenedup_caen2`.`estado_finanzas` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `nombre` VARCHAR(150) NOT NULL ,
       PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `inscripcion` ADD `estado_finanzas_id` INT NOT NULL DEFAULT '1' AFTER `created_user_id`; INSERT INTO `estado_finanzas` (`id`, `nombre`) VALUES (NULL, 'sin revision');
