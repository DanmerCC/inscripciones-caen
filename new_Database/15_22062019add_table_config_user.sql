-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2019 at 11:40 AM
-- Server version: 5.6.44
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caenedup_caen2_pruebas`
--

-- --------------------------------------------------------

--
-- Table structure for table `config_perfil_user`
--

CREATE TABLE `config_perfil_user` (
  `id_config_perfil_user` int(11) NOT NULL,
  `acordion_default_name` varchar(25) NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB;

--
-- Dumping data for table `config_perfil_user`
--

INSERT INTO `config_perfil_user` (`id_config_perfil_user`, `acordion_default_name`, `usuario_id`) VALUES
(1, 'second_acordion', 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config_perfil_user`
--
ALTER TABLE `config_perfil_user`
  ADD PRIMARY KEY (`id_config_perfil_user`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config_perfil_user`
--
ALTER TABLE `config_perfil_user`
  MODIFY `id_config_perfil_user` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
