ALTER TABLE `alumno`
ADD COLUMN `cod_student_admin` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `cod_alumno_increment`,
ADD UNIQUE INDEX `cod_student_admin_unique` (`cod_student_admin`);

INSERT INTO `auth_rol` (`nombre`) VALUES ('adminstrador_sistema');
INSERT INTO `auth_permisos` (`nombre`) VALUES ('has_create_cod_alumno');
