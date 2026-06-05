-- Crear sección
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
VALUES ('clubjyza', 'Club JYZA', 'Sección de convenios y club JYZA', 7, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();

SET @section_id = (SELECT id FROM content_sections WHERE slug = 'clubjyza');

DELETE FROM content_blocks WHERE section_id = @section_id;

-- Encabezado (4 bloques)
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_badge', 'text', 'Red de Convenios Activos', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Cuida de los Tuyos Ahorrando', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', 'con el Club JYZA', 3, 1, NOW(), NOW()),
(@section_id, 'descripcion', 'textarea', 'El club JYZA es una comunidad exclusiva de pacientes que acceden a los mejores beneficios en nuestro establecimiento y el diferentes centros de Huánuco, solo debes de presentar tu tarjeta que te identifica como miembro', 4, 1, NOW(), NOW()),

-- Convenio 1: JYZA (14 bloques)
(@section_id, 'convenio1_image', 'image', '37', 5, 1, NOW(), NOW()),
(@section_id, 'convenio1_category', 'text', 'Ginecología', 6, 1, NOW(), NOW()),
(@section_id, 'convenio1_category_color', 'text', 'cat-gine', 7, 1, NOW(), NOW()),
(@section_id, 'convenio1_tag', 'text', 'Marca Fundadora', 8, 1, NOW(), NOW()),
(@section_id, 'convenio1_tag_color', 'text', 'tag-fundador', 9, 1, NOW(), NOW()),
(@section_id, 'convenio1_name', 'text', 'Consultorio Ginecológico JYZA', 10, 1, NOW(), NOW()),
(@section_id, 'convenio1_specialty', 'text', 'Jr dos de mayo 1600 con Pedro Puelles · 961 295 024', 11, 1, NOW(), NOW()),
(@section_id, 'convenio1_description_1', 'textarea', 'Centro especializado en el cuidado integral de la salud femenina. Somos los fundadores del Club JYZA, comprometidos con tu bienestar en cada etapa de tu vida.', 12, 1, NOW(), NOW()),
(@section_id, 'convenio1_description_2', 'textarea', 'Atención ginecológica con tecnología de vanguardia, trato cálido y enfoque en la salud preventiva y curativa de la mujer.', 13, 1, NOW(), NOW()),
(@section_id, 'convenio1_quote', 'text', 'En JYZA te queremos sana', 14, 1, NOW(), NOW()),
(@section_id, 'convenio1_benefit', 'text', '10% de descuento en todos nuestros servicios', 15, 1, NOW(), NOW()),
(@section_id, 'convenio1_benefit_color', 'text', 'pill-purple', 16, 1, NOW(), NOW()),
(@section_id, 'convenio1_facebook_url', 'text', 'https://www.facebook.com/jyza.cmeg', 17, 1, NOW(), NOW()),
(@section_id, 'convenio1_instagram_url', 'text', 'https://www.instagram.com/consultorio_ginecologico_jyza', 18, 1, NOW(), NOW()),

-- Convenio 2: Rositas (14 bloques)
(@section_id, 'convenio2_image', 'image', '38', 19, 1, NOW(), NOW()),
(@section_id, 'convenio2_category', 'text', 'Pediatría', 20, 1, NOW(), NOW()),
(@section_id, 'convenio2_category_color', 'text', 'cat-ped', 21, 1, NOW(), NOW()),
(@section_id, 'convenio2_tag', 'text', 'Marca Aliada', 22, 1, NOW(), NOW()),
(@section_id, 'convenio2_tag_color', 'text', 'tag-alianza', 23, 1, NOW(), NOW()),
(@section_id, 'convenio2_name', 'text', 'Centro Pediátrico Rositas', 24, 1, NOW(), NOW()),
(@section_id, 'convenio2_specialty', 'text', 'Jr. Mayro 250 – Huánuco · +51 952 468 349', 25, 1, NOW(), NOW()),
(@section_id, 'convenio2_description_1', 'textarea', 'Brindamos atención pediátrica especializada con calidad, calidez y compromiso con la salud de los niños de Huánuco.', 26, 1, NOW(), NOW()),
(@section_id, 'convenio2_description_2', 'textarea', 'Un espacio pensado para que los más pequeños reciban la mejor atención médica en un ambiente seguro y acogedor.', 27, 1, NOW(), NOW()),
(@section_id, 'convenio2_quote', 'text', 'Porque cada niño merece lo mejor', 28, 1, NOW(), NOW()),
(@section_id, 'convenio2_benefit', 'text', '20% de descuento en la consulta pediátrica', 29, 1, NOW(), NOW()),
(@section_id, 'convenio2_benefit_color', 'text', 'pill-amber', 30, 1, NOW(), NOW()),
(@section_id, 'convenio2_facebook_url', 'text', 'https://www.facebook.com/profile.php?id=61563956279816', 31, 1, NOW(), NOW()),
(@section_id, 'convenio2_instagram_url', 'text', '', 32, 1, NOW(), NOW()),

-- Convenio 3: Cabanillas (14 bloques)
(@section_id, 'convenio3_image', 'image', '39', 33, 1, NOW(), NOW()),
(@section_id, 'convenio3_category', 'text', 'Odontología', 34, 1, NOW(), NOW()),
(@section_id, 'convenio3_category_color', 'text', 'cat-odonto', 35, 1, NOW(), NOW()),
(@section_id, 'convenio3_tag', 'text', 'Marca Aliada', 36, 1, NOW(), NOW()),
(@section_id, 'convenio3_tag_color', 'text', 'tag-convenio', 37, 1, NOW(), NOW()),
(@section_id, 'convenio3_name', 'text', 'Clínica Dental Cabanillas', 38, 1, NOW(), NOW()),
(@section_id, 'convenio3_specialty', 'text', 'Jr. Aguilar 339 – Huánuco · 988 129 696', 39, 1, NOW(), NOW()),
(@section_id, 'convenio3_description_1', 'textarea', 'Brindamos atención odontológica integral con profesionalismo, tecnología y un trato cálido para cuidar tu sonrisa.', 40, 1, NOW(), NOW()),
(@section_id, 'convenio3_description_2', 'textarea', 'Desde limpiezas preventivas hasta tratamientos de alta complejidad, con equipos modernos y especialistas comprometidos con tu salud bucal.', 41, 1, NOW(), NOW()),
(@section_id, 'convenio3_quote', 'text', 'Tu sonrisa es nuestra especialidad', 42, 1, NOW(), NOW()),
(@section_id, 'convenio3_benefit', 'text', 'Evaluación odontológica gratuita', 43, 1, NOW(), NOW()),
(@section_id, 'convenio3_benefit_color', 'text', 'pill-green', 44, 1, NOW(), NOW()),
(@section_id, 'convenio3_facebook_url', 'text', 'https://www.facebook.com/Clinica.Cabanillas', 45, 1, NOW(), NOW()),
(@section_id, 'convenio3_instagram_url', 'text', 'https://www.instagram.com/dental.cabanillas', 46, 1, NOW(), NOW()),

-- Convenio 4: Baby Shark (14 bloques)
(@section_id, 'convenio4_image', 'image', '40', 47, 1, NOW(), NOW()),
(@section_id, 'convenio4_category', 'text', 'Estimulación temprana', 48, 1, NOW(), NOW()),
(@section_id, 'convenio4_category_color', 'text', 'cat-estim', 49, 1, NOW(), NOW()),
(@section_id, 'convenio4_tag', 'text', 'Bienestar Infantil', 50, 1, NOW(), NOW()),
(@section_id, 'convenio4_tag_color', 'text', 'tag-bienest', 51, 1, NOW(), NOW()),
(@section_id, 'convenio4_name', 'text', 'Baby Shark Spa', 52, 1, NOW(), NOW()),
(@section_id, 'convenio4_specialty', 'text', 'Jr. Constitución 482 – Huánuco · +51 954 763 133', 53, 1, NOW(), NOW()),
(@section_id, 'convenio4_description_1', 'textarea', 'Especialistas en estimulación temprana, promoviendo el desarrollo físico, cognitivo y emocional del bebé en un ambiente seguro y lúdico.', 54, 1, NOW(), NOW()),
(@section_id, 'convenio4_description_2', 'textarea', 'Un espacio pensado para que los padres acompañen a sus hijos en sus primeras etapas de aprendizaje, fortaleciendo vínculos y potenciando sus habilidades.', 55, 1, NOW(), NOW()),
(@section_id, 'convenio4_quote', 'text', 'Cada pequeño logro, un gran paso', 56, 1, NOW(), NOW()),
(@section_id, 'convenio4_benefit', 'text', '10% de descuento en el paquete de estimulación temprana', 57, 1, NOW(), NOW()),
(@section_id, 'convenio4_benefit_color', 'text', 'pill-amber', 58, 1, NOW(), NOW()),
(@section_id, 'convenio4_facebook_url', 'text', 'https://www.facebook.com/profile.php?id=61571776081114', 59, 1, NOW(), NOW()),
(@section_id, 'convenio4_instagram_url', 'text', 'https://www.instagram.com/baby_sharkspa', 60, 1, NOW(), NOW());

-- Crear registros de imágenes
INSERT INTO content_images (section_id, original_filename, stored_filename, file_path, mime_type, uploaded_by, is_active, created, modified) VALUES
(@section_id, 'jyzaicon_1.webp', 'jyzaicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/jyzaicon_1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'rositasicon_1.webp', 'rositasicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/rositasicon_1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'cabanillasicon_1.webp', 'cabanillasicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/cabanillasicon_1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'sharkicon_1.webp', 'sharkicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/sharkicon_1.webp', 'image/webp', 1, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();
