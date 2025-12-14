-- ====================================
-- CIFAA Database Initial Data
-- Users with simple test passwords + sample course data
-- ====================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ====================================
-- Insert Users
-- Passwords: admin/admin, docente/docente, estudiante/estudiante
-- ====================================
INSERT INTO `users` (`id`, `username`, `password`, `rol`, `dni`, `created`, `modified`, `estado`) VALUES
(1, 'admin', '$2y$10$7YmxNmus7fSjss9NmwPQL.Sf1aBML7q/gbpGaJaLc1SjZ6AeWXzAy', 1, '12345678', NOW(), NOW(), 'activo'),
(2, 'docente', '$2y$10$/kr1QKqxna.AI20AOL/TxOxLhC5DjlntVwJ524vKI1.FCwwCbKIv6', 2, '87654321', NOW(), NOW(), 'activo'),
(3, 'estudiante', '$2y$10$oAAQDI6qdwbbFvQSKCuH3./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe', 3, '11223344', NOW(), NOW(), 'activo');

-- ====================================
-- Insert Sample Courses
-- ====================================
INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES
(1, 2, 'Introducción a Python', 'Curso completo de Python desde cero hasta nivel intermedio', 'uploads/cursos/python.jpg', 'basico', 'Programación', 'publicado', NOW(), NOW()),
(2, 2, 'Java para Principiantes', 'Aprende los fundamentos de Java y programación orientada a objetos', 'uploads/cursos/java.jpg', 'basico', 'Programación', 'publicado', NOW(), NOW());

-- ====================================
-- Insert Sample Modules
-- ====================================
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'Módulo 1: Fundamentos de Python', 1, NOW(), NOW()),
(2, 1, 'Módulo 2: Estructuras de Control', 2, NOW(), NOW());

-- ====================================
-- Insert Sample Lessons
-- ====================================
INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'Lección 1: Introducción y Variables', 'texto', 1, NOW(), NOW()),
(2, 1, 'Lección 2: Operadores Básicos', 'video', 2, NOW(), NOW()),
(3, 2, 'Lección 1: Estructuras Condicionales', 'texto', 1, NOW(), NOW()),
(4, 2, 'Lección 2: Bucles For y While', 'texto', 2, NOW(), NOW());

-- ====================================
-- Insert Sample Lesson Contents
-- ====================================
INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'texto', '<h3>Bienvenido a Python</h3><p>Python es un lenguaje de programación interpretado de alto nivel.</p>', NULL, 1, NOW(), NOW()),
(2, 2, 'video', NULL, 'uploads/lecciones/python_operadores.mp4', 1, NOW(), NOW()),
(3, 3, 'texto', '<h3>Condicionales en Python</h3><p>Las estructuras if-elif-else permiten tomar decisiones en el código.</p>', NULL, 1, NOW(), NOW());

-- ====================================
-- Insert Sample Inscripciones
-- Student enrolled in Python course (approved)
-- ====================================
INSERT INTO `inscripciones` (`id`, `usuario_id`, `curso_id`, `progreso`, `created`, `modified`, `estado`) VALUES
(1, 3, 1, 25, NOW(), NOW(), 'aprobada'),
(2, 3, 2, 0, NOW(), NOW(), 'pendiente');

-- ====================================
-- Track Applied Migrations
-- ====================================
INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20251208071001, 'AddStatusToInscripciones', NOW(), NOW(), 0),
(20251212051347, 'AddDniToUsers', NOW(), NOW(), 0),
(20251212053233, 'CreateCertificados', NOW(), NOW(), 0),
(20251214003559, 'AddArchivoPdfToCertificados', NOW(), NOW(), 0);

COMMIT;
