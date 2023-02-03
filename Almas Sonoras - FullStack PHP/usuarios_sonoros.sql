-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2022 a las 13:18:16
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuarios_sonoros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(4) NOT NULL,
  `Nombre` varchar(15) NOT NULL DEFAULT '',
  `Clave` varchar(32) NOT NULL DEFAULT '',
  `Email` varchar(50) NOT NULL DEFAULT '',
  `Nota1` varchar(255) NOT NULL,
  `Nota2` varchar(255) NOT NULL,
  `Nota3` varchar(255) NOT NULL,
  `Nota4` varchar(255) NOT NULL,
  `Nota5` varchar(255) NOT NULL,
  `Nota6` varchar(255) NOT NULL,
  `Nota7` varchar(255) NOT NULL,
  `Nota8` varchar(255) NOT NULL,
  `Nota9` varchar(255) NOT NULL,
  `Nota10` varchar(255) NOT NULL,
  `Registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `Nombre`, `Clave`, `Email`, `Nota1`, `Nota2`, `Nota3`, `Nota4`, `Nota5`, `Nota6`, `Nota7`, `Nota8`, `Nota9`, `Nota10`, `Registro`) VALUES
(8, 'Brisa', '72902b4afc5c038ebc5a3c7586456dda', 'brisaleon@mail.com', 'sonidos/sol.mp3', ' ', 'sonidos/fa.mp3', 'sonidos/mi.mp3', 'sonidos/re.mp3', ' ', 'sonidos/do.mp3', 'sonidos/re.mp3', 'sonidos/mi.mp3', 'sonidos/la.mp3', '2022-02-17 12:38:24'),
(11, 'Admin', '2a2e9a58102784ca18e2605a4e727b5f', 'admin@mail.com', '', '', '', '', '', '', '', '', '', '', '2022-02-22 10:48:53'),
(15, 'Estrella', 'c26af9f32815ec696fc19aedde845107', 'estrellita@mail.com', 'sonidos/do.mp3', 'sonidos/do.mp3', ' ', 'sonidos/sol.mp3', 'sonidos/sol.mp3', ' ', 'sonidos/la.mp3', 'sonidos/la.mp3', ' ', 'sonidos/sol.mp3', '2022-02-24 10:40:26'),
(18, 'scoobydoo', '38371fef7d829c7f8b0e2fedf7a04334', 'scoobydoo@mail.com', 'sonidos/fa.mp3', 'sonidos/res.mp3', 'sonidos/fa.mp3', 'sonidos/dos.mp3', ' ', 'sonidos/fa.mp3', 'sonidos/fa.mp3', 'sonidos/res.mp3', 'sonidos/dos.mp3', 'sonidos/do.mp3', '2022-02-24 12:14:52'),
(21, 'marito', '73da2c0100ab380a9225bcd2ac8a190c', 'marito@mail.com', 'sonidos/do.mp3', 'sonidos/si.mp3', 'sonidos/re.mp3', 'sonidos/la.mp3', ' ', 'sonidos/do.mp3', 'sonidos/si.mp3', 'sonidos/re.mp3', 'sonidos/la.mp3', 'sonidos/la.mp3', '2022-02-25 15:56:31'),
(28, 'Denise', 'a4a29ad0d0391fa27c9c8f28a1cbf38f', 'denise_2000@mail.com', 'sonidos/sol.mp3', ' ', 'sonidos/fa.mp3', 'sonidos/mi.mp3', 'sonidos/re.mp3', ' ', 'sonidos/do.mp3', 'sonidos/re.mp3', ' ', 'sonidos/mi.mp3', '2022-03-03 20:37:12'),
(29, 'mozart', '245fee481a521ab88a64675422e415c0', 'mozart@mail.com', 'sonidos/sol.mp3', ' ', 'sonidos/re.mp3', 'sonidos/sol.mp3', ' ', 'sonidos/re.mp3', 'sonidos/sol.mp3', 'sonidos/re.mp3', 'sonidos/sol.mp3', 'sonidos/si.mp3', '2022-03-03 20:47:53'),
(30, 'cheddar', '945b9c676c5138e8257779741b96badb', 'nachosconcheddar@mail.com', 'sonidos/si.mp3', ' ', 'sonidos/la.mp3', 'sonidos/sols.mp3', ' ', 'sonidos/mi.mp3', 'sonidos/la.mp3', ' ', 'sonidos/sols.mp3', 'sonidos/sols.mp3', '2022-03-06 10:21:19'),
(31, 'eliza', '78d956cbd8660d6ed4b6def1fda3d928', 'eliza@mail.com', 'sonidos/si.mp3', ' ', 'sonidos/la.mp3', 'sonidos/sols.mp3', ' ', 'sonidos/mi.mp3', 'sonidos/la.mp3', 'sonidos/la.mp3', 'sonidos/sols.mp3', 'sonidos/sols.mp3', '2022-03-06 19:25:55'),
(32, 'lion', 'e8992017225948b45d85358bd7a82f2d', 'leon@mail.com', 'sonidos/sol.mp3', ' ', 'sonidos/fa.mp3', 'sonidos/mi.mp3', 'sonidos/re.mp3', ' ', 'sonidos/do.mp3', ' ', 'sonidos/do.mp3', 'sonidos/la.mp3', '2022-03-06 19:30:32'),
(33, 'Liliana', '0e1fe454cc87ba50be4ba29871cb78f7', 'liliana@mail.com', 'sonidos/si.mp3', ' ', 'sonidos/la.mp3', 'sonidos/la.mp3', 'sonidos/sols.mp3', ' ', 'sonidos/mi.mp3', 'sonidos/mi.mp3', 'sonidos/fas.mp3', 'sonidos/sols.mp3', '2022-03-07 08:45:38');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
