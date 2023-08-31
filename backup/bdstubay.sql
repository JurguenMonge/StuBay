-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-08-2023 a las 23:58:45
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
  `tbsubcategoriaid` varchar(4) NOT NULL,
  `tbarticulomarca` varchar(255) NOT NULL,
  `tbarticulomodelo` varchar(255) NOT NULL,
  `tbarticuloserie` varchar(255) NOT NULL,
  `tbarticuloactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbarticulo`
--

INSERT INTO `tbarticulo` (`tbarticuloid`, `tbarticulonombre`, `tbsubcategoriaid`, `tbarticulomarca`, `tbarticulomodelo`, `tbarticuloserie`, `tbarticuloactivo`) VALUES
(1, 'celular', '04', 'Iphone', 'Galaxy', '122', 0),
(2, 'Computadora', '04', 'MSI', 'SX10', 'Pro', 1),
(3, 'Martillo', '01', 'Hammer', 'Ultimate', 'Pro', 0),
(4, 'Casa', '04', 'asdasd', 'asdad', 'fa', 1),
(5, 'Computadora', 'MSI', 'SX11', 'PRO23', '1', 3),
(6, 'ASDASD', 'ASD', 'QWE', 'QWE', '1', 3),
(7, 'Computadora', '03', 'MSI', 'SXC12', '23RR', 1),
(8, 'Computadora', '', 'SD', 'QWQ', 'RF', 1),
(9, 'Celular', '', 'iphone', '11', 'pro', 1),
(10, 'Parlante', '03', 'REDRAGON', '123', '33', 1);

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
(1, '01', 'Tecnologico', 'Variados', 1),
(2, '02', 'Muebles', 'Para computadoras', 1),
(3, '03', 'Ferretería', 'Variado', 1);

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
(3, 'Juan', 'Dolmus', 'Corea', 'jb.dolmus@gmail.com', '$2y$10$T5hIiRDHdUZ/Iq8ZbVfrL.fLJLsIJcRRBzeLjy5I9EA8bpPeOUlwC', '2023-08-26', 1);

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
(1, 1, 'Rio frio', 'Google Maps', 1);

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
-- Estructura de tabla para la tabla `tbpujacliente`
--

CREATE TABLE `tbpujacliente` (
  `tbpujaclienteid` int(11) NOT NULL,
  `tbclienteid` int(11) NOT NULL,
  `tbarticuloid` int(11) NOT NULL,
  `tbpujaclienteprecioactual` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsubasta`
--

CREATE TABLE `tbsubasta` (
  `tbsubastaid` int(11) NOT NULL,
  `tbsubastaFechaHoraInicio` datetime NOT NULL,
  `tbsubastaFechaHoraFinal` datetime NOT NULL,
  `tbsubastaPrecio` int(11) NOT NULL,
  `tbsubastaActivo` tinyint(4) NOT NULL,
  `tbarticuloId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbsubasta`
--

INSERT INTO `tbsubasta` (`tbsubastaid`, `tbsubastaFechaHoraInicio`, `tbsubastaFechaHoraFinal`, `tbsubastaPrecio`, `tbsubastaActivo`, `tbarticuloId`) VALUES
(1, '2023-08-31 19:43:56', '2025-08-22 19:43:56', 70000, 1, 1),
(2, '2023-08-31 03:55:02', '2023-08-31 03:55:02', 70000, 1, 3),
(3, '2023-08-30 21:45:00', '2023-09-21 21:45:00', 900, 1, 2),
(4, '2023-08-31 07:52:00', '2023-09-02 07:52:00', 760000, 1, 2),
(5, '2023-08-31 08:56:00', '2023-09-16 08:56:00', 760995, 1, 10);

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
(1, '0201', 'Libros y revistas', 'Variado', 1, 2),
(2, '0302', 'Ropa Deportiva', 'Disponible', 1, 3),
(3, '0103', 'Audio', 'Variado', 1, 1),
(4, '0104', 'Computadoras', 'Computadoras inteligentes', 1, 1),
(5, '0205', 'otrogg', 'fgsfgs', 1, 2),
(6, '0105', 'fsdvsd', 'dsf', 0, 1),
(7, '0202', 'fa', 'dasd', 0, 2);

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
