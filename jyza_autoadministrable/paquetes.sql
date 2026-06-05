-- Crear sección
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
VALUES ('paquetes', 'Paquetes', 'Sección de paquetes promocionales', 8, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();

SET @section_id = (SELECT id FROM content_sections WHERE slug = 'paquetes');

DELETE FROM content_blocks WHERE section_id = @section_id;

-- Encabezado (3 bloques)
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_label', 'text', 'Paquetes Promocionales', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Nuestros Paquetes', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', 'Pensados para Ti', 3, 1, NOW(), NOW()),

-- Paquete 1: Chequeo Completo (13 bloques)
(@section_id, 'paquete1_image', 'image', '41', 4, 1, NOW(), NOW()),
(@section_id, 'paquete1_badge', 'text', '', 5, 1, NOW(), NOW()),
(@section_id, 'paquete1_title', 'text', 'Paquete Chequeo Completo', 6, 1, NOW(), NOW()),
(@section_id, 'paquete1_description', 'textarea', 'Ideal para la detección y prevención de cáncer de cuello uterino y evaluación completa de mamas.', 7, 1, NOW(), NOW()),
(@section_id, 'paquete1_item_1', 'text', 'Consulta Ginecológica', 8, 1, NOW(), NOW()),
(@section_id, 'paquete1_item_2', 'text', 'Ecografía Transvaginal', 9, 1, NOW(), NOW()),
(@section_id, 'paquete1_item_3', 'text', 'Ecografía de Mama', 10, 1, NOW(), NOW()),
(@section_id, 'paquete1_item_4', 'text', 'Colposcopía y Papanicolau', 11, 1, NOW(), NOW()),
(@section_id, 'paquete1_item_5', 'text', 'Reevaluación gratuita de resultados', 12, 1, NOW(), NOW()),
(@section_id, 'paquete1_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20para%20chequeo%20completo', 13, 1, NOW(), NOW()),
(@section_id, 'paquete1_button_text', 'text', 'Agendar Chequeo Completo', 14, 1, NOW(), NOW()),

-- Paquete 2: Control Mujer (13 bloques) - FEATURED
(@section_id, 'paquete2_image', 'image', '42', 15, 1, NOW(), NOW()),
(@section_id, 'paquete2_badge', 'text', 'MÁS POPULAR', 16, 1, NOW(), NOW()),
(@section_id, 'paquete2_title', 'text', 'Paquete Control Mujer', 17, 1, NOW(), NOW()),
(@section_id, 'paquete2_description', 'textarea', '¿Presentas flujo vaginal excesivo o mal olor? Este paquete es para ti.', 18, 1, NOW(), NOW()),
(@section_id, 'paquete2_item_1', 'text', 'Consulta Ginecológica', 19, 1, NOW(), NOW()),
(@section_id, 'paquete2_item_2', 'text', 'Ecografía Transvaginal', 20, 1, NOW(), NOW()),
(@section_id, 'paquete2_item_3', 'text', 'Papanicolau', 21, 1, NOW(), NOW()),
(@section_id, 'paquete2_item_4', 'text', 'Cultivo de secreción y Ph vaginal', 22, 1, NOW(), NOW()),
(@section_id, 'paquete2_item_5', 'text', 'Reevaluación gratuita de resultados', 23, 1, NOW(), NOW()),
(@section_id, 'paquete2_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20para%20control%20mujer', 24, 1, NOW(), NOW()),
(@section_id, 'paquete2_button_text', 'text', 'Agendar Control Mujer', 25, 1, NOW(), NOW()),

-- Paquete 3: PrevenITS (13 bloques)
(@section_id, 'paquete3_image', 'image', '43', 26, 1, NOW(), NOW()),
(@section_id, 'paquete3_badge', 'text', '', 27, 1, NOW(), NOW()),
(@section_id, 'paquete3_title', 'text', 'Paquete PrevenITS', 28, 1, NOW(), NOW()),
(@section_id, 'paquete3_description', 'textarea', 'Tu tranquilidad es lo primero. Descarta las Infecciones de Transmisión Sexual más comunes.', 29, 1, NOW(), NOW()),
(@section_id, 'paquete3_item_1', 'text', 'Descarte de VIH', 30, 1, NOW(), NOW()),
(@section_id, 'paquete3_item_2', 'text', 'Descarte de Sífilis', 31, 1, NOW(), NOW()),
(@section_id, 'paquete3_item_3', 'text', 'Descarte de Hepatitis B', 32, 1, NOW(), NOW()),
(@section_id, 'paquete3_item_4', 'text', 'Descarte de Gonorrea', 33, 1, NOW(), NOW()),
(@section_id, 'paquete3_item_5', 'text', 'Descarte de Tricomoniasis y Candidiasis', 34, 1, NOW(), NOW()),
(@section_id, 'paquete3_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20para%20PrevenITS', 35, 1, NOW(), NOW()),
(@section_id, 'paquete3_button_text', 'text', 'Agendar PrevenITS', 36, 1, NOW(), NOW()),

-- Paquete 4: Programa de Maternidad (13 bloques)
(@section_id, 'paquete4_image', 'image', '44', 37, 1, NOW(), NOW()),
(@section_id, 'paquete4_badge', 'text', '', 38, 1, NOW(), NOW()),
(@section_id, 'paquete4_title', 'text', 'Programa de Maternidad', 39, 1, NOW(), NOW()),
(@section_id, 'paquete4_description', 'textarea', 'Elige el plan de control prenatal que mejor se adapte a tu embarazo.', 40, 1, NOW(), NOW()),
(@section_id, 'paquete4_item_1', 'text', 'Plan Bronce', 41, 1, NOW(), NOW()),
(@section_id, 'paquete4_item_2', 'text', 'Plan Plata', 42, 1, NOW(), NOW()),
(@section_id, 'paquete4_item_3', 'text', 'Plan Oro', 43, 1, NOW(), NOW()),
(@section_id, 'paquete4_item_4', 'text', '', 44, 1, NOW(), NOW()),
(@section_id, 'paquete4_item_5', 'text', '', 45, 1, NOW(), NOW()),
(@section_id, 'paquete4_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20consultar%20sobre%20los%20planes%20de%20maternidad', 46, 1, NOW(), NOW()),
(@section_id, 'paquete4_button_text', 'text', 'Consultar sobre Planes', 47, 1, NOW(), NOW());

-- Crear registros de imágenes
INSERT INTO content_images (section_id, original_filename, stored_filename, file_path, mime_type, uploaded_by, is_active, created, modified) VALUES
(@section_id, 'paquete1.webp', 'paquete1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'paquete2.webp', 'paquete2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete2.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'paquete3.webp', 'paquete3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete3.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'paquete4.webp', 'paquete4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete4.webp', 'image/webp', 1, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();
