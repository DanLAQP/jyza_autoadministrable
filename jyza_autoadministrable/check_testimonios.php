<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$mysqli->set_charset('utf8mb4');

$section = $mysqli->query("SELECT id FROM content_sections WHERE slug = 'testimonios'")->fetch_assoc();
$sectionId = $section['id'];

$result = $mysqli->query("SELECT block_key FROM content_blocks WHERE section_id = $sectionId ORDER BY sort_order");

echo "Bloques creados:\n";
$count = 0;
while ($row = $result->fetch_assoc()) {
    echo "  " . ++$count . ". " . $row['block_key'] . "\n";
}

$total = $mysqli->query("SELECT COUNT(*) as cnt FROM content_blocks WHERE section_id = $sectionId")->fetch_assoc();
echo "\nTotal bloques: " . $total['cnt'] . "\n";

$images = $mysqli->query("SELECT id, original_filename FROM content_images WHERE section_id = $sectionId ORDER BY id")->fetch_all(MYSQLI_ASSOC);
echo "\nImágenes creadas: " . count($images) . "\n";
foreach ($images as $img) {
    echo "  - ID {$img['id']}: {$img['original_filename']}\n";
}

$mysqli->close();
?>
