-- Seed para datos iniciales de prueba
-- Ejecutar en PhpMyAdmin o: mysql -u root jyza_autoadministrable < seed_content.sql

-- Insertar sección Bienvenida
INSERT INTO content_sections (slug, title, description, sort_order, is_active, created_by) VALUES
('bienvenida', 'Sección Bienvenida', 'Hero/Bienvenida de la clínica', 1, 1, 1);

-- Insertar bloques para la sección Bienvenida
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active) VALUES
(1, 'titulo', 'text', 'Tu Salud Femenina en las Mejores Manos de Huánuco', 1, 1),
(1, 'subtitulo', 'text', 'Especialización en Ginecología y Obstetricia', 2, 1),
(1, 'descripcion', 'textarea', 'Clínica especializada en ginecología y obstetricia con más de 10 años cuidando la salud integral de la mujer. Tecnología avanzada y atención personalizada.', 3, 1),
(1, 'badge_text', 'text', 'CITAS DISPONIBLES ESTA SEMANA', 4, 1),
(1, 'cta_button_text', 'text', 'Agendar Cita por WhatsApp', 5, 1),
(1, 'cta_button_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20cita', 6, 1),
(1, 'cta_secundario_text', 'text', 'Ver servicios', 7, 1),
(1, 'ubicacion', 'text', 'Jr. Dos de Mayo 1600 - Parque Amarilis, Huanuco', 8, 1),
(1, 'horarios', 'text', 'Lunes a Domingo: 8:00 am - 9:00 pm', 9, 1),
(1, 'telefono', 'text', '+51 961 295 024', 10, 1),
(1, 'seo_title', 'text', 'Clínica Ginecología Huánuco | Especialistas en Salud Femenina', 11, 1),
(1, 'seo_description', 'text', 'Clínica de ginecología y obstetricia en Huánuco. Más de 10 años de experiencia. Tecnología avanzada y atención personalizada para la salud de la mujer.', 12, 1),
(1, 'ubicacion_detail', 'text', 'Parque Amarilis, Huanuco', 13, 1),
(1, 'horarios_detail', 'text', '8:00 am - 9:00 pm', 14, 1),
(1, 'club_button_label', 'text', 'Únete', 15, 1),
(1, 'club_button_title', 'text', 'Club JYZA', 16, 1),
(1, 'club_button_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20inscribirme%20al%20Club%20JYZA', 17, 1),
(1, 'club_button_aria', 'text', 'Inscríbete al Club JYZA por WhatsApp', 18, 1),
(1, 'hero_background_image', 'image', '', 19, 1),
(1, 'hero_background_mobile_image', 'image', '', 20, 1),
(1, 'logo_image', 'image', '', 21, 1),
(1, 'logo_mobile_image', 'image', '', 22, 1),
(1, 'button_icon_image', 'image', '', 23, 1);

-- Insertar metadatos de SEO para la sección
UPDATE content_sections SET 
metadata = JSON_OBJECT(
    'seo_title', 'Clínica Ginecología Huánuco | Especialistas en Salud Femenina',
    'seo_description', 'Clínica de ginecología y obstetricia en Huánuco. Más de 10 años de experiencia.',
    'og_image', '/og-bienvenida.png',
    'canonical', 'https://jyza.com'
)
WHERE slug = 'bienvenida';
