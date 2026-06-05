-- Crear sección si no existe
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
VALUES ('especialistas', 'Especialistas', 'Sección de especialistas médicos', 6, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();

-- Obtener el ID de la sección
SET @section_id = (SELECT id FROM content_sections WHERE slug = 'especialistas');

-- Limpiar bloques existentes
DELETE FROM content_blocks WHERE section_id = @section_id;

-- Insertar bloques de encabezado
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_label', 'text', 'Conoce a Nuestros Especialistas', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Profesionales Dedicados', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', 'a tu Cuidado y Bienestar', 3, 1, NOW(), NOW()),
(@section_id, 'descripcion', 'textarea', 'Nuestro equipo médico está liderado por especialistas con una profunda vocación de servicio. Conoce a los profesionales que te acompañarán en cada etapa.', 4, 1, NOW(), NOW()),

-- Doctor 1: Dr. Jesús
(@section_id, 'doctor1_image', 'image', '20', 5, 1, NOW(), NOW()),
(@section_id, 'doctor1_name', 'text', 'Dr. Jesús Zvi Caycho Cabrera', 6, 1, NOW(), NOW()),
(@section_id, 'doctor1_specialty', 'text', 'Ginecólogo y Obstetra', 7, 1, NOW(), NOW()),
(@section_id, 'doctor1_description_1', 'textarea', 'Con una sólida formación y años de experiencia, el Dr. Caycho lidera el Consultorio Ginecológico JYZA con la misión de ofrecer un cuidado de la salud femenina que sea a la vez profesional, tecnológico y profundamente humano.', 8, 1, NOW(), NOW()),
(@section_id, 'doctor1_description_2', 'textarea', 'Su compromiso es escucharte, entenderte y ofrecerte las mejores soluciones para tu bienestar.', 9, 1, NOW(), NOW()),
(@section_id, 'doctor1_stats_number', 'text', '5000', 10, 1, NOW(), NOW()),
(@section_id, 'doctor1_stats_label', 'text', 'pacientes satisfechos', 11, 1, NOW(), NOW()),
(@section_id, 'doctor1_rating', 'text', '4.9/5', 12, 1, NOW(), NOW()),
(@section_id, 'doctor1_quote', 'text', 'En JYZA te queremos sana', 13, 1, NOW(), NOW()),
(@section_id, 'doctor1_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20con%20el%20Dr.%20Jesus', 14, 1, NOW(), NOW()),

-- Doctor 2: Dra. Talia
(@section_id, 'doctor2_image', 'image', '21', 15, 1, NOW(), NOW()),
(@section_id, 'doctor2_name', 'text', 'Dra. Tello Rodriguez Esther', 16, 1, NOW(), NOW()),
(@section_id, 'doctor2_specialty', 'text', 'Ginecología y Obstetricia · CMP 066060 · RNE 052295', 17, 1, NOW(), NOW()),
(@section_id, 'doctor2_description_1', 'textarea', 'Su misión es acompañar a las mujeres en cada etapa de su vida, desde la adolescencia hasta la menopausia, brindando un espacio de atención segura y atención médica de vanguardia.', 18, 1, NOW(), NOW()),
(@section_id, 'doctor2_description_2', 'textarea', 'Con una formación académica de alto nivel y un enfoque humano, la Dra. Tello ofrece a cada paciente un cuidado integral en ginecología, priorizando la confianza, el respeto y el bienestar femenino.', 19, 1, NOW(), NOW()),
(@section_id, 'doctor2_stats_number', 'text', '3000', 20, 1, NOW(), NOW()),
(@section_id, 'doctor2_stats_label', 'text', 'pacientes satisfechas', 21, 1, NOW(), NOW()),
(@section_id, 'doctor2_rating', 'text', '4.9/5', 22, 1, NOW(), NOW()),
(@section_id, 'doctor2_quote', 'text', 'Mi prioridad es que te sientas cómoda y en control de tu salud.', 23, 1, NOW(), NOW()),
(@section_id, 'doctor2_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20con%20la%20Dra.%20Tello', 24, 1, NOW(), NOW()),

-- Equipo: Persona 1
(@section_id, 'team1_image', 'image', '22', 25, 1, NOW(), NOW()),
(@section_id, 'team1_name', 'text', 'Dr. Jhony Carrera Araujo', 26, 1, NOW(), NOW()),
(@section_id, 'team1_specialty', 'text', 'Médico Ginecólogo Oncólogo', 27, 1, NOW(), NOW()),
(@section_id, 'team1_description', 'textarea', 'Experto en alta complejidad oncológica y técnicas quirúrgicas de vanguardia para la salud femenina.', 28, 1, NOW(), NOW()),

-- Equipo: Persona 2
(@section_id, 'team2_image', 'image', '23', 29, 1, NOW(), NOW()),
(@section_id, 'team2_name', 'text', 'Obst. Jennifer Cervantes Cabrera', 30, 1, NOW(), NOW()),
(@section_id, 'team2_specialty', 'text', 'Psicoprofilaxis Obstétrica · COP 35627', 31, 1, NOW(), NOW()),
(@section_id, 'team2_description', 'textarea', 'Acompañamiento humano y profesional durante la gestación, parto y postparto integral.', 32, 1, NOW(), NOW()),

-- Equipo: Persona 3
(@section_id, 'team3_image', 'image', '24', 33, 1, NOW(), NOW()),
(@section_id, 'team3_name', 'text', 'Psi. Sheyla Quispe Durán', 34, 1, NOW(), NOW()),
(@section_id, 'team3_specialty', 'text', 'Psicóloga Especializada', 35, 1, NOW(), NOW()),
(@section_id, 'team3_description', 'textarea', 'Especialista en salud mental femenina y bienestar emocional en todas las etapas de la vida.', 36, 1, NOW(), NOW());

-- Crear registros de imágenes si no existen
INSERT INTO content_images (section_id, original_filename, stored_filename, file_path, mime_type, uploaded_by, is_active, created, modified) VALUES
(@section_id, 'equipo1.webp', 'equipo1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'equipo2.webp', 'equipo2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo2.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'equipo3.webp', 'equipo3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo3.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'equipo4.webp', 'equipo4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo4.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'equipo5.webp', 'equipo5.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo5.webp', 'image/webp', 1, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();
