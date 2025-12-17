-- ====================================
-- FINALIZACIÓN DE MIGRACIÓN: HACER TITULAR_ID OBLIGATORIO
-- Fecha: 15 de diciembre de 2025
-- Propósito: Hacer obligatorio el campo titular_id en certificados
-- IMPORTANTE: Ejecutar DESPUÉS de 05_titulares_data_migration.sql
-- Y verificar que todos los certificados tienen titular_id
-- ====================================

START TRANSACTION;

-- ====================================
-- VALIDACIÓN PRE-REQUISITO
-- ====================================

-- Verificar que NO existen certificados sin titular
SELECT 
    @certificados_sin_titular := COUNT(*)
FROM certificados 
WHERE titular_id IS NULL;

-- Si hay certificados sin titular, el script debe detenerse
SELECT 
    CASE 
        WHEN @certificados_sin_titular > 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'ERROR: Existen certificados sin titular_id. Ejecutar migración de datos primero.';
        ELSE
            'OK: Todos los certificados tienen titular_id'
    END AS validacion;


-- ====================================
-- PASO 1: Hacer titular_id obligatorio en certificados
-- ====================================

ALTER TABLE `certificados` 
MODIFY COLUMN `titular_id` INT(11) NOT NULL COMMENT 'FK a titulares - identidad certificable';


-- ====================================
-- PASO 2: Agregar FK de certificados a titulares
-- ====================================

ALTER TABLE `certificados`
ADD CONSTRAINT `fk_certificados_titular` 
    FOREIGN KEY (`titular_id`) 
    REFERENCES `titulares`(`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE;


-- ====================================
-- PASO 3: Deprecar user_id en certificados (mantener para referencia)
-- ====================================

-- Eliminar FK de user_id (ya no es la verdad lógica)
ALTER TABLE `certificados`
DROP FOREIGN KEY `certificados_ibfk_1`;

-- Eliminar índice de user_id
ALTER TABLE `certificados`
DROP INDEX `idx_certificados_user_id`;

-- Renombrar user_id a user_id_legacy (ya está hecho en migración anterior)
-- ALTER TABLE `certificados` CHANGE `user_id` `user_id_legacy` INT(11) NULL;

-- Agregar comentario explicativo
ALTER TABLE `certificados`
MODIFY COLUMN `user_id_legacy` INT(11) NULL 
COMMENT 'DEPRECATED: Usar titular_id. Mantenido solo para referencia histórica';


-- ====================================
-- VALIDACIONES POST-FINALIZACIÓN
-- ====================================

-- 1. Verificar estructura de certificados
SHOW COLUMNS FROM certificados LIKE 'titular_id';
-- Debe mostrar: NOT NULL, con FK a titulares

-- 2. Verificar que todas las FKs están correctas
SELECT 
    CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'certificados'
  AND REFERENCED_TABLE_NAME IS NOT NULL;
-- Debe incluir: fk_certificados_titular -> titulares.id

-- 3. Verificar integridad referencial
SELECT 
    'Integridad certificados->titulares' AS validacion,
    COUNT(*) AS total_certificados,
    COUNT(DISTINCT titular_id) AS titulares_unicos,
    CASE 
        WHEN COUNT(*) = COUNT(c.titular_id) THEN 'OK: Todos tienen titular'
        ELSE CONCAT('ERROR: ', COUNT(*) - COUNT(c.titular_id), ' sin titular')
    END AS resultado
FROM certificados c;

-- 4. Verificar certificados huérfanos (no deberían existir)
SELECT 
    'Certificados huérfanos' AS validacion,
    COUNT(*) AS total
FROM certificados c
LEFT JOIN titulares t ON c.titular_id = t.id
WHERE t.id IS NULL;
-- Resultado esperado: 0

COMMIT;

-- ====================================
-- RESUMEN DE ARQUITECTURA FINAL
-- ====================================

/*
NUEVA ESTRUCTURA:

titulares (NUEVA)
├── id (PK)
├── dni (UNIQUE)
├── nombres
├── apellidos
├── created
└── modified

users (MODIFICADA)
├── id (PK)
├── titular_id (FK -> titulares.id, UNIQUE, NULLABLE)
├── username
├── password
├── rol
├── dni
├── estado
├── created
└── modified

certificados (MODIFICADA)
├── id (PK)
├── titular_id (FK -> titulares.id, NOT NULL) ← NUEVA VERDAD LÓGICA
├── user_id_legacy (NULL, sin FK) ← DEPRECATED
├── curso_id (FK -> cursos.id)
├── codigo (UNIQUE)
├── nombre_completo (snapshot)
├── nombre_curso (snapshot)
├── horas
├── fecha_emision
├── fecha_inicio
├── fecha_fin
├── duracion_meses
├── nota_final
├── modulos (JSON)
├── archivo_pdf
├── estado
├── created
└── modified

RELACIONES:
- Certificado → Titular (obligatorio, un certificado pertenece a un titular)
- Usuario → Titular (opcional, un usuario puede vincularse a un titular)
- Titular ← Certificados (un titular puede tener múltiples certificados)
- Titular ← Usuario (un titular puede tener máximo un usuario vinculado)

BENEFICIOS:
✓ Certificados independientes de usuarios del sistema
✓ Usuarios heredan certificados al vincularse
✓ Datos certificados inmutables (snapshots)
✓ Verificación pública robusta
✓ Sin usuarios fantasma
✓ Escalable para producción
*/
