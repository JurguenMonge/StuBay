-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-09-2023 a las 02:25:07
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdstubay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbarticulo`
--

CREATE TABLE `tbarticulo` (
  `tbarticuloid` int(11) NOT NULL,
  `tbarticulonombre` varchar(255) NOT NULL,
  `tbarticulomarca` varchar(255) NOT NULL,
  `tbarticulomodelo` varchar(255) NOT NULL,
  `tbarticuloserie` varchar(255) NOT NULL,
  `tbarticuloactivo` tinyint(4) NOT NULL,
  `tbsubcategoriaid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbarticulo`
--

INSERT INTO `tbarticulo` (`tbarticuloid`, `tbarticulonombre`, `tbarticulomarca`, `tbarticulomodelo`, `tbarticuloserie`, `tbarticuloactivo`, `tbsubcategoriaid`) VALUES
(1, 'lAPTOP', 'HP', 'OMEN', '', 0, ''),
(1, 'lAPTOP', 'HP', 'OMEN', '', 0, ''),
(1, 'lAPTOP', 'HP', 'OMEN', '', 0, ''),
(1, 'lAPTOP', 'HP', 'OMEN', '', 0, ''),
(2, 'Parlantes', 'Redragon', 'as23', '', 0, '13'),
(3, 'Computadora', 'MSI', '', '', 0, ''),
(4, 'Monitor', 'MSI', 'G523', '', 1, '14'),
(5, 'Microfono', 'HyperX', 'Solocast', '', 1, '14'),
(6, 'Teclado', 'HyperX', 'Galaxy', '', 1, '21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategoria`
--

CREATE TABLE `tbcategoria` (
  `tbcategoriaid` int(11) NOT NULL,
  `tbcategoriasigla` varchar(4) NOT NULL,
  `tbcategorianombre` varchar(30) NOT NULL,
  `tbcategoriadescripcion` varchar(1000) NOT NULL,
  `tbcategoriaactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbcategoria`
--

INSERT INTO `tbcategoria` (`tbcategoriaid`, `tbcategoriasigla`, `tbcategorianombre`, `tbcategoriadescripcion`, `tbcategoriaactivo`) VALUES
(1, '1', 'Tecnologico', 'Variado', 1),
(2, '2', 'Muebles', 'Para computadoras', 1),
(3, '3', 'Ferretería', 'Variado', 1),
(4, '4', 'fdsfs', 'fs', 0),
(5, '5', 'hdg', 'gdf', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcliente`
--

CREATE TABLE `tbcliente` (
  `tbclienteid` int(11) NOT NULL,
  `tbclientenombre` varchar(30) NOT NULL,
  `tbclienteprimerapellido` varchar(30) NOT NULL,
  `tbclientesegundoapellido` varchar(30) NOT NULL,
  `tbclientecorreo` varchar(50) NOT NULL,
  `tbclientepassword` varchar(100) NOT NULL,
  `tbclientefechaingreso` date NOT NULL,
  `tbclienteactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcliente`
--

INSERT INTO `tbcliente` (`tbclienteid`, `tbclientenombre`, `tbclienteprimerapellido`, `tbclientesegundoapellido`, `tbclientecorreo`, `tbclientepassword`, `tbclientefechaingreso`, `tbclienteactivo`) VALUES
(1, 'Giancarlo', 'Arias', 'Paisano', 'arias@gmail.com', '$2y$10$vfvQtoT2RQDnrOz142bqV.vfwd4PAheX/oBZrRA65wBtMvlk2St2i', '2023-08-14', 1),
(2, 'Jurguen', 'Monge', 'Rojas', 'jur.monge@gmail.com', '$2y$10$T2ij5M5Hf1rif/bCd5OzmuN/3dy7eKLASO1YJHQe1IomPf.V.4AUa', '2023-08-02', 1),
(3, 'Juan', 'Dolmus', 'Corea', 'jb.dolmus@gmail.com', '$2y$10$T5hIiRDHdUZ/Iq8ZbVfrL.fLJLsIJcRRBzeLjy5I9EA8bpPeOUlwC', '2023-08-26', 1),
(4, 'Dylan', 'Gome', 'Sanches', 'gdfg@gmail.com', '$2y$10$8PXYm5oLYwUEgQmc/iIsveDc5Pt1Run8AOHOvylbHZj2jaUtes6JC', '2023-09-20', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbclientedireccion`
--

CREATE TABLE `tbclientedireccion` (
  `tbclientedireccionid` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL,
  `tbclientedireccionbarrio` varchar(30) NOT NULL,
  `tbclientedireccioncoordenadagps` varchar(30) NOT NULL,
  `tbclientedireccionactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbclientedireccion`
--

INSERT INTO `tbclientedireccion` (`tbclientedireccionid`, `tbclienteid`, `tbclientedireccionbarrio`, `tbclientedireccioncoordenadagps`, `tbclientedireccionactivo`) VALUES
(1, 1, 'Rio frio', '40,-73', 1),
(2, 2, 'Guapiles', '41,-80', 1),
(3, 3, 'Puerto Viejo', '35,-65', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbclientetelefono`
--

CREATE TABLE `tbclientetelefono` (
  `tbclientetelefonoid` int(11) NOT NULL,
  `tbclienteid` varchar(4) NOT NULL,
  `tbclientetelefononumero` varchar(100) NOT NULL,
  `tbclientetelefonodescripcion` varchar(100) NOT NULL,
  `tbclientetelefonoactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbclientetelefono`
--

INSERT INTO `tbclientetelefono` (`tbclientetelefonoid`, `tbclienteid`, `tbclientetelefononumero`, `tbclientetelefonodescripcion`, `tbclientetelefonoactivo`) VALUES
(1, '02', '83469905-83147350', 'cel propio-cel amigo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcostoenvio`
--

CREATE TABLE `tbcostoenvio` (
  `tbcostoenvioid` int(11) NOT NULL,
  `tbcostoenviokm` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL,
  `tbcostoenvioestado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbcostoenvio`
--

INSERT INTO `tbcostoenvio` (`tbcostoenvioid`, `tbcostoenviokm`, `tbclienteid`, `tbcostoenvioestado`) VALUES
(1, 2, 1, 1),
(2, 5000, 1, 0),
(3, 6, 3, 1),
(4, 5, 2, 1),
(5, 1, 1, 1),
(6, 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpujacliente`
--

CREATE TABLE `tbpujacliente` (
  `tbpujaclienteid` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL,
  `tbarticuloid` int(11) NOT NULL,
  `tbpujaclientefecha` datetime NOT NULL,
  `tbpujaclienteoferta` decimal(10,0) NOT NULL,
  `tbpujaclienteenvio` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbpujacliente`
--

INSERT INTO `tbpujacliente` (`tbpujaclienteid`, `tbclienteid`, `tbarticuloid`, `tbpujaclientefecha`, `tbpujaclienteoferta`, `tbpujaclienteenvio`) VALUES
(1, 1, 2, '2023-09-04 01:03:00', 910, 3000.00),
(2, 2, 10, '2023-08-29 05:34:00', 760996, 5000.00),
(3, 3, 8, '2023-11-09 22:56:23', 110001, 21261.21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsubasta`
--

CREATE TABLE `tbsubasta` (
  `tbsubastaid` int(11) NOT NULL,
  `tbsubastafechahorainicio` datetime NOT NULL,
  `tbsubastafechahorafinal` datetime NOT NULL,
  `tbsubastaprecio` int(11) NOT NULL,
  `tbsubastaestadoarticulo` varchar(50) NOT NULL,
  `tbsubastaarticulodiasuso` int(11) NOT NULL,
  `tbsubastaactivo` tinyint(4) NOT NULL,
  `tbarticuloid` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbsubasta`
--

INSERT INTO `tbsubasta` (`tbsubastaid`, `tbsubastafechahorainicio`, `tbsubastafechahorafinal`, `tbsubastaprecio`, `tbsubastaestadoarticulo`, `tbsubastaarticulodiasuso`, `tbsubastaactivo`, `tbarticuloid`, `tbclienteid`) VALUES
(1, '2023-08-09 19:43:56', '2025-08-22 19:43:56', 70000, '', 0, 1, 2, 1),
(2, '2023-08-31 03:55:02', '2023-08-31 03:55:02', 70000, '', 0, 1, 3, 2),
(3, '2023-08-30 21:45:00', '2023-09-21 21:45:00', 900, '', 0, 1, 2, 3),
(4, '2023-08-31 07:52:00', '2023-09-02 07:52:00', 760000, '', 0, 1, 2, 2),
(5, '2023-08-31 08:56:00', '2023-09-16 08:56:00', 760995, '', 0, 1, 10, 1),
(6, '2023-09-11 18:49:00', '2023-09-13 18:49:00', 100000, 'Nuevo', 19, 1, 8, 1),
(7, '2023-09-11 18:53:00', '2023-09-20 18:53:00', 100000, 'Usado', 10, 0, 2, 2),
(8, '2023-09-12 18:53:00', '2023-09-13 18:53:00', 100000, 'Usado', 15, 1, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsubcategoria`
--

CREATE TABLE `tbsubcategoria` (
  `tbsubcategoriaid` int(11) NOT NULL,
  `tbsubcategoriasigla` varchar(4) NOT NULL,
  `tbsubcategorianombre` varchar(30) NOT NULL,
  `tbsubcategoriadescripcion` varchar(1000) NOT NULL,
  `tbsubcategoriaactivo` tinyint(1) NOT NULL,
  `tbcategoriaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbsubcategoria`
--

INSERT INTO `tbsubcategoria` (`tbsubcategoriaid`, `tbsubcategoriasigla`, `tbsubcategorianombre`, `tbsubcategoriadescripcion`, `tbsubcategoriaactivo`, `tbcategoriaid`) VALUES
(1, '21', 'Libros y revistas', 'Variado', 1, 2),
(2, '32', 'Ropa Deportiva', 'Disponible', 1, 3),
(3, '13', 'Audios', 'Variado', 1, 1),
(4, '14', 'Computadoras', 'Computadoras inteligentes', 1, 1),
(5, '25', 'otrogg', 'fgsfgs', 1, 2),
(6, '16', 'fsdvsd', 'dsf', 0, 1),
(7, '27', 'fa', 'dasd', 0, 2),
(8, '38', 'prueba', 'fsf', 1, 3),
(9, '29', 'gf', 'ss', 0, 2),
(10, '110', 'prueba', 'prueba', 1, 1),
(11, '311', 'otro', 'otro2', 0, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbcliente`
--
ALTER TABLE `tbcliente`
  ADD PRIMARY KEY (`tbclienteid`);

--
-- Indices de la tabla `tbclientedireccion`
--
ALTER TABLE `tbclientedireccion`
  ADD PRIMARY KEY (`tbclientedireccionid`);

--
-- Indices de la tabla `tbclientetelefono`
--
ALTER TABLE `tbclientetelefono`
  ADD PRIMARY KEY (`tbclientetelefonoid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
