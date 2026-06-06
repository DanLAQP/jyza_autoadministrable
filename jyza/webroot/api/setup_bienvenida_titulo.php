<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

// Obtener la sección bienvenida
$sectionResult = $mysqli->query("SELECT id FROM content_sections WHERE slug = 'bienvenida'");
$section = $sectionResult->fetch_assoc();
$sectionId = $section['id'];

// Obtener el bloque titulo actual
$titleResult = $mysqli->query("SELECT content FROM content_blocks WHERE section_id = $sectionId AND block_key = 'titulo'");
$titleBlock = $titleResult->fetch_assoc();
$titleContent = $titleBlock['content'] ?? 'Tu Salud Femenina en las Mejores Manos de Huánuco';

// Separar el título en tres partes
$partes = [
    'titulo_parte1' => 'Tu Salud Femenina en las',
    'titulo_parte2' => 'Mejores Manos',
    'titulo_parte3' => 'de Huánuco'
];

// Obtener el máximo sort_order para los nuevos bloques
$maxOrderResult = $mysqli->query("SELECT MAX(sort_order) as max_order FROM content_blocks WHERE section_id = $sectionId");
$maxOrder = $maxOrderResult->fetch_assoc()['max_order'] ?? 0;
$newSortOrder = $maxOrder + 1;

// Insertar los nuevos bloques
foreach ($partes as $blockKey => $content) {
    // Verificar si ya existe
    $existsResult = $mysqli->query("SELECT id FROM content_blocks WHERE section_id = $sectionId AND block_key = '$blockKey'");

    if ($existsResult->num_rows === 0) {
        $mysqli->query("
            INSERT INTO content_blocks (section_id, block_key, block_type, content, sort_order, is_active)
            VALUES ($sectionId, '$blockKey', 'text', '$content', $newSortOrder, 1)
        ");
        echo "✅ Creado: $blockKey\n";
        $newSortOrder++;
    } else {
        echo "⚠️ Ya existe: $blockKey\n";
    }
}

echo "\n✅ Bloques de título separados creados exitosamente\n";
$mysqli->close();
?>
