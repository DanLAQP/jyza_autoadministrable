-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2025 a las 08:13:45
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cifaa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` text DEFAULT NULL,
  `expires` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES
('dmtudndspiil7k9peqjv286e8f', 'Config|a:1:{s:4:\"time\";i:1764227607;}Flash|a:1:{s:5:\"flash\";a:15:{i:0;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:3;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:4;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:5;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:6;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:7;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:8;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:9;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:10;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:11;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:12;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:13;a:4:{s:7:\"message\";s:88:\"Su usuario está inactivo o deshabilitado. Por favor, comuníquese con un administrador.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:14;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}}}', 1764242007),
('g5g0mbm9b58fj4dp26gjah8mdd', 'Config|a:1:{s:4:\"time\";i:1764225682;}Flash|a:0:{}', 1764240082),
('lirq1jm3v39cog79bquv8h22vv', 'Config|a:1:{s:4:\"time\";i:1764226964;}Flash|a:1:{s:5:\"flash\";a:9:{i:0;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:3;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:4;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:5;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:6;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:7;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:8;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}}}', 1764241364),
('t9iv1em6b98j697r0actdkkesr', 'Config|a:1:{s:4:\"time\";i:1764226495;}Flash|a:0:{}', 1764240895);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rol`, `created`, `modified`, `estado`) VALUES
(1, 'admin', '$2y$10$OqwGqOf0MsTsVZFsg9KPF.rW9nWbW7IOnOt4c9QyE117iKrlkWv9S', 1, '2025-11-27 01:16:52', '2025-11-27 01:17:23', 'activo'),
(2, 'usuario', '$2y$10$a.dafU5XV3UqCq9vP.81X.r/5LvWAin/KYPV3qKAWcTM90K9gSLWi', 2, '2025-11-27 01:17:39', '2025-11-27 01:58:55', 'activo'),
(3, 'user', '$2y$10$3W.D0VA.zVSAqSaQqRREdO6IZbDntdMcQNe6jxJQ3ykmyjSlVG6Lu', 2, '2025-11-27 01:57:25', '2025-11-27 01:58:51', 'inactivo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
