-- Agregar sección ComoLlegar si no existe
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
SELECT 'comollegar', 'Cómo Llegar', 'Sección de ubicación y mapa', 9, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM content_sections WHERE slug = 'comollegar');

-- Obtener el ID de la sección
SET @section_id = (SELECT id FROM content_sections WHERE slug = 'comollegar');

-- Eliminar bloques existentes para esta sección (si existen)
DELETE FROM content_blocks WHERE section_id = @section_id;

-- Insertar bloques para ComoLlegar
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_label', 'text', 'Cómo Llegar', 1, 1, NOW(), NOW()),
(@section_id, 'titulo', 'text', 'Encuéntranos Fácilmente', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_highlight_word', 'text', 'Fácilmente', 3, 1, NOW(), NOW()),
(@section_id, 'subtitulo', 'textarea', 'Estamos en una zona céntrica y accesible para tu comodidad.', 4, 1, NOW(), NOW()),
(@section_id, 'map_url', 'textarea', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3930.1069284256373!2d-76.24007962408443!3d-9.925052106035078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a7c326047a94db%3A0x9861c485037915b!2sConsultorio%20Ginecol%C3%B3gico%20JYZA!5e0!3m2!1ses!2spe!4v1774586756495!5m2!1ses!2spe', 5, 1, NOW(), NOW());
