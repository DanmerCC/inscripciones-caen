CREATE TABLE `auth_rol` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `nombre` VARCHAR(100) NOT NULL ,
       PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `auth_permisos` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `nombre` VARCHAR(100) NOT NULL ,
       PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `auth_roles_permisos` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `auth_roles_id` INT NOT NULL ,
       `auth_permisos_id` INT NOT NULL ,
       PRIMARY KEY (`id`),
       INDEX `auth_roles_id` (`auth_roles_id`),
       INDEX `auth_permisos_id` (`auth_permisos_id`)) ENGINE = InnoDB;

CREATE TABLE `auth_roles_users` ( `id` INT NOT NULL AUTO_INCREMENT ,
       `auth_roles_id` INT NOT NULL ,
       `users_id` INT(10) UNSIGNED NOT NULL ,
       PRIMARY KEY (`id`),
       INDEX `users_id` (`users_id`),
       INDEX `auth_roles_id` (`auth_roles_id`)) ENGINE = InnoDB;


ALTER TABLE `auth_roles_permisos`
  ADD CONSTRAINT `fk_auth_roles_permisos_auth_roles_id` FOREIGN KEY (`auth_roles_id`) REFERENCES `auth_rol` (`id`),
  ADD CONSTRAINT `fk_auth_roles_permisos_auth_permisos_id` FOREIGN KEY (`auth_permisos_id`) REFERENCES `auth_permisos` (`id`);
  
ALTER TABLE `auth_roles_users`
  ADD CONSTRAINT `fk_auth_roles_users_auth_roles_id` FOREIGN KEY (`auth_roles_id`) REFERENCES `auth_rol` (`id`),
  ADD CONSTRAINT `fk_auth_roles_users_users_id` FOREIGN KEY (`users_id`) REFERENCES `usuario` (`id`);



INSERT INTO `auth_permisos` (`id`, `nombre`) VALUES (NULL, 'change_inscripcion_estado_finanzas');
