-- ====================================
-- CIFAA Database Schema
-- Complete structure with migrations applied
-- ====================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ====================================
-- Tabla: users
-- Includes DNI column from migration 20251212051347
-- ====================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL COMMENT '1=admin, 2=docente, 3=estudiante',
  `dni` varchar(20) NOT NULL DEFAULT '00000000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activo' COMMENT 'activo/inactivo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: cursos
-- ====================================
CREATE TABLE `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL COMMENT 'ID del docente creador',
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `miniatura` varchar(255) DEFAULT NULL COMMENT 'Ruta relativa de imagen (uploads/...)',
  `nivel` varchar(50) DEFAULT NULL COMMENT 'basico/intermedio/avanzado',
  `categoria` varchar(100) DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'borrador' COMMENT 'borrador/publicado',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: modulos
-- ====================================
CREATE TABLE `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `curso_id` (`curso_id`),
  CONSTRAINT `modulos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: lecciones
-- ====================================
CREATE TABLE `lecciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipo_contenido` varchar(50) DEFAULT 'texto' COMMENT 'texto/video/pdf',
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modulo_id` (`modulo_id`),
  CONSTRAINT `lecciones_ibfk_1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: contenidos_leccion
-- ====================================
CREATE TABLE `contenidos_leccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leccion_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL COMMENT 'texto/video/pdf',
  `contenido` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL COMMENT 'Ruta relativa de archivo (uploads/...)',
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `leccion_id` (`leccion_id`),
  CONSTRAINT `contenidos_leccion_ibfk_1` FOREIGN KEY (`leccion_id`) REFERENCES `lecciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: inscripciones
-- Includes estado column from migration 20251208071001
-- ====================================
CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `progreso` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente' COMMENT 'pendiente/aprobada/rechazada',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `curso_id` (`curso_id`),
  CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: certificados
-- From migrations 20251212053233 and 20251214003559
-- ====================================
CREATE TABLE `certificados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `horas` int(11) NOT NULL DEFAULT 0,
  `fecha_emision` date NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `archivo_pdf` varchar(255) DEFAULT NULL COMMENT 'Ruta relativa del archivo PDF (uploads/certificados/...)',
  `estado` enum('activo','anulado') NOT NULL DEFAULT 'activo' COMMENT 'activo (valido) o anulado (revocado)',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_certificados_codigo` (`codigo`),
  KEY `idx_certificados_user_id` (`user_id`),
  KEY `idx_certificados_curso_id` (`curso_id`),
  KEY `idx_certificados_estado` (`estado`),
  CONSTRAINT `certificados_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificados_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: sessions
-- CakePHP session storage
-- ====================================
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` text DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ====================================
-- Tabla: phinxlog
-- CakePHP migrations tracking
-- ====================================
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
