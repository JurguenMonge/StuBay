-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-08-2023 a las 04:14:28
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
(1, 1, 'Tecnologico', 'Variados', 1),
(2, 2, 'Muebles', 'Para computadoras', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcliente`
--

CREATE TABLE `tbcliente` (
  `clienteid` int(11) NOT NULL,
  `clientenombre` varchar(30) NOT NULL,
  `clienteprimerapellido` varchar(30) NOT NULL,
  `clientesegundoapellido` varchar(30) NOT NULL,
  `clientecorreo` varchar(50) NOT NULL,
  `clientepassword` varchar(100) NOT NULL,
  `clientefechaingreso` date NOT NULL,
  `clienteactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcliente`
--

INSERT INTO `tbcliente` (`clienteid`, `clientenombre`, `clienteprimerapellido`, `clientesegundoapellido`, `clientecorreo`, `clientepassword`, `clientefechaingreso`, `clienteactivo`) VALUES
(1, 'Giancarlo', 'Arias', 'Paisano', 'arias@gmail.com', '$2y$10$vfvQtoT2RQDnrOz142bqV.vfwd4PAheX/oBZrRA65wBtMvlk2St2i', '2023-08-14', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbcliente`
--
ALTER TABLE `tbcliente`
  ADD PRIMARY KEY (`clienteid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
