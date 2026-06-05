-- Crear sección
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
VALUES ('citas', 'Citas', 'Sección de agendamiento de citas', 10, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();

SET @section_id = (SELECT id FROM content_sections WHERE slug = 'citas');

DELETE FROM content_blocks WHERE section_id = @section_id;

-- Encabezado (3 bloques)
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_badge', 'text', '¡Agenda tu Cita Online!', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Agenda tu Cita en', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', '3 Simples Pasos', 3, 1, NOW(), NOW()),

-- Servicios (6 bloques)
(@section_id, 'servicio_1', 'text', 'Ginecología Integral', 4, 1, NOW(), NOW()),
(@section_id, 'servicio_2', 'text', 'Obstetricia y Atención Prenatal', 5, 1, NOW(), NOW()),
(@section_id, 'servicio_3', 'text', 'Prevención y Oncología Ginecológica', 6, 1, NOW(), NOW()),
(@section_id, 'servicio_4', 'text', 'Fertilidad y Salud Reproductiva', 7, 1, NOW(), NOW()),
(@section_id, 'servicio_5', 'text', 'Ginecología Funcional y Estética', 8, 1, NOW(), NOW()),
(@section_id, 'servicio_6', 'text', 'Cirugía ginecológica y obstétrica', 9, 1, NOW(), NOW()),

-- Especialistas (2 bloques)
(@section_id, 'especialista_1', 'text', 'Dr. Jesús Caycho', 10, 1, NOW(), NOW()),
(@section_id, 'especialista_2', 'text', 'Doctora Tello', 11, 1, NOW(), NOW()),

-- Paso 1 (3 bloques)
(@section_id, 'paso1_titulo', 'text', '¿Qué necesitas y con quién?', 12, 1, NOW(), NOW()),
(@section_id, 'paso1_subtitulo', 'text', 'Selecciona el servicio y especialista', 13, 1, NOW(), NOW()),

-- Paso 2 (2 bloques)
(@section_id, 'paso2_titulo', 'text', 'Elige la Fecha y Hora', 14, 1, NOW(), NOW()),
(@section_id, 'paso2_subtitulo', 'text', 'Los días disponibles aparecen en color', 15, 1, NOW(), NOW()),

-- Paso 3 (2 bloques)
(@section_id, 'paso3_titulo', 'text', 'Confirma tus Datos', 16, 1, NOW(), NOW()),
(@section_id, 'paso3_subtitulo', 'text', 'Ingresa tu información para la cita', 17, 1, NOW(), NOW());
