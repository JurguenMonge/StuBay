-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-08-2023 a las 05:18:13
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
  `tbcategoriaid` int(11) NOT NULL,
  `tbsubcategoriaid` int(11) NOT NULL,
  `tbarticulomarca` varchar(255) NOT NULL,
  `tbarticulomodelo` varchar(255) NOT NULL,
  `tbarticuloserie` varchar(255) NOT NULL,
  `tbarticuloactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbarticulo`
--

INSERT INTO `tbarticulo` (`tbarticuloid`, `tbarticulonombre`, `tbcategoriaid`, `tbsubcategoriaid`, `tbarticulomarca`, `tbarticulomodelo`, `tbarticuloserie`, `tbarticuloactivo`) VALUES
(1, 'celular', 1, 1, 'Samsung', 'Galaxy', '122', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategoria`
--

CREATE TABLE `tbcategoria` (
  `tbcategoriaid` int(11) NOT NULL,
  `tbcategoriasigla` tinyint(2) NOT NULL,
  `tbcategorianombre` varchar(30) NOT NULL,
  `tbcategoriadescripcion` varchar(60) NOT NULL,
  `tbcategoriaactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbcategoria`
--

INSERT INTO `tbcategoria` (`tbcategoriaid`, `tbcategoriasigla`, `tbcategorianombre`, `tbcategoriadescripcion`, `tbcategoriaactivo`) VALUES
(1, 1, 'Electrónicos', 'Variados', 1),
(2, 2, 'Entretenimiento', 'Para computadoras', 1),
(3, 3, 'Deportes', 'Variados', 0);

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
(1, 'Giancarlo', 'Arias', 'Paisano', 'arias@gmail.com', '$2y$10$vfvQtoT2RQDnrOz142bqV.vfwd4PAheX/oBZrRA65wBtMvlk2St2i', '2023-08-14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsubcategoria`
--

CREATE TABLE `tbsubcategoria` (
  `tbsubcategoriaid` int(11) NOT NULL,
  `tbsubcategoriasigla` tinyint(2) NOT NULL,
  `tbsubcategorianombre` varchar(30) NOT NULL,
  `tbcategoriaid` int(11) NOT NULL,
  `tbsubcategoriadescripcion` varchar(60) NOT NULL,
  `tbsubcategoriaactivo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbsubcategoria`
--

INSERT INTO `tbsubcategoria` (`tbsubcategoriaid`, `tbsubcategoriasigla`, `tbsubcategorianombre`, `tbcategoriaid`, `tbsubcategoriadescripcion`, `tbsubcategoriaactivo`) VALUES
(1, 1, 'Libros y revistas', 2, 'Variado', 1),
(2, 2, 'Ropa Deportiva', 3, 'Disponible', 1);

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
