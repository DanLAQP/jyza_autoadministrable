<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$mysqli->set_charset('utf8mb4');

$section = $mysqli->query("SELECT id FROM content_sections WHERE slug = 'testimonios'")->fetch_assoc();
$sectionId = $section['id'];

$mysqli->query("INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES ($sectionId, 'testimonio8_avatar', 'image', '', 48, 1, NOW(), NOW())");
$mysqli->query("INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES ($sectionId, 'testimonio8_name', 'text', 'Paciente Anónima', 49, 1, NOW(), NOW())");
$mysqli->query("INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES ($sectionId, 'testimonio8_tag', 'text', 'Paciente', 50, 1, NOW(), NOW())");
$mysqli->query("INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES ($sectionId, 'testimonio8_text', 'textarea', '\"Puntualidad y limpieza impecable. Sin duda el mejor consultorio ginecológico.\"', 51, 1, NOW(), NOW())");
$mysqli->query("INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES ($sectionId, 'testimonio8_likes', 'text', '', 52, 1, NOW(), NOW())");
$mysqli->query("INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active, created, modified) VALUES ($sectionId, 'testimonio8_featured', 'text', '', 53, 1, NOW(), NOW())");

$mysqli->close();
echo "✅ Testimonio 8 (Anónima) agregado\n";
?>
