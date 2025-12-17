-- ====================================
-- MIGRACIÓN: SISTEMA DE TITULARES
-- Fecha: 15 de diciembre de 2025
-- Propósito: Separar identidad certificable de usuarios del sistema
-- ====================================

-- PASO 1: Crear tabla titulares
-- Esta tabla representa la identidad certificable mínima de una persona

CREATE TABLE IF NOT EXISTS `titulares` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dni` VARCHAR(20) NOT NULL COMMENT 'Identificador único de persona',
  `nombres` VARCHAR(100) NOT NULL COMMENT 'Nombres completos de la persona',
  `apellidos` VARCHAR(100) NOT NULL COMMENT 'Apellidos completos de la persona',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_titulares_dni` (`dni`),
  INDEX `idx_titulares_dni` (`dni`),
  INDEX `idx_titulares_nombres_apellidos` (`nombres`, `apellidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Identidad certificable - independiente de usuarios del sistema';


-- PASO 2: Agregar titular_id a users
-- Un usuario puede vincularse a un titular (opcional para admin, obligatorio para estudiantes)

ALTER TABLE `users` 
ADD COLUMN `titular_id` INT(11) NULL AFTER `id`,
ADD CONSTRAINT `fk_users_titular` 
    FOREIGN KEY (`titular_id`) 
    REFERENCES `titulares`(`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
ADD UNIQUE KEY `uk_users_titular_id` (`titular_id`);


-- PASO 3: Agregar titular_id a certificados
-- Los certificados pertenecen a titulares, no a usuarios

ALTER TABLE `certificados` 
ADD COLUMN `titular_id` INT(11) NULL AFTER `id`,
ADD COLUMN `user_id_legacy` INT(11) NULL COMMENT 'Deprecated - mantener para referencia histórica' AFTER `titular_id`;

-- Copiar user_id actual a user_id_legacy (preservar datos históricos)
UPDATE `certificados` SET `user_id_legacy` = `user_id`;

-- Crear índice temporal
ALTER TABLE `certificados`
ADD INDEX `idx_certificados_titular_id` (`titular_id`);


-- PASO 4: Agregar campos nuevos de certificados (snapshots para inmutabilidad)

ALTER TABLE `certificados`
ADD COLUMN `nombre_completo` VARCHAR(255) NULL COMMENT 'Snapshot del nombre del titular al momento de emisión' AFTER `codigo`,
ADD COLUMN `nombre_curso` VARCHAR(255) NULL COMMENT 'Snapshot del nombre del curso al momento de emisión' AFTER `nombre_completo`,
ADD COLUMN `fecha_inicio` DATE NULL COMMENT 'Fecha de inicio del curso' AFTER `fecha_emision`,
ADD COLUMN `fecha_fin` DATE NULL COMMENT 'Fecha de fin del curso' AFTER `fecha_inicio`,
ADD COLUMN `duracion_meses` INT(11) NULL COMMENT 'Duración del curso en meses' AFTER `fecha_fin`,
ADD COLUMN `nota_final` DECIMAL(5,2) NULL COMMENT 'Nota final del estudiante' AFTER `duracion_meses`,
ADD COLUMN `modulos` JSON NULL COMMENT 'Módulos del curso en formato JSON' AFTER `nota_final`;


-- ====================================
-- IMPORTANTE: Los siguientes pasos deben ejecutarse DESPUÉS de migrar los datos
-- Ver script: 05_titulares_data_migration.sql
-- ====================================

-- PASO 5 (PENDIENTE): Hacer titular_id obligatorio en certificados
-- ALTER TABLE `certificados` 
-- MODIFY COLUMN `titular_id` INT(11) NOT NULL;

-- PASO 6 (PENDIENTE): Agregar FK de certificados a titulares
-- ALTER TABLE `certificados`
-- ADD CONSTRAINT `fk_certificados_titular` 
--     FOREIGN KEY (`titular_id`) 
--     REFERENCES `titulares`(`id`) 
--     ON DELETE RESTRICT 
--     ON UPDATE CASCADE;

-- PASO 7 (PENDIENTE): Deprecar user_id en certificados (no eliminar aún)
-- ALTER TABLE `certificados`
-- DROP FOREIGN KEY `certificados_ibfk_1`;
-- ALTER TABLE `certificados`
-- DROP INDEX `idx_certificados_user_id`;

-- ====================================
-- VALIDACIONES POST-MIGRACIÓN
-- ====================================

-- Verificar estructura de titulares
SELECT 
    COUNT(*) as total_titulares,
    COUNT(DISTINCT dni) as dni_unicos
FROM titulares;

-- Verificar vinculación users -> titulares
SELECT 
    COUNT(*) as total_users,
    COUNT(titular_id) as users_con_titular
FROM users;

-- Verificar vinculación certificados -> titulares
SELECT 
    COUNT(*) as total_certificados,
    COUNT(titular_id) as certificados_con_titular
FROM certificados;

COMMIT;
