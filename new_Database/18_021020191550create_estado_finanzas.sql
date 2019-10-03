
CREATE TABLE `caenedup_caen2`.`estado_finanzas` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `nombre` VARCHAR(150) NOT NULL ,
       PRIMARY KEY (`id`)) ENGINE = InnoDB;


INSERT 
  INTO `estado_finanzas` (`id`,
       `nombre`) 
VALUES (NULL, 'sin revision');



ALTER TABLE `inscripcion` ADD `estado_finanzas_id` INT NOT NULL DEFAULT '1' AFTER `created_user_id`;

ALTER TABLE `inscripcion`
  ADD CONSTRAINT `estado_finanzas_id` FOREIGN KEY (`estado_finanzas_id`) REFERENCES `estado_finanzas` (`id`)

