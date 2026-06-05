-- Corregir los bloques de imagen para PorQueElegirnos
-- para que apunten a los IDs correctos de imágenes

SET @section_id = (SELECT `id` FROM `content_sections` WHERE `slug` = 'porqueelegirnos');

-- Actualizar los bloques img_1, img_2, img_3, img_4
-- para que apunten a los IDs correctos de las imágenes (15, 16, 17, 18)

UPDATE `content_blocks` SET `content` = '15' WHERE `section_id` = @section_id AND `block_key` = 'img_1';
UPDATE `content_blocks` SET `content` = '16' WHERE `section_id` = @section_id AND `block_key` = 'img_2';
UPDATE `content_blocks` SET `content` = '17' WHERE `section_id` = @section_id AND `block_key` = 'img_3';
UPDATE `content_blocks` SET `content` = '18' WHERE `section_id` = @section_id AND `block_key` = 'img_4';

-- Limpiar caché
DELETE FROM `content_cache` WHERE `section_slug` = 'porqueelegirnos';

-- Confirmar
SELECT 'Bloques de imagen actualizados correctamente' AS status;
