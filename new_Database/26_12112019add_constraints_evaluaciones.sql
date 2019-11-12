ALTER TABLE `adms_evaluaciones` CHANGE `created_user_id` `created_user_id` INT(10) UNSIGNED NOT NULL;

ALTER TABLE `adms_evaluaciones`
  ADD CONSTRAINT `fk_inscripcion_id_adms_evaluaciones` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion` (`id_inscripcion`),
  ADD CONSTRAINT `fk_alumno_id_adms_evaluaciones` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `fk_programa_id_adms_evaluaciones` FOREIGN KEY (`programa_id`) REFERENCES `curso` (`id_curso`),
  ADD CONSTRAINT `fk_created_user_id_adms_evaluaciones` FOREIGN KEY (`created_user_id`) REFERENCES `usuario` (`id`);
