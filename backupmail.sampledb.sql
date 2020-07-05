-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-07-2020 a las 01:11:13
-- Versión del servidor: 10.1.44-MariaDB-0ubuntu0.18.04.1
-- Versión de PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mailbackup`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `igw_emails`
--

CREATE TABLE `igw_emails` (
  `ID_MAIL` int(10) NOT NULL,
  `MAIL` varchar(255) NOT NULL,
  `UID` varchar(55) NOT NULL,
  `MESSAGE_ID` varchar(55) NOT NULL,
  `UDATE` varchar(55) NOT NULL,
  `SUBJECT` varchar(255) NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `FOLDER` varchar(255) DEFAULT 'INBOX',
  `STATUS` int(1) NOT NULL,
  `ARCHIVE` int(1) NOT NULL DEFAULT '0',
  `DELETED` int(1) NOT NULL DEFAULT '0',
  `UPD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `igw_emails_tags`
--

CREATE TABLE `igw_emails_tags` (
  `ID_MAIL_TAG` int(10) NOT NULL,
  `ID_MAIL` int(10) NOT NULL,
  `ID_TAG` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `igw_tags`
--

CREATE TABLE `igw_tags` (
  `ID_TAG` int(10) NOT NULL,
  `ID_TAG_SUP` int(3) NOT NULL,
  `MAIL` varchar(255) NOT NULL DEFAULT '0',
  `TAG` varchar(255) NOT NULL,
  `TAG_COLOR` varchar(55) NOT NULL DEFAULT 'info',
  `TAG_ICON` varchar(55) NOT NULL DEFAULT 'tag',
  `STATUS` int(1) NOT NULL DEFAULT '1',
  `POSICION` int(3) NOT NULL,
  `ICON_S` varchar(1) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `igw_tags` (`ID_TAG`, `ID_TAG_SUP`, `MAIL`, `TAG`, `TAG_COLOR`, `TAG_ICON`, `STATUS`, `POSICION`, `ICON_S`) VALUES
(1, 0, '0', 'IMPORTANTES', 'yellow', 'star', 1, 1, ''),
(2, 0, '0', 'SPAM', 'inverse', 'thumbs-down', 1, 99, ''),
(3, 0, '0', 'TAREAS', 'warning', 'tasks', 1, 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `igw_emails`
--
ALTER TABLE `igw_emails`
  ADD PRIMARY KEY (`ID_MAIL`);

--
-- Indices de la tabla `igw_emails_tags`
--
ALTER TABLE `igw_emails_tags`
  ADD PRIMARY KEY (`ID_MAIL_TAG`);

--
-- Indices de la tabla `igw_tags`
--
ALTER TABLE `igw_tags`
  ADD PRIMARY KEY (`ID_TAG`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `igw_emails`
--
ALTER TABLE `igw_emails`
  MODIFY `ID_MAIL` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `igw_emails_tags`
--
ALTER TABLE `igw_emails_tags`
  MODIFY `ID_MAIL_TAG` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `igw_tags`
--
ALTER TABLE `igw_tags`
  MODIFY `ID_TAG` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
