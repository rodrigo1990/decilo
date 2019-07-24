-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2018 a las 14:57:28
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `decilo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumna`
--

CREATE TABLE `alumna` (
  `id_alumna` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha_ingreso` varchar(50) NOT NULL,
  `fecha_nacimiento` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `actividad` varchar(100) NOT NULL,
  `id_sede` int(11) NOT NULL,
  `aclaraciones` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota_alumna`
--

CREATE TABLE `cuota_alumna` (
  `id_cuota` int(11) NOT NULL,
  `id_alumna` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `fecha_pago` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `grupo` varchar(200) NOT NULL,
  `id_sede` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `grupo`, `id_sede`) VALUES
(1, 'Acro y Tela', 1),
(2, 'Acrobacia', 1),
(3, 'Banda Ancha', 1),
(4, 'CDB', 1),
(5, 'Circo', 1),
(6, 'Delayers', 1),
(7, 'Estilos', 1),
(8, 'Fruit', 1),
(9, 'Funcional', 1),
(10, 'Garrafa', 1),
(11, 'Grooverdura', 1),
(12, 'House', 1),
(13, 'Indios', 1),
(14, 'Iniciación', 1),
(15, 'Jalea', 1),
(16, 'Marmolado', 1),
(17, 'Pebetas', 1),
(18, 'Peques', 1),
(19, 'Rafiki 1', 1),
(20, 'Rafiki 2', 1),
(21, 'Revolution', 1),
(22, 'Rubik', 1),
(23, 'Tap', 1),
(24, 'Tela', 1),
(25, 'Union', 1),
(26, 'Viejis', 1),
(27, 'Vitamix', 1),
(28, 'Yolo', 1),
(29, 'Burger Queens', 2),
(30, 'Hip Hop', 2),
(31, 'House', 2),
(32, 'Minis', 2),
(33, 'Riverhood', 2),
(34, 'Street', 2),
(35, 'Strudel Ju', 2),
(36, 'Strudel Ma', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `id_sede` int(11) NOT NULL,
  `sede` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`id_sede`, `sede`) VALUES
(1, 'ALTA CASA'),
(2, 'CASA RIO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumna`
--
ALTER TABLE `alumna`
  ADD PRIMARY KEY (`id_alumna`);

--
-- Indices de la tabla `cuota_alumna`
--
ALTER TABLE `cuota_alumna`
  ADD PRIMARY KEY (`id_cuota`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`id_sede`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumna`
--
ALTER TABLE `alumna`
  MODIFY `id_alumna` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuota_alumna`
--
ALTER TABLE `cuota_alumna`
  MODIFY `id_cuota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `id_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
