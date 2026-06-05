-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2026 a las 18:32:49
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
-- Base de datos: `jyza_autoadministrable`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` text DEFAULT NULL,
  `expires` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES
('c7ae81okq00uts8tiqi0u0n7qf', 'Config|a:1:{s:4:\"time\";i:1774854977;}Flash|a:0:{}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:9:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:60:\"$2y$10$pASpJPc9Lh8VEplQx0iZmOXL89ZFvkfKrW/53tQuKXa/ZSSjX2/aC\";s:3:\"rol\";i:1;s:3:\"dni\";s:8:\"12345678\";s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-17 22:29:45.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";s:7:\"nombres\";s:0:\"\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:9:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:3:\"dni\";i:5;s:7:\"created\";i:6;s:8:\"modified\";i:7;s:6:\"estado\";i:8;s:7:\"nombres\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:7:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;s:7:\"nombres\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}', 1774869377),
('htld75e008f2203aqesi5qu71l', 'Config|a:1:{s:4:\"time\";i:1780208999;}Flash|a:0:{}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:9:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:60:\"$2y$10$pASpJPc9Lh8VEplQx0iZmOXL89ZFvkfKrW/53tQuKXa/ZSSjX2/aC\";s:3:\"rol\";i:1;s:3:\"dni\";s:8:\"12345678\";s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-17 22:29:45.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";s:7:\"nombres\";s:0:\"\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:9:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:3:\"dni\";i:5;s:7:\"created\";i:6;s:8:\"modified\";i:7;s:6:\"estado\";i:8;s:7:\"nombres\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:8:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;s:7:\"nombres\";b:1;s:3:\"dni\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}', 1780223399);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL COMMENT '1=admin, 2=docente, 3=estudiante',
  `dni` varchar(20) NOT NULL DEFAULT '00000000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activo' COMMENT 'activo/inactivo',
  `nombres` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rol`, `dni`, `created`, `modified`, `estado`, `nombres`) VALUES
(1, 'admin', '$2y$10$pASpJPc9Lh8VEplQx0iZmOXL89ZFvkfKrW/53tQuKXa/ZSSjX2/aC', 1, '12345678', '2025-12-14 01:25:05', '2025-12-17 22:29:45', 'activo', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
