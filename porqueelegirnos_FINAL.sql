-- ============================================
-- SETUP SECCIÓN: POR QUÉ ELEGIRNOS
-- ============================================

-- 1. Eliminar datos viejos si existen
DELETE FROM `content_blocks` WHERE `section_id` IN (
    SELECT `id` FROM `content_sections` WHERE `slug` = 'porqueelegirnos'
);

DELETE FROM `content_images` WHERE `section_id` IN (
    SELECT `id` FROM `content_sections` WHERE `slug` = 'porqueelegirnos'
);

DELETE FROM `content_sections` WHERE `slug` = 'porqueelegirnos';

-- 2. Crear la sección
INSERT INTO `content_sections` (`slug`, `title`, `description`, `is_active`, `sort_order`, `created_by`, `created`, `modified`)
VALUES (
    'porqueelegirnos',
    'Por Qué Elegirnos',
    'Sección que muestra los beneficios y razones para elegir JYZA',
    1,
    2,
    1,
    NOW(),
    NOW()
);

-- Obtener el ID de la sección recién creada
SET @section_id = LAST_INSERT_ID();

-- 3. Insertar bloques de contenido
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES
    (@section_id, 'section_label', 'text', 'Por qué elegirnos', NULL, 1, 1, NOW(), NOW()),
    (@section_id, 'titulo', 'text', 'Tu Bienestar es Nuestra Prioridad', NULL, 2, 1, NOW(), NOW()),
    (@section_id, 'descripcion', 'text', 'En JYZA combinamos experiencia médica, tecnología de vanguardia y un trato humano excepcional para brindarte la mejor atención ginecológica.', NULL, 3, 1, NOW(), NOW()),
    (@section_id, 'stat_1_number', 'text', '10+', '{"label":"Años de experiencia"}', 4, 1, NOW(), NOW()),
    (@section_id, 'stat_2_number', 'text', '10,000+', '{"label":"Pacientes atendidos"}', 5, 1, NOW(), NOW()),
    (@section_id, 'stat_3_number', 'text', '98%', '{"label":"Satisfacción"}', 6, 1, NOW(), NOW()),
    (@section_id, 'stat_4_number', 'text', '100%', '{"label":"Atención personalizada"}', 7, 1, NOW(), NOW()),
    (@section_id, 'feature_1_text', 'text', 'Equipos de ultrasonido 5D de última generación.', NULL, 8, 1, NOW(), NOW()),
    (@section_id, 'feature_2_text', 'text', 'Laboratorio clínico especializado.', NULL, 9, 1, NOW(), NOW()),
    (@section_id, 'feature_3_text', 'text', 'Instalaciones modernas con ambiente cálido y relajado.', NULL, 10, 1, NOW(), NOW()),
    (@section_id, 'img_1', 'image', '1', NULL, 11, 1, NOW(), NOW()),
    (@section_id, 'img_2', 'image', '2', NULL, 12, 1, NOW(), NOW()),
    (@section_id, 'img_3', 'image', '3', NULL, 13, 1, NOW(), NOW()),
    (@section_id, 'img_4', 'image', '4', NULL, 14, 1, NOW(), NOW());

-- 4. Insertar imágenes para la galería
INSERT INTO `content_images` (`section_id`, `original_filename`, `stored_filename`, `file_path`, `mime_type`, `alt_text`, `title`, `uploaded_by`, `is_active`, `created`, `modified`)
VALUES
    (@section_id, 'imag1.webp', 'imag1.webp', '/imag1.webp', 'image/webp', 'Doctor con equipo médico', 'Doctor con equipo médico', 1, 1, NOW(), NOW()),
    (@section_id, 'imag2.webp', 'imag2.webp', '/imag2.webp', 'image/webp', 'Equipo quirúrgico', 'Equipo quirúrgico', 1, 1, NOW(), NOW()),
    (@section_id, 'imag3.webp', 'imag3.webp', '/imag3.webp', 'image/webp', 'Sala de operaciones', 'Sala de operaciones', 1, 1, NOW(), NOW()),
    (@section_id, 'imag4.webp', 'imag4.webp', '/imag4.webp', 'image/webp', 'Doctor en cirugía', 'Doctor en cirugía', 1, 1, NOW(), NOW());

-- 5. Limpiar caché
DELETE FROM `content_cache` WHERE `section_slug` = 'porqueelegirnos';

-- Confirmación
SELECT '✅ Sección PorQueElegirnos creada exitosamente' AS status;
SELECT CONCAT('📊 Sección ID: ', @section_id) AS info;
SELECT CONCAT('📝 Total bloques: ', COUNT(*)) AS info FROM `content_blocks` WHERE `section_id` = @section_id;
SELECT CONCAT('🖼️ Total imágenes: ', COUNT(*)) AS info FROM `content_images` WHERE `section_id` = @section_id;
