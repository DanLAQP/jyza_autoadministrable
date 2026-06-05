-- Agregar sección Agendamiento si no existe
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
SELECT 'agendamiento', 'Agendamiento', 'Sección de agendamiento de citas', 8, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM content_sections WHERE slug = 'agendamiento');

-- Obtener el ID de la sección
SET @section_id = (SELECT id FROM content_sections WHERE slug = 'agendamiento');

-- Eliminar bloques existentes para esta sección (si existen)
DELETE FROM content_blocks WHERE section_id = @section_id;

-- Insertar bloques para Agendamiento
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'titulo', 'text', '¿Lista para agendar tu consulta?', 1, 1, NOW(), NOW()),
(@section_id, 'descripcion', 'textarea', 'Nuestro equipo está listo para atenderte. Agenda tu cita en línea o llámanos directamente. Primera consulta con 20% de descuento.', 2, 1, NOW(), NOW()),
(@section_id, 'cta_button_text', 'text', 'Agendar Consulta', 3, 1, NOW(), NOW()),
(@section_id, 'cta_button_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta', 4, 1, NOW(), NOW()),
(@section_id, 'telefono_numero', 'text', '961 295 024', 5, 1, NOW(), NOW()),
(@section_id, 'telefono_url', 'text', 'tel:+51961295024', 6, 1, NOW(), NOW()),
(@section_id, 'horarios_titulo', 'text', 'Horarios de Atención', 7, 1, NOW(), NOW()),
(@section_id, 'horario_1_dia', 'text', 'Lunes a Domingo', 8, 1, NOW(), NOW()),
(@section_id, 'horario_1_horas', 'text', '8 am - 9 pm', 9, 1, NOW(), NOW()),
(@section_id, 'horario_2_dia', 'text', 'Atencion personalizada', 10, 1, NOW(), NOW()),
(@section_id, 'horario_2_horas', 'text', '100%', 11, 1, NOW(), NOW()),
(@section_id, 'direccion', 'textarea', 'Jirón Dos de Mayo 1600 con Pedro Puelles, esquina del Parque Amarilis, Huánuco', 12, 1, NOW(), NOW());
