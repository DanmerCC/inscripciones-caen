-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2019 a las 08:20:41
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11


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
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) NOT NULL,
  `hash_create` varchar(32) NOT NULL
) ENGINE=InnoDB CHARACTER SET utf8;


ALTER TABLE `hash_request`
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `hash_request`
  ADD CONSTRAINT `hash_request_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;
