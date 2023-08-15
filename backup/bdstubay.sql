-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2023 at 01:56 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdstubay`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbarticulo`
--

CREATE TABLE `tbarticulo` (
  `tbarticuloid` int(11) NOT NULL,
  `tbarticulonombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbcategoriaid` int(11) NOT NULL,
  `tbsubcategoriaid` int(11) NOT NULL,
  `tbarticulomarca` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbarticulomodelo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbarticuloserie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbarticuloactivo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbarticulo`
--

INSERT INTO `tbarticulo` (`tbarticuloid`, `tbarticulonombre`, `tbcategoriaid`, `tbsubcategoriaid`, `tbarticulomarca`, `tbarticulomodelo`, `tbarticuloserie`, `tbarticuloactivo`) VALUES
(1, 'Celular', 1, 2, 'Samsumg', 'Galaxy', 'NOTE 10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbcliente`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbcliente`
--

INSERT INTO `tbcliente` (`clienteid`, `clientenombre`, `clienteprimerapellido`, `clientesegundoapellido`, `clientecorreo`, `clientepassword`, `clientefechaingreso`, `clienteactivo`) VALUES
(1, 'Giancarlo', 'Arias', 'Paisano', 'arias@gmail.com', '$2y$10$vfvQtoT2RQDnrOz142bqV.vfwd4PAheX/oBZrRA65wBtMvlk2St2i', '2023-08-14', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbcliente`
--
ALTER TABLE `tbcliente`
  ADD PRIMARY KEY (`clienteid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
