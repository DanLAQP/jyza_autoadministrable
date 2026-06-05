-- Agregar sección ClubJyza si no existe
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
SELECT 'clubjyza', 'Club JYZA', 'Sección de convenios y alianzas', 6, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM content_sections WHERE slug = 'clubjyza');

-- Obtener el ID de la sección
SET @section_id = (SELECT id FROM content_sections WHERE slug = 'clubjyza');

-- Eliminar bloques existentes para esta sección (si existen)
DELETE FROM content_blocks WHERE section_id = @section_id;

-- ENCABEZADO
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_badge', 'text', 'Red de Convenios Activos', 0, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Cuida de los Tuyos Ahorrando', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', 'con el Club JYZA', 2, 1, NOW(), NOW()),
(@section_id, 'descripcion', 'textarea', 'El club JYZA es una comunidad exclusiva de pacientes que acceden a los mejores beneficios en nuestro establecimiento y el diferentes centros de Huánuco, solo debes de presentar tu tarjeta que te identifica como miembro', 3, 1, NOW(), NOW());

-- CONVENIOS (4 iniciales)
-- Convenio 1
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'convenio_1_image', 'text', '', 4, 1, NOW(), NOW()),
(@section_id, 'convenio_1_category', 'text', 'Ginecología', 5, 1, NOW(), NOW()),
(@section_id, 'convenio_1_category_color', 'text', 'cat-gine', 6, 1, NOW(), NOW()),
(@section_id, 'convenio_1_tag', 'text', 'Fundador', 7, 1, NOW(), NOW()),
(@section_id, 'convenio_1_tag_color', 'text', 'tag-fundador', 8, 1, NOW(), NOW()),
(@section_id, 'convenio_1_name', 'text', 'Consultorio JYZA', 9, 1, NOW(), NOW()),
(@section_id, 'convenio_1_specialty', 'text', 'Ginecología Integral', 10, 1, NOW(), NOW()),
(@section_id, 'convenio_1_description_1', 'textarea', 'Descripción 1', 11, 1, NOW(), NOW()),
(@section_id, 'convenio_1_description_2', 'textarea', 'Descripción 2', 12, 1, NOW(), NOW()),
(@section_id, 'convenio_1_quote', 'text', 'Cotización especial', 13, 1, NOW(), NOW()),
(@section_id, 'convenio_1_benefit', 'text', '20% descuento', 14, 1, NOW(), NOW()),
(@section_id, 'convenio_1_benefit_color', 'text', 'pill-purple', 15, 1, NOW(), NOW()),
(@section_id, 'convenio_1_facebook_url', 'text', '', 16, 1, NOW(), NOW()),
(@section_id, 'convenio_1_instagram_url', 'text', '', 17, 1, NOW(), NOW());

-- Convenio 2
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'convenio_2_image', 'text', '', 18, 1, NOW(), NOW()),
(@section_id, 'convenio_2_category', 'text', 'Pediatría', 19, 1, NOW(), NOW()),
(@section_id, 'convenio_2_category_color', 'text', 'cat-ped', 20, 1, NOW(), NOW()),
(@section_id, 'convenio_2_tag', 'text', 'Alianza', 21, 1, NOW(), NOW()),
(@section_id, 'convenio_2_tag_color', 'text', 'tag-alianza', 22, 1, NOW(), NOW()),
(@section_id, 'convenio_2_name', 'text', 'Centro Pediátrico', 23, 1, NOW(), NOW()),
(@section_id, 'convenio_2_specialty', 'text', 'Pediatría General', 24, 1, NOW(), NOW()),
(@section_id, 'convenio_2_description_1', 'textarea', 'Descripción 1', 25, 1, NOW(), NOW()),
(@section_id, 'convenio_2_description_2', 'textarea', 'Descripción 2', 26, 1, NOW(), NOW()),
(@section_id, 'convenio_2_quote', 'text', 'Cotización especial', 27, 1, NOW(), NOW()),
(@section_id, 'convenio_2_benefit', 'text', '15% descuento', 28, 1, NOW(), NOW()),
(@section_id, 'convenio_2_benefit_color', 'text', 'pill-amber', 29, 1, NOW(), NOW()),
(@section_id, 'convenio_2_facebook_url', 'text', '', 30, 1, NOW(), NOW()),
(@section_id, 'convenio_2_instagram_url', 'text', '', 31, 1, NOW(), NOW());

-- Convenio 3
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'convenio_3_image', 'text', '', 32, 1, NOW(), NOW()),
(@section_id, 'convenio_3_category', 'text', 'Odontología', 33, 1, NOW(), NOW()),
(@section_id, 'convenio_3_category_color', 'text', 'cat-odonto', 34, 1, NOW(), NOW()),
(@section_id, 'convenio_3_tag', 'text', 'Convenio', 35, 1, NOW(), NOW()),
(@section_id, 'convenio_3_tag_color', 'text', 'tag-convenio', 36, 1, NOW(), NOW()),
(@section_id, 'convenio_3_name', 'text', 'Clínica Dental', 37, 1, NOW(), NOW()),
(@section_id, 'convenio_3_specialty', 'text', 'Odontología General', 38, 1, NOW(), NOW()),
(@section_id, 'convenio_3_description_1', 'textarea', 'Descripción 1', 39, 1, NOW(), NOW()),
(@section_id, 'convenio_3_description_2', 'textarea', 'Descripción 2', 40, 1, NOW(), NOW()),
(@section_id, 'convenio_3_quote', 'text', 'Cotización especial', 41, 1, NOW(), NOW()),
(@section_id, 'convenio_3_benefit', 'text', '25% descuento', 42, 1, NOW(), NOW()),
(@section_id, 'convenio_3_benefit_color', 'text', 'pill-green', 43, 1, NOW(), NOW()),
(@section_id, 'convenio_3_facebook_url', 'text', '', 44, 1, NOW(), NOW()),
(@section_id, 'convenio_3_instagram_url', 'text', '', 45, 1, NOW(), NOW());

-- Convenio 4
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'convenio_4_image', 'text', '', 46, 1, NOW(), NOW()),
(@section_id, 'convenio_4_category', 'text', 'Estética', 47, 1, NOW(), NOW()),
(@section_id, 'convenio_4_category_color', 'text', 'cat-estim', 48, 1, NOW(), NOW()),
(@section_id, 'convenio_4_tag', 'text', 'Bienestar', 49, 1, NOW(), NOW()),
(@section_id, 'convenio_4_tag_color', 'text', 'tag-bienest', 50, 1, NOW(), NOW()),
(@section_id, 'convenio_4_name', 'text', 'Centro Estético', 51, 1, NOW(), NOW()),
(@section_id, 'convenio_4_specialty', 'text', 'Medicina Estética', 52, 1, NOW(), NOW()),
(@section_id, 'convenio_4_description_1', 'textarea', 'Descripción 1', 53, 1, NOW(), NOW()),
(@section_id, 'convenio_4_description_2', 'textarea', 'Descripción 2', 54, 1, NOW(), NOW()),
(@section_id, 'convenio_4_quote', 'text', 'Cotización especial', 55, 1, NOW(), NOW()),
(@section_id, 'convenio_4_benefit', 'text', '30% descuento', 56, 1, NOW(), NOW()),
(@section_id, 'convenio_4_benefit_color', 'text', 'pill-purple', 57, 1, NOW(), NOW()),
(@section_id, 'convenio_4_facebook_url', 'text', '', 58, 1, NOW(), NOW()),
(@section_id, 'convenio_4_instagram_url', 'text', '', 59, 1, NOW(), NOW());
