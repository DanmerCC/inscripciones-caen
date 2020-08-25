ALTER TABLE `alumno`
ADD COLUMN `cod_alumno_increment` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `def_democracia`,
ADD COLUMN `cod_alumno_sign` VARCHAR(50) NULL DEFAULT NULL AFTER `cod_alumno_increment`,
ADD INDEX `cod_alumno_increment_key` (`cod_alumno_increment`),
ADD UNIQUE INDEX `cod_alumno_increment_unique` (`cod_alumno_increment`);

ALTER TABLE `alumno` ADD COLUMN `cod_alumno_created` DATETIME NULL DEFAULT NULL AFTER `def_democracia`;
