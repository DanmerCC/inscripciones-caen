DROP TABLE IF EXISTS `acta_admision`;
CREATE TABLE `acta_admision` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`filename` VARCHAR(100) NOT NULL ,
	`uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=latin1;


DROP TABLE IF EXISTS `admisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admisions` (
 `id` INT(11) NOT NULL AUTO_INCREMENT,
 `alumno_id` INT(11) NOT NULL,
 `inscription_id` INT(11) NOT NULL,
 `posgrade_id` INT(11) NOT NULL,
 `acta_id` INT(11) NOT NULL,
 `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `modificated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
 KEY `alumno_id` (`alumno_id`),
 KEY `inscription_id` (`inscription_id`),
 KEY `posgrade_id` (`posgrade_id`),
 CONSTRAINT `fk_admisions_alumno_alumno_id` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`),
 CONSTRAINT `fk_admisions_inscripcion_id_inscripcion` FOREIGN KEY (`inscription_id`) REFERENCES `inscripcion` (`id_inscripcion`),
 CONSTRAINT `fk_admisions_curso_id_curso` FOREIGN KEY (`posgrade_id`) REFERENCES `curso` (`id_curso`),
 CONSTRAINT `fk_admisions_curso_acta_id` FOREIGN KEY (`acta_id`) REFERENCES `acta_admision` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


INSERT INTO `caenedup_caen2`.`auth_permisos` (`nombre`) VALUES ('add_acta_admision');
INSERT INTO `caenedup_caen2`.`auth_permisos` (`nombre`) VALUES ('add_admisions_alumnos');
