<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

$sectionId = $mysqli->query("SELECT id FROM content_sections WHERE slug = 'bienvenida'")->fetch_assoc()['id'];

// Campos que ya no usamos
$blocksToDelete = ['titulo', 'subtitulo'];

foreach ($blocksToDelete as $blockKey) {
    $result = $mysqli->query("DELETE FROM content_blocks WHERE section_id = $sectionId AND block_key = '$blockKey'");
    if ($result) {
        echo "✅ Eliminado: $blockKey\n";
    }
}

echo "\n✅ Limpieza completada. Ahora el admin solo mostrará los campos que se usan en Astro.\n";
$mysqli->close();
?>
