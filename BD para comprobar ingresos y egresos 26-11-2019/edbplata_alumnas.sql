-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2019 a las 22:14:54
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `edbplata_alumnas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `pass` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `pass`) VALUES
(1, 'admin@deciloalumnas.com', '0953f0b39da8165aafc1e6bbd7616837'),
(2, 'mcd77.1990@gmail.com', 'ad98ebfac3fafaca8e31af71395c6544'),
(3, 'andrea@legioncreativa.com', 'fd8505b2cbf179d6441fc4278d49e1d5');

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
  `colegio` varchar(200) NOT NULL,
  `actividad` varchar(100) NOT NULL,
  `id_sede` int(11) NOT NULL,
  `aclaraciones` varchar(500) NOT NULL,
  `eliminada` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alumna`
--

INSERT INTO `alumna` (`id_alumna`, `nombre`, `fecha_ingreso`, `fecha_nacimiento`, `mail`, `celular`, `colegio`, `actividad`, `id_sede`, `aclaraciones`, `eliminada`) VALUES
(1, 'tini barcelo', '1524700800', '', 'tinibarcelo@gmail.com', '', '', '', 0, '', 0),
(2, 'cata fitero', '1524700800', '890179200', '', '', '', '', 0, '', 0),
(3, '', '', '', '', '', '', '', 0, '', 0),
(4, 'Sere Manzuoli', '1526256000', '890179200', 'seremanzuoli@hotmail.com', '', '', '', 0, '', 0),
(5, 'Emilia Gallo', '1526256000', '', 'egallo133@gmail.com', '1150169757 Miriam (M', '', '', 0, '47232039 (Casa)', 0),
(809, 'RODRIGO REYNOSO', '1563832800', '656290800', 'mcd77.1990@gmail.com', '1156459240', '', '', 0, 'asdasd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `id_concepto` int(11) NOT NULL,
  `concepto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`id_concepto`, `concepto`) VALUES
(0, 'No indicado'),
(1, 'Cuota'),
(2, 'Matricula'),
(3, 'Clase Prueba'),
(4, 'Devolución');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota_alumna`
--

CREATE TABLE `cuota_alumna` (
  `id_cuota` int(11) NOT NULL,
  `id_alumna` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `fecha_pago` varchar(200) DEFAULT NULL,
  `eliminada` int(11) NOT NULL,
  `adeuda` tinyint(4) NOT NULL,
  `esta_paga` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuota_alumna`
--

INSERT INTO `cuota_alumna` (`id_cuota`, `id_alumna`, `mes`, `anio`, `monto`, `id_concepto`, `id_grupo`, `fecha_pago`, `eliminada`, `adeuda`, `esta_paga`) VALUES
(854, 809, 7, 2019, '555.00', 2, 1, '2019-07-29', 1, 0, 1),
(855, 809, 7, 2019, '555.00', 3, 1, '2019-07-29', 1, 0, 1),
(856, 809, 7, 2019, '3333.00', 1, 1, '2019-07-29', 1, 0, 1),
(857, 809, 8, 2019, '444.00', 1, 1, '2019-07-29', 1, 0, 1),
(858, 809, 9, 2019, '0.00', 1, 1, NULL, 1, 0, 1),
(859, 809, 10, 2019, '0.00', 1, 1, NULL, 1, 0, 1),
(860, 809, 11, 2019, '0.00', 1, 1, NULL, 1, 0, 1),
(861, 809, 12, 2019, '0.00', 1, 1, NULL, 1, 0, 1),
(862, 809, 1, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(863, 809, 2, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(864, 809, 3, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(865, 809, 4, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(866, 809, 5, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(867, 809, 6, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(868, 809, 7, 2020, '0.00', 1, 1, NULL, 1, 0, 1),
(869, 2, 7, 2019, '3333.00', 2, 5, '2019-07-29', 0, 0, 1),
(870, 2, 7, 2019, '5555.00', 3, 5, '2019-07-29', 0, 0, 1),
(871, 4, 7, 2019, '5555.00', 2, 5, '2019-07-29', 0, 0, 1),
(872, 4, 7, 2019, '555.00', 3, 5, '2019-07-29', 0, 0, 1),
(873, 4, 7, 2019, '5555.00', 3, 5, '2019-07-29', 0, 0, 1),
(874, 4, 7, 2019, '333.00', 1, 5, '2019-07-29', 0, 0, 1),
(875, 4, 8, 2019, '4444.00', 1, 5, '2019-07-29', 0, 0, 1),
(876, 4, 9, 2019, '333.00', 1, 5, '2019-07-29', 0, 0, 1),
(877, 4, 10, 2019, '0.00', 1, 5, NULL, 0, 1, 0),
(878, 4, 11, 2019, '0.00', 1, 5, NULL, 0, 0, 0),
(879, 4, 12, 2019, '0.00', 1, 5, NULL, 0, 0, 0),
(880, 4, 1, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(881, 4, 2, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(882, 4, 3, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(883, 4, 4, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(884, 4, 5, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(885, 4, 6, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(886, 4, 7, 2020, '0.00', 1, 5, NULL, 0, 0, 0),
(887, 4, 7, 2019, '0.00', 2, 5, NULL, 0, 1, 0);

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
(0, 'NO ASIGNADO', 0),
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
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id` int(11) NOT NULL,
  `id_alumna` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `eliminada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id`, `id_alumna`, `id_grupo`, `eliminada`) VALUES
(34, 809, 1, 1),
(35, 2, 5, 0),
(36, 4, 5, 0);

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
(0, 'NO ASIGNADO'),
(1, 'ALTA CASA'),
(2, 'CASA RIO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alumna`
--
ALTER TABLE `alumna`
  ADD PRIMARY KEY (`id_alumna`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`id_concepto`);

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
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`id_sede`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `alumna`
--
ALTER TABLE `alumna`
  MODIFY `id_alumna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=810;

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `id_concepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cuota_alumna`
--
ALTER TABLE `cuota_alumna`
  MODIFY `id_cuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=888;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `id_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
