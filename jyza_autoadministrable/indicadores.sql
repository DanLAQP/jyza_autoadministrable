-- Agregar sección Indicadores si no existe
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
SELECT 'indicadores', 'Indicadores', 'Sección de indicadores y estadísticas', 10, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM content_sections WHERE slug = 'indicadores');

-- Obtener el ID de la sección
SET @section_id = (SELECT id FROM content_sections WHERE slug = 'indicadores');

-- Eliminar bloques existentes para esta sección (si existen)
DELETE FROM content_blocks WHERE section_id = @section_id;

-- Insertar bloques para Indicadores
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'stat_1_number', 'text', '10', 1, 1, NOW(), NOW()),
(@section_id, 'stat_1_symbol', 'text', '+', 2, 1, NOW(), NOW()),
(@section_id, 'stat_1_label', 'text', 'Años de Experiencia', 3, 1, NOW(), NOW()),
(@section_id, 'stat_2_number', 'text', '5000', 4, 1, NOW(), NOW()),
(@section_id, 'stat_2_symbol', 'text', '+', 5, 1, NOW(), NOW()),
(@section_id, 'stat_2_label', 'text', 'Pacientes Atendidos', 6, 1, NOW(), NOW()),
(@section_id, 'stat_3_number', 'text', '98', 7, 1, NOW(), NOW()),
(@section_id, 'stat_3_symbol', 'text', '%', 8, 1, NOW(), NOW()),
(@section_id, 'stat_3_label', 'text', 'Satisfacción', 9, 1, NOW(), NOW());
