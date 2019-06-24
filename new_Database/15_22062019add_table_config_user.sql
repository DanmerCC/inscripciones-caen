CREATE TABLE `config_perfil_user` (
  `id_config_perfil_user` int(11) NOT NULL,
  `acordion_default_name` varchar(25) NOT NULL,
  `usuario_id` int(10) NOT NULL
)
ALTER TABLE `config_perfil_user` ADD PRIMARY KEY(`id_config_perfil_user`);

ALTER TABLE `config_perfil_user` ADD INDEX(`usuario_id`);
ALTER TABLE `config_perfil_user` CHANGE `usuario_id` `usuario_id` INT(10) UNSIGNED NOT NULL;
ALTER TABLE `config_perfil_user` CHANGE `id_config_perfil_user` `id_config_perfil_user` INT(11) NOT NULL AUTO_INCREMENT;

--
ALTER TABLE `config_perfil_user`
  ADD CONSTRAINT `config_perfil_user_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
