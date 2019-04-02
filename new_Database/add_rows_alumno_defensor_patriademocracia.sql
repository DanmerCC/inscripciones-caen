ALTER TABLE `alumno` ADD `def_patria` BOOLEAN NOT NULL DEFAULT FALSE AFTER `espec_discapacidad`;
ALTER TABLE `alumno` ADD `def_democracia` BOOLEAN NOT NULL DEFAULT FALSE AFTER `def_patria`