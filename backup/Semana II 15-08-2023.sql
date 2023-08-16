-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-08-2023 a las 04:34:39
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbstubay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbstudent`
--

CREATE TABLE `tbstudent` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `identification` int(9) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbstudent`
--

INSERT INTO `tbstudent` (`id`, `name`, `lastname`, `identification`, `birthdate`, `email`, `active`) VALUES
(1, 'Giancarlo', 'Arias', 123456789, '2023-08-03', 'arias@gmail.com', 1),
(2, 'Juan', 'Dolmus', 70980772, '2023-08-10', 'juan.dol@gmail.com', 1),
(3, 'Jurguen', 'Monge', 702870755, '2023-08-24', 'jur.monge@gmail.com', 1),
(4, 'Jose', 'Gonzalez', 706760324, '2023-08-18', 'jose@gmail.com', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbstudent`
--
ALTER TABLE `tbstudent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbstudent`
--
ALTER TABLE `tbstudent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
