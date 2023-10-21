-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-10-2023 a las 00:14:56
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
  `tbsubcategoriaid` varchar(100) NOT NULL,
  `tbclienteid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbarticulo`
--

INSERT INTO `tbarticulo` (`tbarticuloid`, `tbarticulonombre`, `tbarticulomarca`, `tbarticulomodelo`, `tbarticuloserie`, `tbarticuloactivo`, `tbsubcategoriaid`, `tbclienteid`) VALUES
(1, 'Computadora', 'MSI', 'GF63', '1234', 0, '21', 1),
(2, 'Computadora', 'MSI12', '2010', '4322', 1, '13', 1),
(3, 'LibroPrueba', 'ED', '3D', '786', 1, '21', 3),
(4, 'Escritorio', 'Lo', '', '', 1, '14', 2),
(5, 'Monitor', 'CM190', '2014', '123', 1, '14', 1);

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
(1, '1', 'Tecnologico', 'Variados', 1),
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
(1, 'Giancarlo', 'Arias', 'P', 'arias@gmail.com', '$2y$10$Ah/9AvIaBmUbk5wA7WUSmuOwsx.myiRZn6CuFRo3xqeH6klv4qMaG', '2023-10-03', 1),
(2, 'Jurguen', 'Monge', 'Rojas', 'jurguen@gmail.com', '$2y$10$I261MJPaDo1oZmhL5YW1q.IEG5U67qZlG5W9uN2cur4e1Bk6dmcpu', '2023-10-09', 1),
(3, 'Juan', 'Dolmus', 'Corea', 'dolmus@gmail.com', '$2y$10$e/WGSVRBLE1I4r9euz8p2uqWKW.s7rqP1d1.gpVFIlyksZdYIoga.', '2023-10-09', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbclientedireccion`
--

CREATE TABLE `tbclientedireccion` (
  `tbclientedireccionid` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL,
  `tbclientedireccionbarrio` varchar(30) NOT NULL,
  `tbclientedireccionlatitud` varchar(200) NOT NULL,
  `tbclientedireccionlongitud` varchar(200) NOT NULL,
  `tbclientedireccionactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbclientedireccion`
--

INSERT INTO `tbclientedireccion` (`tbclientedireccionid`, `tbclienteid`, `tbclientedireccionbarrio`, `tbclientedireccionlatitud`, `tbclientedireccionlongitud`, `tbclientedireccionactivo`) VALUES
(1, 1, 'Rio frio', '12.44', '-13.43', 1),
(2, 2, 'Guapiles', '16.44', '-19.983', 1),
(3, 3, 'Puerto Viejo', '20.32', '-14.54', 1);

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
(1, '1', '83469905-83147350', 'cel propio-cel amigo', 1),
(2, '1', '60058595', 'cel propio', 1);

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
(1, 3, 2, '2023-10-18 17:49:26', 70001, 884.17),
(2, 1, 3, '2023-10-19 10:11:13', 950, 884.17),
(3, 3, 5, '2023-10-19 10:17:56', 100001, 884.17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpujaseguidor`
--

CREATE TABLE `tbpujaseguidor` (
  `tbsubastaseguidorid` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL,
  `tbsubastaid` int(11) NOT NULL,
  `tbsubastaseguidoractivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbpujaseguidor`
--

INSERT INTO `tbpujaseguidor` (`tbsubastaseguidorid`, `tbclienteid`, `tbsubastaid`, `tbsubastaseguidoractivo`) VALUES
(1, 1, 1, 1),
(2, 3, 4, 1);

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
(1, '2023-08-09 19:43:56', '2023-08-22 19:43:56', 70000, 'Usado', 0, 1, 2, 1),
(2, '2023-08-31 03:55:02', '2023-10-13 03:55:02', 70000, 'Usado', 0, 1, 3, 2),
(3, '2023-08-30 21:45:00', '2023-10-19 09:45:00', 900, 'Usado', 0, 1, 3, 3),
(4, '2023-08-31 07:52:00', '2023-09-02 07:52:00', 760000, '', 0, 1, 2, 2),
(5, '2023-08-31 08:56:00', '2023-09-16 08:56:00', 760995, 'Usado', 0, 0, 2, 1),
(6, '2023-09-11 18:49:00', '2023-09-13 18:49:00', 100000, 'Nuevo', 0, 0, 2, 1),
(7, '2023-09-11 18:53:00', '2023-09-20 18:53:00', 100000, 'Usado', 10, 0, 2, 2),
(8, '2023-09-12 18:53:00', '2023-09-13 18:53:00', 100000, 'Usado', 15, 0, 2, 1),
(9, '2023-10-17 01:02:00', '2023-10-19 10:30:00', 100000, 'Nuevo', 0, 1, 5, 1);

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
(10, '110', 'prueba', 'prueba', 0, 1),
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

--
-- Indices de la tabla `tbpujaseguidor`
--
ALTER TABLE `tbpujaseguidor`
  ADD PRIMARY KEY (`tbsubastaseguidorid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
