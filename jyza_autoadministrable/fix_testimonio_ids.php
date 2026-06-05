<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$mysqli->set_charset('utf8mb4');

$section = $mysqli->query("SELECT id FROM content_sections WHERE slug = 'testimonios'")->fetch_assoc();
$sectionId = $section['id'];

// Mapeo de testimonios a IDs de imagen
$mapping = [
    'testimonio1_avatar' => 69,
    'testimonio2_avatar' => 70,
    'testimonio3_avatar' => 71,
    'testimonio4_avatar' => 72,
    'testimonio5_avatar' => 73,
    'testimonio6_avatar' => 74,
    'testimonio7_avatar' => 75,
];

foreach ($mapping as $blockKey => $imageId) {
    $mysqli->query("UPDATE content_blocks SET content = '$imageId' WHERE section_id = $sectionId AND block_key = '$blockKey'");
}

$mysqli->close();
echo "✅ IDs de imagen corregidos\n";
?>
