-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-08-2023 a las 03:14:28
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
  `tbcategoriaid` varchar(2) NOT NULL,
  `tbsubcategoriaid` varchar(2) NOT NULL,
  `tbarticulomarca` varchar(255) NOT NULL,
  `tbarticulomodelo` varchar(255) NOT NULL,
  `tbarticuloserie` varchar(255) NOT NULL,
  `tbarticuloactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbarticulo`
--

INSERT INTO `tbarticulo` (`tbarticuloid`, `tbarticulonombre`, `tbcategoriaid`, `tbsubcategoriaid`, `tbarticulomarca`, `tbarticulomodelo`, `tbarticuloserie`, `tbarticuloactivo`) VALUES
(1, 'celular', '02', '04', 'Samsung', 'Galaxy', '122', 1),
(2, 'Computadora', '01', '04', 'MSI', 'SX10', 'Pro', 1),
(3, 'Martillo', '02', '01', 'Hammer', 'Ultimate', 'Pro', 1);

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
(2, 'Jurguen', 'Monge', 'Rojas', 'jur.monge@gmail.com', '$2y$10$T2ij5M5Hf1rif/bCd5OzmuN/3dy7eKLASO1YJHQe1IomPf.V.4AUa', '2023-08-02', 1);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
