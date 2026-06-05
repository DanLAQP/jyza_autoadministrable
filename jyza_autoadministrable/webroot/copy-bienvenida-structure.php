<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Obtener todos los bloques de Bienvenida
$query = "SELECT * FROM content_blocks WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'bienvenida') ORDER BY sort_order";
$result = $mysqli->query($query);

echo "<h2>SQL para Copiar Estructura de Bienvenida a PorQueElegirnos:</h2>";
echo "<pre>";

// Primero eliminar bloques existentes
echo "DELETE FROM content_blocks WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'porqueelegirnos');\n\n";

echo "SET @section_id = (SELECT id FROM content_sections WHERE slug = 'porqueelegirnos');\n\n";

echo "INSERT INTO content_blocks (section_id, block_key, block_type, content, metadata, sort_order, is_active, created, modified) VALUES\n";

$first = true;
while ($row = $result->fetch_object()) {
    if (!$first) echo ",\n";
    $first = false;

    $metadata = $row->metadata ? "'" . $mysqli->real_escape_string($row->metadata) . "'" : "NULL";
    $content = "'" . $mysqli->real_escape_string($row->content) . "'";

    echo "(@section_id, '{$row->block_key}', '{$row->block_type}', {$content}, {$metadata}, {$row->sort_order}, {$row->is_active}, NOW(), NOW())";
}

echo ";\n";

echo "</pre>";

// También mostrar las imágenes de Bienvenida
echo "<h2>Imágenes en Bienvenida:</h2>";
$img_query = "SELECT * FROM content_images WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'bienvenida')";
$img_result = $mysqli->query($img_query);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>File Path</th><th>Alt Text</th></tr>";
while ($img = $img_result->fetch_object()) {
    echo "<tr><td>{$img->id}</td><td>{$img->file_path}</td><td>{$img->alt_text}</td></tr>";
}
echo "</table>";

$mysqli->close();
?>
