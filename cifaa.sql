-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2025 a las 17:19:05
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
-- Estructura de tabla para la tabla `contenidos_leccion`
--

CREATE TABLE `contenidos_leccion` (
  `id` int(11) NOT NULL,
  `leccion_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `contenido` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenidos_leccion`
--

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'video', 'Video de la leccion uno', 'uploads/contenidos_leccion/1765175989_693672b5a0776.mp4', 1, '2025-12-08 01:39:49', '2025-12-08 01:39:49'),
(2, 1, 'video', 'Aqui solo imagen en etsa ocu', 'uploads/contenidos_leccion/1765176486_693674a6bf8a3.mp4', 2, '2025-12-08 01:45:02', '2025-12-08 01:48:06'),
(3, 1, 'imagen', 'Pdf', 'uploads/contenidos_leccion/1765176343_6936741713a12.pdf', 3, '2025-12-08 01:45:43', '2025-12-08 01:45:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `miniatura` varchar(255) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT 'basico',
  `categoria` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'borrador',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES
(1, 1, 'python', 'cURSO DE PROGRAMACION', 'uploads/cursos/1765174043_69366b1bbd4c2.webp', 'basico', 'Programacion', 'activo', '2025-12-08 01:00:18', '2025-12-08 01:07:23'),
(2, 1, 'java', 'Curso xD', 'uploads/cursos/1765174021_69366b05dba09.webp', 'basico', 'Programacion', 'activo', '2025-12-08 01:07:01', '2025-12-08 01:07:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `progreso` int(11) DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente' COMMENT 'Estado de la inscripción: pendiente, aprobada, rechazada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `usuario_id`, `curso_id`, `progreso`, `created`, `modified`, `estado`) VALUES
(1, 1, 1, 30, '2025-12-08 01:56:58', '2025-12-08 11:17:09', 'aprobada'),
(2, 2, 1, 0, '2025-12-08 01:58:47', '2025-12-08 02:14:49', 'aprobada'),
(3, 3, 1, 0, '2025-12-08 02:13:10', '2025-12-08 02:13:10', 'pendiente'),
(4, 3, 1, 0, '2025-12-08 02:27:32', '2025-12-08 02:27:32', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lecciones`
--

CREATE TABLE `lecciones` (
  `id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipo_contenido` varchar(50) DEFAULT 'texto',
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lecciones`
--

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'Leccion 1: Aprendiendo operadores u.u', 'video', 1, '2025-12-08 01:26:57', '2025-12-08 01:28:47'),
(2, 1, 'Leccion 2 : Aprendiendo fors', 'texto', 2, '2025-12-08 01:29:38', '2025-12-08 01:29:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'python inical', 1, '2025-12-08 01:16:42', '2025-12-08 01:16:42');

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

--
-- Volcado de datos para la tabla `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20251208071001, 'AddStatusToInscripciones', '2025-12-08 02:10:14', '2025-12-08 02:10:14', 0);

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
('169usf2pg09fv2rpi9fjrf9f16', 'Config|a:1:{s:4:\"time\";i:1765179819;}Flash|a:1:{s:5:\"flash\";a:32:{i:0;a:4:{s:7:\"message\";s:48:\"The curso could not be saved. Please, try again.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:25:\"The curso has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:25:\"The curso has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:3;a:4:{s:7:\"message\";s:25:\"The curso has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:4;a:4:{s:7:\"message\";s:25:\"The curso has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:5;a:4:{s:7:\"message\";s:26:\"The modulo has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:6;a:4:{s:7:\"message\";s:28:\"The leccione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:7;a:4:{s:7:\"message\";s:28:\"The leccione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:8;a:4:{s:7:\"message\";s:28:\"The leccione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:9;a:4:{s:7:\"message\";s:28:\"The leccione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:10;a:4:{s:7:\"message\";s:30:\"El contenido ha sido guardado.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:11;a:4:{s:7:\"message\";s:30:\"El contenido ha sido guardado.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:12;a:4:{s:7:\"message\";s:30:\"El contenido ha sido guardado.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:13;a:4:{s:7:\"message\";s:30:\"El contenido ha sido guardado.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:14;a:4:{s:7:\"message\";s:40:\"¡Te has inscrito exitosamente al curso!\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:15;a:4:{s:7:\"message\";s:24:\"The user has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:16;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:17;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:18;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:19;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:20;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:21;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:22;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:23;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:24;a:4:{s:7:\"message\";s:73:\"No tienes acceso a este módulo. Por favor, inscríbete al curso primero.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:25;a:4:{s:7:\"message\";s:99:\"¡Tu solicitud de inscripción ha sido enviada! Por favor espera a que un administrador la apruebe.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:26;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:27;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:28;a:4:{s:7:\"message\";s:99:\"¡Tu solicitud de inscripción ha sido enviada! Por favor espera a que un administrador la apruebe.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:29;a:4:{s:7:\"message\";s:39:\"No tienes permisos para crear módulos.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:30;a:4:{s:7:\"message\";s:40:\"No tienes permisos para editar módulos.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:31;a:4:{s:7:\"message\";s:42:\"No tienes permisos para eliminar módulos.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}}}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:7:{s:2:\"id\";i:3;s:8:\"username\";s:4:\"user\";s:8:\"password\";s:60:\"$2y$10$3W.D0VA.zVSAqSaQqRREdO6IZbDntdMcQNe6jxJQ3ykmyjSlVG6Lu\";s:3:\"rol\";i:2;s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-11-27 01:57:25.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-08 01:59:17.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:7:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:7:\"created\";i:5;s:8:\"modified\";i:6;s:6:\"estado\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:6:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}', 1765194219),
('dmtudndspiil7k9peqjv286e8f', 'Config|a:1:{s:4:\"time\";i:1764227607;}Flash|a:1:{s:5:\"flash\";a:15:{i:0;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:3;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:4;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:5;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:6;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:7;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:8;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:9;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:10;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:11;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:12;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:13;a:4:{s:7:\"message\";s:88:\"Su usuario está inactivo o deshabilitado. Por favor, comuníquese con un administrador.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:14;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}}}', 1764242007),
('g3o0p7273hudc5dfgvpehiimbv', 'Config|a:1:{s:4:\"time\";i:1765210653;}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:7:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:60:\"$2y$10$OqwGqOf0MsTsVZFsg9KPF.rW9nWbW7IOnOt4c9QyE117iKrlkWv9S\";s:3:\"rol\";i:1;s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-11-27 01:16:52.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-11-27 01:17:23.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:7:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:7:\"created\";i:5;s:8:\"modified\";i:6;s:6:\"estado\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:6:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}Flash|a:1:{s:5:\"flash\";a:3:{i:0;a:4:{s:7:\"message\";s:32:\"The inscripcione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:32:\"The inscripcione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:32:\"The inscripcione has been saved.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}}}', 1765225053),
('g5g0mbm9b58fj4dp26gjah8mdd', 'Config|a:1:{s:4:\"time\";i:1764225682;}Flash|a:0:{}', 1764240082),
('lirq1jm3v39cog79bquv8h22vv', 'Config|a:1:{s:4:\"time\";i:1764226964;}Flash|a:1:{s:5:\"flash\";a:9:{i:0;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:3;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:4;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:5;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:6;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:7;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:8;a:4:{s:7:\"message\";s:32:\"Usuario o contraseña inválidos\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}}}', 1764241364),
('o7c4al41sf7d9i41fust11hqe7', 'Config|a:1:{s:4:\"time\";i:1765210710;}Flash|a:1:{s:5:\"flash\";a:3:{i:0;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:40:\"No tienes permisos para editar módulos.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:11:\"flash/error\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}}}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:7:{s:2:\"id\";i:3;s:8:\"username\";s:4:\"user\";s:8:\"password\";s:60:\"$2y$10$3W.D0VA.zVSAqSaQqRREdO6IZbDntdMcQNe6jxJQ3ykmyjSlVG6Lu\";s:3:\"rol\";i:2;s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-11-27 01:57:25.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-08 01:59:17.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:7:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:7:\"created\";i:5;s:8:\"modified\";i:6;s:6:\"estado\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:6:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}', 1765225110),
('r8d6hi040bufleg5re6fua32tv', 'Config|a:1:{s:4:\"time\";i:1765179836;}Flash|a:1:{s:5:\"flash\";a:6:{i:0;a:4:{s:7:\"message\";s:40:\"¡Te has inscrito exitosamente al curso!\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:1;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:2;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:3;a:4:{s:7:\"message\";s:63:\"Inscripción aprobada. El usuario ahora puede acceder al curso.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:4;a:4:{s:7:\"message\";s:63:\"Inscripción aprobada. El usuario ahora puede acceder al curso.\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}i:5;a:4:{s:7:\"message\";s:24:\"You have been logged out\";s:3:\"key\";s:5:\"flash\";s:7:\"element\";s:13:\"flash/success\";s:6:\"params\";a:0:{}}}}', 1765194236),
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
(3, 'user', '$2y$10$3W.D0VA.zVSAqSaQqRREdO6IZbDntdMcQNe6jxJQ3ykmyjSlVG6Lu', 2, '2025-11-27 01:57:25', '2025-12-08 01:59:17', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenidos_leccion`
--
ALTER TABLE `contenidos_leccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leccion_id` (`leccion_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulo_id` (`modulo_id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenidos_leccion`
--
ALTER TABLE `contenidos_leccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenidos_leccion`
--
ALTER TABLE `contenidos_leccion`
  ADD CONSTRAINT `contenidos_leccion_ibfk_1` FOREIGN KEY (`leccion_id`) REFERENCES `lecciones` (`id`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`);

--
-- Filtros para la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD CONSTRAINT `lecciones_ibfk_1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`);

--
-- Filtros para la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD CONSTRAINT `modulos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
