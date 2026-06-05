-- Crear sección
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created, modified)
VALUES ('especialidades', 'Especialidades', 'Sección de especialidades y servicios', 5, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();

SET @section_id = (SELECT id FROM content_sections WHERE slug = 'especialidades');

DELETE FROM content_blocks WHERE section_id = @section_id;

-- Encabezado (4 bloques)
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
(@section_id, 'section_label', 'text', 'Especialidades', 1, 1, NOW(), NOW()),
(@section_id, 'titulo_parte1', 'text', 'Conoce Nuestros', 2, 1, NOW(), NOW()),
(@section_id, 'titulo_parte2', 'text', 'Servicios Integrales', 3, 1, NOW(), NOW()),
(@section_id, 'descripcion', 'textarea', 'Brindamos un amplio portafolio de servicios especializados para cuidar tu salud integral.', 4, 1, NOW(), NOW()),

-- Servicio 1: Ginecología Integral (13 bloques)
(@section_id, 'service1_icon', 'image', '25', 5, 1, NOW(), NOW()),
(@section_id, 'service1_title', 'text', 'Ginecología Integral', 6, 1, NOW(), NOW()),
(@section_id, 'service1_subtitle', 'text', 'Cuidado completo de tu salud ginecológica.', 7, 1, NOW(), NOW()),
(@section_id, 'service1_detail_1', 'text', 'Salud Femenina', 8, 1, NOW(), NOW()),
(@section_id, 'service1_detail_2', 'text', 'Diagnóstico Integral', 9, 1, NOW(), NOW()),
(@section_id, 'service1_detail_3', 'text', 'Control Ginecológico', 10, 1, NOW(), NOW()),
(@section_id, 'service1_detail_4', 'text', 'Tratamiento Personalizado', 11, 1, NOW(), NOW()),
(@section_id, 'service1_carousel_image', 'image', '26', 12, 1, NOW(), NOW()),
(@section_id, 'service1_carousel_label', 'text', 'Tecnología de alta resolución', 13, 1, NOW(), NOW()),
(@section_id, 'service1_carousel_title', 'text', 'Cuidado Preventivo y Diagnóstico Preciso', 14, 1, NOW(), NOW()),
(@section_id, 'service1_carousel_tag1', 'text', 'Ecografía especializada', 15, 1, NOW(), NOW()),
(@section_id, 'service1_carousel_tag2', 'text', 'Laboratorio clínico propio', 16, 1, NOW(), NOW()),

-- Servicio 2: Obstetricia (13 bloques)
(@section_id, 'service2_icon', 'image', '27', 17, 1, NOW(), NOW()),
(@section_id, 'service2_title', 'text', 'Obstetricia y Atención Prenatal', 18, 1, NOW(), NOW()),
(@section_id, 'service2_subtitle', 'text', 'Acompañamiento en cada etapa de tu embarazo.', 19, 1, NOW(), NOW()),
(@section_id, 'service2_detail_1', 'text', 'Embarazo Seguro', 20, 1, NOW(), NOW()),
(@section_id, 'service2_detail_2', 'text', 'Ecografía Obstétrica', 21, 1, NOW(), NOW()),
(@section_id, 'service2_detail_3', 'text', 'Parto por Cesárea', 22, 1, NOW(), NOW()),
(@section_id, 'service2_detail_4', 'text', 'Monitoreo Fetal', 23, 1, NOW(), NOW()),
(@section_id, 'service2_carousel_image', 'image', '28', 24, 1, NOW(), NOW()),
(@section_id, 'service2_carousel_label', 'text', 'Ecografía prenatal en ambiente cálido', 25, 1, NOW(), NOW()),
(@section_id, 'service2_carousel_title', 'text', 'Cuidamos a Mamá y Bebé', 26, 1, NOW(), NOW()),
(@section_id, 'service2_carousel_tag1', 'text', 'Ecografía Doppler', 27, 1, NOW(), NOW()),
(@section_id, 'service2_carousel_tag2', 'text', 'Detección de riesgo precoz', 28, 1, NOW(), NOW()),

-- Servicio 3: Oncología (13 bloques)
(@section_id, 'service3_icon', 'image', '29', 29, 1, NOW(), NOW()),
(@section_id, 'service3_title', 'text', 'Prevención y Oncología Ginecológica', 30, 1, NOW(), NOW()),
(@section_id, 'service3_subtitle', 'text', 'Detección temprana de cáncer cervicouterino.', 31, 1, NOW(), NOW()),
(@section_id, 'service3_detail_1', 'text', 'VPH', 32, 1, NOW(), NOW()),
(@section_id, 'service3_detail_2', 'text', 'Papanicolaou', 33, 1, NOW(), NOW()),
(@section_id, 'service3_detail_3', 'text', 'Colposcopía', 34, 1, NOW(), NOW()),
(@section_id, 'service3_detail_4', 'text', 'Prevención: Salud Cervical', 35, 1, NOW(), NOW()),
(@section_id, 'service3_carousel_image', 'image', '30', 36, 1, NOW(), NOW()),
(@section_id, 'service3_carousel_label', 'text', 'Detección que Salva Vidas', 37, 1, NOW(), NOW()),
(@section_id, 'service3_carousel_title', 'text', 'Prevención y Oncología Ginecológica', 38, 1, NOW(), NOW()),
(@section_id, 'service3_carousel_tag1', 'text', 'Prueba molecular de VPH', 39, 1, NOW(), NOW()),
(@section_id, 'service3_carousel_tag2', 'text', 'Biopsias dirigidas', 40, 1, NOW(), NOW()),

-- Servicio 4: Fertilidad (13 bloques)
(@section_id, 'service4_icon', 'image', '31', 41, 1, NOW(), NOW()),
(@section_id, 'service4_title', 'text', 'Fertilidad y Salud Reproductiva', 42, 1, NOW(), NOW()),
(@section_id, 'service4_subtitle', 'text', 'Tecnología avanzada para tu proyecto de vida.', 43, 1, NOW(), NOW()),
(@section_id, 'service4_detail_1', 'text', 'Tratamiento de Infertilidad', 44, 1, NOW(), NOW()),
(@section_id, 'service4_detail_2', 'text', 'Reserva Ovárica', 45, 1, NOW(), NOW()),
(@section_id, 'service4_detail_3', 'text', 'Monitoreo Folicular', 46, 1, NOW(), NOW()),
(@section_id, 'service4_detail_4', 'text', 'Perfil Hormonal', 47, 1, NOW(), NOW()),
(@section_id, 'service4_carousel_image', 'image', '32', 48, 1, NOW(), NOW()),
(@section_id, 'service4_carousel_label', 'text', 'Tu Camino a la Maternidad', 49, 1, NOW(), NOW()),
(@section_id, 'service4_carousel_title', 'text', 'Fertilidad y Salud Reproductiva', 50, 1, NOW(), NOW()),
(@section_id, 'service4_carousel_tag1', 'text', 'Perfil AMH - FSH - LH', 51, 1, NOW(), NOW()),
(@section_id, 'service4_carousel_tag2', 'text', 'Monitoreo ovulatorio', 52, 1, NOW(), NOW()),

-- Servicio 5: Ginecología Funcional (13 bloques)
(@section_id, 'service5_icon', 'image', '33', 53, 1, NOW(), NOW()),
(@section_id, 'service5_title', 'text', 'Ginecología Funcional y Estética', 54, 1, NOW(), NOW()),
(@section_id, 'service5_subtitle', 'text', 'Bienestar íntimo y calidad de vida femenina.', 55, 1, NOW(), NOW()),
(@section_id, 'service5_detail_1', 'text', 'Láser CO2', 56, 1, NOW(), NOW()),
(@section_id, 'service5_detail_2', 'text', 'Hifu Vaginal', 57, 1, NOW(), NOW()),
(@section_id, 'service5_detail_3', 'text', 'Rejuvenecimiento Vaginal', 58, 1, NOW(), NOW()),
(@section_id, 'service5_detail_4', 'text', 'Incontinencia Urinaria', 59, 1, NOW(), NOW()),
(@section_id, 'service5_carousel_image', 'image', '34', 60, 1, NOW(), NOW()),
(@section_id, 'service5_carousel_label', 'text', 'Tecnología Regenerativa Avanzada', 61, 1, NOW(), NOW()),
(@section_id, 'service5_carousel_title', 'text', 'Ginecología Funcional y Estética', 62, 1, NOW(), NOW()),
(@section_id, 'service5_carousel_tag1', 'text', 'Ambulatorio y mínimamente invasivo', 63, 1, NOW(), NOW()),
(@section_id, 'service5_carousel_tag2', 'text', 'Recuperación rápida y progresiva', 64, 1, NOW(), NOW()),

-- Servicio 6: Cirugía (13 bloques)
(@section_id, 'service6_icon', 'image', '35', 65, 1, NOW(), NOW()),
(@section_id, 'service6_title', 'text', 'Cirugía Ginecológica y Soporte Diagnóstico', 66, 1, NOW(), NOW()),
(@section_id, 'service6_subtitle', 'text', 'Intervenciones precisas con tecnología de vanguardia.', 67, 1, NOW(), NOW()),
(@section_id, 'service6_detail_1', 'text', 'Cirugía Laparoscópica', 68, 1, NOW(), NOW()),
(@section_id, 'service6_detail_2', 'text', 'Histerectomía', 69, 1, NOW(), NOW()),
(@section_id, 'service6_detail_3', 'text', 'Miomectomía', 70, 1, NOW(), NOW()),
(@section_id, 'service6_detail_4', 'text', 'Cesárea', 71, 1, NOW(), NOW()),
(@section_id, 'service6_carousel_image', 'image', '36', 72, 1, NOW(), NOW()),
(@section_id, 'service6_carousel_label', 'text', 'Seguridad y Precisión Quirúrgica', 73, 1, NOW(), NOW()),
(@section_id, 'service6_carousel_title', 'text', 'Cirugía Ginecológica y Soporte Diagnóstico', 74, 1, NOW(), NOW()),
(@section_id, 'service6_carousel_tag1', 'text', 'Sala equipada y anestesia segura', 75, 1, NOW(), NOW()),
(@section_id, 'service6_carousel_tag2', 'text', 'Seguimiento hospitalario y estudio patológico', 76, 1, NOW(), NOW());

-- Crear registros de imágenes
INSERT INTO content_images (section_id, original_filename, stored_filename, file_path, mime_type, uploaded_by, is_active, created, modified) VALUES
(@section_id, 'icono1.webp', 'icono1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'especialidad1.webp', 'especialidad1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad1.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'icono2.webp', 'icono2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono2.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'especialidad2.webp', 'especialidad2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad2.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'icono3.webp', 'icono3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono3.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'especialidad3.webp', 'especialidad3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad3.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'icono4.webp', 'icono4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono4.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'especialidad4.webp', 'especialidad4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad4.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'icono5.webp', 'icono5.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono5.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'especialidad5.webp', 'especialidad5.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad5.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'icono6.webp', 'icono6.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono6.webp', 'image/webp', 1, 1, NOW(), NOW()),
(@section_id, 'especialidad6.webp', 'especialidad6.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad6.webp', 'image/webp', 1, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE modified = NOW();
