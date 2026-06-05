-- Agregar bloques de redes sociales para Doctor 1
INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES
((SELECT id FROM content_sections WHERE slug = 'especialistas'), 'doctor1_tiktok_url', 'text', 'https://www.tiktok.com/@jyza.ginecologia', 15, 1, NOW(), NOW()),
((SELECT id FROM content_sections WHERE slug = 'especialistas'), 'doctor1_facebook_url', 'text', 'https://www.facebook.com/jyza.cmeg', 16, 1, NOW(), NOW()),
((SELECT id FROM content_sections WHERE slug = 'especialistas'), 'doctor1_instagram_url', 'text', 'https://www.instagram.com/consultorio_ginecologico_jyza', 17, 1, NOW(), NOW()),

-- Agregar bloques de redes sociales para Doctor 2
((SELECT id FROM content_sections WHERE slug = 'especialistas'), 'doctor2_tiktok_url', 'text', 'https://www.tiktok.com/@jyza.ginecologia', 25, 1, NOW(), NOW()),
((SELECT id FROM content_sections WHERE slug = 'especialistas'), 'doctor2_facebook_url', 'text', 'https://www.facebook.com/jyza.cmeg', 26, 1, NOW(), NOW()),
((SELECT id FROM content_sections WHERE slug = 'especialistas'), 'doctor2_instagram_url', 'text', 'https://www.instagram.com/consultorio_ginecologico_jyza', 27, 1, NOW(), NOW());
