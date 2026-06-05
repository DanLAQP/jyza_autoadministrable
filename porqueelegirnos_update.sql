-- Actualizar bloques para PorQueElegirnos si ya existen, o insertar nuevos

-- Obtener el ID de la sección
SET @section_id = (SELECT `id` FROM `content_sections` WHERE `slug` = 'porqueelegirnos');

-- Si no existe, crearla
IF @section_id IS NULL THEN
  INSERT INTO `content_sections` (`slug`, `title`, `description`, `metadata`, `is_active`, `sort_order`, `created_by`, `created`, `modified`)
  VALUES (
      'porqueelegirnos',
      'Por Qué Elegirnos',
      'Sección que muestra los beneficios y razones para elegir JYZA',
      NULL,
      1,
      2,
      1,
      NOW(),
      NOW()
  );
  SET @section_id = LAST_INSERT_ID();
END IF;

-- Eliminar bloques antiguos si existen
DELETE FROM `content_blocks` WHERE `section_id` = @section_id;

-- Insertar bloques de contenido nuevos

-- Bloque: Label de la sección
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'section_label', 'text', 'Por qué elegirnos', NULL, 1, 1, NOW(), NOW());

-- Bloque: Título principal
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'titulo', 'text', 'Tu Bienestar es Nuestra Prioridad', NULL, 2, 1, NOW(), NOW());

-- Bloque: Descripción
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'descripcion', 'text', 'En JYZA combinamos experiencia médica, tecnología de vanguardia y un trato humano excepcional para brindarte la mejor atención ginecológica.', NULL, 3, 1, NOW(), NOW());

-- Bloque: Estadística 1
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'stat_1_number', 'text', '10+', '{"label":"Años de experiencia"}', 4, 1, NOW(), NOW());

-- Bloque: Estadística 2
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'stat_2_number', 'text', '10,000+', '{"label":"Pacientes atendidos"}', 5, 1, NOW(), NOW());

-- Bloque: Estadística 3
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'stat_3_number', 'text', '98%', '{"label":"Satisfacción"}', 6, 1, NOW(), NOW());

-- Bloque: Estadística 4
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'stat_4_number', 'text', '100%', '{"label":"Atención personalizada"}', 7, 1, NOW(), NOW());

-- Bloque: Feature 1
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'feature_1_text', 'text', 'Equipos de ultrasonido 5D de última generación.', NULL, 8, 1, NOW(), NOW());

-- Bloque: Feature 2
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'feature_2_text', 'text', 'Laboratorio clínico especializado.', NULL, 9, 1, NOW(), NOW());

-- Bloque: Feature 3
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'feature_3_text', 'text', 'Instalaciones modernas con ambiente cálido y relajado.', NULL, 10, 1, NOW(), NOW());

-- Bloques de imágenes para la galería (TIPO IMAGE - EDITABLE)
-- Imagen 1 bloque
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'img_1', 'image', '1', NULL, 11, 1, NOW(), NOW());

-- Imagen 2 bloque
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'img_2', 'image', '2', NULL, 12, 1, NOW(), NOW());

-- Imagen 3 bloque
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'img_3', 'image', '3', NULL, 13, 1, NOW(), NOW());

-- Imagen 4 bloque
INSERT INTO `content_blocks` (`section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`)
VALUES (@section_id, 'img_4', 'image', '4', NULL, 14, 1, NOW(), NOW());

-- Eliminar imágenes antiguas si existen
DELETE FROM `content_images` WHERE `section_id` = @section_id;

-- Insertar imágenes de la galería
-- Imagen 1
INSERT INTO `content_images` (`section_id`, `block_id`, `original_filename`, `stored_filename`, `file_path`, `file_size`, `mime_type`, `alt_text`, `title`, `uploaded_by`, `is_active`, `created`, `modified`)
VALUES (
    @section_id,
    NULL,
    'imag1.webp',
    'imag1.webp',
    '/imag1.webp',
    NULL,
    'image/webp',
    'Doctor con equipo médico',
    'Doctor con equipo médico',
    1,
    1,
    NOW(),
    NOW()
);

-- Imagen 2
INSERT INTO `content_images` (`section_id`, `block_id`, `original_filename`, `stored_filename`, `file_path`, `file_size`, `mime_type`, `alt_text`, `title`, `uploaded_by`, `is_active`, `created`, `modified`)
VALUES (
    @section_id,
    NULL,
    'imag2.webp',
    'imag2.webp',
    '/imag2.webp',
    NULL,
    'image/webp',
    'Equipo quirúrgico',
    'Equipo quirúrgico',
    1,
    1,
    NOW(),
    NOW()
);

-- Imagen 3
INSERT INTO `content_images` (`section_id`, `block_id`, `original_filename`, `stored_filename`, `file_path`, `file_size`, `mime_type`, `alt_text`, `title`, `uploaded_by`, `is_active`, `created`, `modified`)
VALUES (
    @section_id,
    NULL,
    'imag3.webp',
    'imag3.webp',
    '/imag3.webp',
    NULL,
    'image/webp',
    'Sala de operaciones',
    'Sala de operaciones',
    1,
    1,
    NOW(),
    NOW()
);

-- Imagen 4
INSERT INTO `content_images` (`section_id`, `block_id`, `original_filename`, `stored_filename`, `file_path`, `file_size`, `mime_type`, `alt_text`, `title`, `uploaded_by`, `is_active`, `created`, `modified`)
VALUES (
    @section_id,
    NULL,
    'imag4.webp',
    'imag4.webp',
    '/imag4.webp',
    NULL,
    'image/webp',
    'Doctor en cirugía',
    'Doctor en cirugía',
    1,
    1,
    NOW(),
    NOW()
);

-- Invalidar cache
DELETE FROM `content_cache` WHERE `section_slug` = 'porqueelegirnos';
