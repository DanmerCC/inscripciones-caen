-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-03-2019 a las 20:30:04
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `caenedup_caen2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hash_request`
--

CREATE TABLE `hash_request` (
  `id` int(11) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) NOT NULL,
  `hash_create` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `hash_request`
--

INSERT INTO `hash_request` (`id`, `id_usuario`, `time_stamp`, `state`, `hash_create`) VALUES
(2, 49, '2019-03-28 16:07:05', 0, ''),
(4, 49, '2019-03-28 16:13:20', 0, ''),
(5, 49, '2019-03-28 19:15:42', 0, ''),
(6, 49, '2019-03-28 19:17:15', 0, ''),
(7, 49, '2019-03-28 19:19:27', 0, ''),
(8, 49, '2019-03-28 19:20:26', 0, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hash_request`
--
ALTER TABLE `hash_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_usuario_2` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hash_request`
--
ALTER TABLE `hash_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hash_request`
--
ALTER TABLE `hash_request`
  ADD CONSTRAINT `id` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
