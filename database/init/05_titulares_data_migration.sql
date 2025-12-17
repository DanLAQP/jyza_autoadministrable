-- ====================================
-- MIGRACIÓN DE DATOS: CERTIFICADOS → TITULARES
-- Fecha: 15 de diciembre de 2025
-- Propósito: Crear titulares a partir de certificados existentes
-- IMPORTANTE: Ejecutar DESPUÉS de 04_titulares_migration.sql
-- ====================================

START TRANSACTION;

-- ====================================
-- PASO 1: Crear titulares a partir de certificados existentes
-- ====================================

-- Este script crea un titular por cada combinación única de (user_id, nombre_completo)
-- Si el certificado tiene user_id, usa el DNI del usuario
-- Si no tiene user_id, genera DNI temporal

INSERT INTO titulares (dni, nombres, apellidos, created, modified)
SELECT DISTINCT
    -- DNI: usar el del usuario si existe, sino generar temporal
    COALESCE(
        u.dni, 
        CONCAT('TEMP-CERT-', c.id)
    ) AS dni,
    
    -- Nombres: extraer primeras 2 palabras del nombre completo
    CASE 
        WHEN c.nombre_completo IS NULL OR c.nombre_completo = '' THEN 'Por Definir'
        WHEN LENGTH(c.nombre_completo) - LENGTH(REPLACE(c.nombre_completo, ' ', '')) >= 2 THEN
            SUBSTRING_INDEX(c.nombre_completo, ' ', 2)
        WHEN LENGTH(c.nombre_completo) - LENGTH(REPLACE(c.nombre_completo, ' ', '')) = 1 THEN
            SUBSTRING_INDEX(c.nombre_completo, ' ', 1)
        ELSE c.nombre_completo
    END AS nombres,
    
    -- Apellidos: resto de las palabras del nombre completo
    CASE 
        WHEN c.nombre_completo IS NULL OR c.nombre_completo = '' THEN 'Por Definir'
        WHEN LENGTH(c.nombre_completo) - LENGTH(REPLACE(c.nombre_completo, ' ', '')) >= 2 THEN
            SUBSTRING(c.nombre_completo, LENGTH(SUBSTRING_INDEX(c.nombre_completo, ' ', 2)) + 2)
        WHEN LENGTH(c.nombre_completo) - LENGTH(REPLACE(c.nombre_completo, ' ', '')) = 1 THEN
            SUBSTRING(c.nombre_completo, LENGTH(SUBSTRING_INDEX(c.nombre_completo, ' ', 1)) + 2)
        ELSE 'N/A'
    END AS apellidos,
    
    NOW() AS created,
    NOW() AS modified
FROM certificados c
LEFT JOIN users u ON c.user_id = u.id
WHERE c.nombre_completo IS NOT NULL
ON DUPLICATE KEY UPDATE modified = NOW();


-- ====================================
-- PASO 2: Actualizar certificados con titular_id
-- ====================================

-- Vincular certificados con titulares basándose en:
-- 1. Si tiene user_id: usar DNI del usuario
-- 2. Si no tiene user_id: usar DNI temporal generado

UPDATE certificados c
LEFT JOIN users u ON c.user_id = u.id
INNER JOIN titulares t ON (
    -- Coincide por DNI del usuario
    t.dni = COALESCE(u.dni, CONCAT('TEMP-CERT-', c.id))
)
SET c.titular_id = t.id
WHERE c.titular_id IS NULL;


-- ====================================
-- PASO 3: Completar snapshots de certificados (campos nuevos)
-- ====================================

-- Actualizar nombre_completo si está NULL (debería ya existir, pero por seguridad)
UPDATE certificados c
INNER JOIN titulares t ON c.titular_id = t.id
SET c.nombre_completo = CONCAT(t.nombres, ' ', t.apellidos)
WHERE c.nombre_completo IS NULL OR c.nombre_completo = '';

-- Actualizar nombre_curso desde la tabla cursos
UPDATE certificados c
INNER JOIN cursos cu ON c.curso_id = cu.id
SET c.nombre_curso = cu.titulo
WHERE c.nombre_curso IS NULL OR c.nombre_curso = '';


-- ====================================
-- PASO 4: Vincular usuarios estudiantes con titulares
-- ====================================

-- Para usuarios que tienen DNI y ese DNI existe en titulares:
UPDATE users u
INNER JOIN titulares t ON u.dni = t.dni
SET u.titular_id = t.id
WHERE u.rol = 3 
  AND u.titular_id IS NULL
  AND u.dni IS NOT NULL
  AND u.dni != ''
  AND u.dni != '00000000';


-- ====================================
-- PASO 5: Crear titulares para usuarios sin titular (estudiantes sin certificados previos)
-- ====================================

INSERT INTO titulares (dni, nombres, apellidos, created, modified)
SELECT DISTINCT
    u.dni,
    'Por Completar' AS nombres,
    'Por Completar' AS apellidos,
    NOW() AS created,
    NOW() AS modified
FROM users u
LEFT JOIN titulares t ON u.dni = t.dni
WHERE u.rol = 3
  AND u.dni IS NOT NULL
  AND u.dni != ''
  AND u.dni != '00000000'
  AND t.id IS NULL
ON DUPLICATE KEY UPDATE modified = NOW();

-- Vincular esos usuarios recién creados
UPDATE users u
INNER JOIN titulares t ON u.dni = t.dni
SET u.titular_id = t.id
WHERE u.rol = 3 
  AND u.titular_id IS NULL
  AND u.dni IS NOT NULL
  AND u.dni != ''
  AND u.dni != '00000000';


-- ====================================
-- VALIDACIONES POST-MIGRACIÓN
-- ====================================

-- 1. Verificar que todos los certificados tienen titular
SELECT 
    'Certificados sin titular' AS validacion,
    COUNT(*) AS total
FROM certificados 
WHERE titular_id IS NULL;
-- Resultado esperado: 0

-- 2. Verificar distribución de certificados por titular
SELECT 
    'Distribución de certificados' AS validacion,
    COUNT(DISTINCT titular_id) AS titulares_con_certificados,
    COUNT(*) AS total_certificados,
    ROUND(COUNT(*) / COUNT(DISTINCT titular_id), 2) AS promedio_certs_por_titular
FROM certificados
WHERE titular_id IS NOT NULL;

-- 3. Verificar estudiantes con titular
SELECT 
    'Estudiantes vinculados' AS validacion,
    COUNT(*) AS total_estudiantes,
    COUNT(titular_id) AS estudiantes_con_titular,
    COUNT(*) - COUNT(titular_id) AS estudiantes_sin_titular
FROM users
WHERE rol = 3;

-- 4. Verificar titulares creados
SELECT 
    'Total titulares' AS validacion,
    COUNT(*) AS total,
    COUNT(CASE WHEN dni LIKE 'TEMP-%' THEN 1 END) AS dni_temporales,
    COUNT(CASE WHEN dni NOT LIKE 'TEMP-%' THEN 1 END) AS dni_reales
FROM titulares;

-- 5. Ver titulares con más certificados
SELECT 
    t.id,
    t.dni,
    t.nombres,
    t.apellidos,
    COUNT(c.id) AS total_certificados,
    GROUP_CONCAT(c.codigo ORDER BY c.created DESC SEPARATOR ', ') AS codigos
FROM titulares t
INNER JOIN certificados c ON t.id = c.titular_id
GROUP BY t.id
ORDER BY total_certificados DESC
LIMIT 10;

-- 6. Ver usuarios vinculados a titulares
SELECT 
    u.id AS user_id,
    u.username,
    u.dni,
    t.id AS titular_id,
    t.nombres,
    t.apellidos,
    COUNT(c.id) AS certificados_heredados
FROM users u
INNER JOIN titulares t ON u.titular_id = t.id
LEFT JOIN certificados c ON c.titular_id = t.id
WHERE u.rol = 3
GROUP BY u.id, t.id
ORDER BY certificados_heredados DESC;

COMMIT;

-- ====================================
-- NOTAS POST-MIGRACIÓN
-- ====================================

-- 1. Si hay certificados sin titular (validación 1 > 0):
--    Revisar manualmente y crear titulares apropiados

-- 2. Si hay estudiantes sin titular (validación 3):
--    Pueden ser usuarios sin DNI o con DNI '00000000'
--    Estos necesitan completar su perfil

-- 3. DNI temporales (TEMP-CERT-X):
--    Son certificados emitidos sin usuario vinculado
--    El admin debe corregir el DNI real cuando sea posible

-- 4. Nombres "Por Completar" o "Por Definir":
--    Indicar al admin que debe actualizar datos del titular
