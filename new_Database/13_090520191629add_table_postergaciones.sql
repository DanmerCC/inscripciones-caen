CREATE TABLE `postergacion_curso` (
  `id_postergacon` int(11) NOT NULL,
  `desde` date NOT NULL,
  `nuevo_inicio` date NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `comentario` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `curso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `postergacion_curso`
  ADD PRIMARY KEY (`id_postergacon`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `curso_id` (`curso_id`);

ALTER TABLE `postergacion_curso`
  MODIFY `id_postergacon` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `postergacion_curso`
  ADD CONSTRAINT `postergacion_curso_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id_curso`),
  ADD CONSTRAINT `postergacion_curso_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `usuario` (`id`);
COMMIT;