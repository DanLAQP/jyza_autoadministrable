-- Crear sección
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
VALUES ('testimonios', 'Testimonios', 'Sección de testimonios de pacientes', 9, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();

SET @section_id = (SELECT id FROM content_sections WHERE slug = 'testimonios');

DELETE FROM content_blocks WHERE section_id = @section_id;

-- Encabezado (4 bloques)
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_badge', 'text', 'TESTIMONIOS', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Lo que Dicen', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', 'Nuestras Pacientes', 3, 1, NOW(), NOW()),
(@section_id, 'descripcion', 'textarea', 'Opiniones reales de nuestras redes sociales sobre la calidez y el profesionalismo que nos define.', 4, 1, NOW(), NOW()),
(@section_id, 'cta_button_url', 'text', 'https://www.facebook.com/jyza.cmeg', 5, 1, NOW(), NOW()),

-- Testimonio 1: Marianela (7 bloques)
(@section_id, 'testimonio1_avatar', 'image', '45', 6, 1, NOW(), NOW()),
(@section_id, 'testimonio1_name', 'text', 'Marianela A.', 7, 1, NOW(), NOW()),
(@section_id, 'testimonio1_tag', 'text', 'Paciente verificada', 8, 1, NOW(), NOW()),
(@section_id, 'testimonio1_text', 'textarea', '"100% recomendado. En el Consultorio Ginecológico JYZA me atendieron de lo mejor, muchas gracias 🥺🥺"', 9, 1, NOW(), NOW()),
(@section_id, 'testimonio1_likes', 'text', '124', 10, 1, NOW(), NOW()),
(@section_id, 'testimonio1_featured', 'text', '', 11, 1, NOW(), NOW()),

-- Testimonio 2: Karito (7 bloques)
(@section_id, 'testimonio2_avatar', 'image', '46', 12, 1, NOW(), NOW()),
(@section_id, 'testimonio2_name', 'text', 'Kharitto P.', 13, 1, NOW(), NOW()),
(@section_id, 'testimonio2_tag', 'text', 'Paciente', 14, 1, NOW(), NOW()),
(@section_id, 'testimonio2_text', 'textarea', '"100% garantizado y con excelente atención de principio a fin 🙏🏼"', 15, 1, NOW(), NOW()),
(@section_id, 'testimonio2_likes', 'text', '', 16, 1, NOW(), NOW()),
(@section_id, 'testimonio2_featured', 'text', '', 17, 1, NOW(), NOW()),

-- Testimonio 3: Cori (7 bloques)
(@section_id, 'testimonio3_avatar', 'image', '47', 18, 1, NOW(), NOW()),
(@section_id, 'testimonio3_name', 'text', 'Cori D. R.', 19, 1, NOW(), NOW()),
(@section_id, 'testimonio3_tag', 'text', 'Paciente verificada', 20, 1, NOW(), NOW()),
(@section_id, 'testimonio3_text', 'textarea', '"El mejor Dr. Jesús Caycho. Top 1."', 21, 1, NOW(), NOW()),
(@section_id, 'testimonio3_likes', 'text', '11', 22, 1, NOW(), NOW()),
(@section_id, 'testimonio3_featured', 'text', '', 23, 1, NOW(), NOW()),

-- Testimonio 4: Fiorella FEATURED (7 bloques)
(@section_id, 'testimonio4_avatar', 'image', '48', 24, 1, NOW(), NOW()),
(@section_id, 'testimonio4_name', 'text', 'Fiorella B.', 25, 1, NOW(), NOW()),
(@section_id, 'testimonio4_tag', 'text', 'Paciente embarazo de alto riesgo', 26, 1, NOW(), NOW()),
(@section_id, 'testimonio4_text', 'textarea', '" Siempre estaré muy agradecida por cómo cuidaron de mí y de mi bebé en un momento muy difícil de mi embarazo de riesgo. Gracias por todo su apoyo, ahora mi bebé ya cumplió un año gracias a Dios ❤️🙏"', 27, 1, NOW(), NOW()),
(@section_id, 'testimonio4_likes', 'text', '', 28, 1, NOW(), NOW()),
(@section_id, 'testimonio4_featured', 'text', 'featured', 29, 1, NOW(), NOW()),

-- Testimonio 5: Angélica (7 bloques)
(@section_id, 'testimonio5_avatar', 'image', '49', 30, 1, NOW(), NOW()),
(@section_id, 'testimonio5_name', 'text', 'Angélica M. A. M. F.', 31, 1, NOW(), NOW()),
(@section_id, 'testimonio5_tag', 'text', 'Paciente postoperatoria', 32, 1, NOW(), NOW()),
(@section_id, 'testimonio5_text', 'textarea', '"Muchas gracias doctores, mi recuperación está siendo exitosa hasta el momento."', 33, 1, NOW(), NOW()),
(@section_id, 'testimonio5_likes', 'text', '', 34, 1, NOW(), NOW()),
(@section_id, 'testimonio5_featured', 'text', '', 35, 1, NOW(), NOW()),

-- Testimonio 6: Leydi (7 bloques)
(@section_id, 'testimonio6_avatar', 'image', '50', 36, 1, NOW(), NOW()),
(@section_id, 'testimonio6_name', 'text', 'Leydi J.', 37, 1, NOW(), NOW()),
(@section_id, 'testimonio6_tag', 'text', 'Paciente', 38, 1, NOW(), NOW()),
(@section_id, 'testimonio6_text', 'textarea', '"100% recomendado, excelente atención."', 39, 1, NOW(), NOW()),
(@section_id, 'testimonio6_likes', 'text', '', 40, 1, NOW(), NOW()),
(@section_id, 'testimonio6_featured', 'text', '', 41, 1, NOW(), NOW()),

-- Testimonio 7: Daniela (7 bloques)
(@section_id, 'testimonio7_avatar', 'image', '51', 42, 1, NOW(), NOW()),
(@section_id, 'testimonio7_name', 'text', 'Daniela D. S.', 43, 1, NOW(), NOW()),
(@section_id, 'testimonio7_tag', 'text', 'Paciente', 44, 1, NOW(), NOW()),
(@section_id, 'testimonio7_text', 'textarea', '"Súper recomendado. 🤗🤗 Excelente atención!"', 45, 1, NOW(), NOW()),
(@section_id, 'testimonio7_likes', 'text', '', 46, 1, NOW(), NOW()),
(@section_id, 'testimonio7_featured', 'text', '', 47, 1, NOW(), NOW());

-- Crear registros de imágenes
INSERT INTO content_images (section_id, original_filename, stored_filename, file_path, mime_type, uploaded_by, is_active, created, modified) VALUES
(@section_id, 'marianela.webp', 'marianela.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/marianela.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'karito.webp', 'karito.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/karito.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'cori.webp', 'cori.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/cori.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'fiorella.webp', 'fiorella.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/fiorella.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'angelica.webp', 'angelica.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/angelica.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'leydi.webp', 'leydi.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/leydi.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'daniela.webp', 'daniela.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/daniela.webp', 'image/webp', 1, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();
