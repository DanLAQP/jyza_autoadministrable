<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    die('Error: ' . $mysqli->connect_error);
}

echo "<h2>📊 Imágenes por Sección</h2>";

// Obtener secciones
$sections_query = "
    SELECT cs.id, cs.slug, cs.title,
           COUNT(ci.id) as total_imagenes
    FROM content_sections cs
    LEFT JOIN content_images ci ON cs.id = ci.section_id
    GROUP BY cs.id, cs.slug, cs.title
    ORDER BY cs.sort_order ASC
";

$result = $mysqli->query($sections_query);

while ($section = $result->fetch_object()) {
    echo "<hr>";
    echo "<h3>" . htmlspecialchars($section->slug) . " (ID: {$section->id})</h3>";
    echo "Total imágenes: <strong>{$section->total_imagenes}</strong>";

    // Obtener imágenes de esta sección
    $images_query = $mysqli->prepare("
        SELECT id, file_path, alt_text, title, stored_filename
        FROM content_images
        WHERE section_id = ?
        ORDER BY id ASC
    ");
    $images_query->bind_param('i', $section->id);
    $images_query->execute();
    $images_result = $images_query->get_result();

    if ($images_result->num_rows > 0) {
        echo "<ul>";
        while ($img = $images_result->fetch_object()) {
            echo "<li>";
            echo "ID: {$img->id} | ";
            echo "Path: {$img->file_path} | ";
            echo "Alt: {$img->alt_text} | ";
            echo "File: {$img->stored_filename}";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>❌ Sin imágenes</p>";
    }
}

// También mostrar bloques de imagen
echo "<hr>";
echo "<h2>📝 Bloques de tipo IMAGE</h2>";

$blocks_query = "
    SELECT cb.id, cb.section_id, cs.slug, cb.block_key, cb.content
    FROM content_blocks cb
    JOIN content_sections cs ON cb.section_id = cs.id
    WHERE cb.block_type = 'image'
    ORDER BY cs.slug, cb.sort_order
";

$result = $mysqli->query($blocks_query);

while ($block = $result->fetch_object()) {
    echo "Sección: <strong>{$block->slug}</strong> | ";
    echo "Key: <strong>{$block->block_key}</strong> | ";
    echo "Content (Image ID/URL): <strong>{$block->content}</strong><br>";
}

$mysqli->close();
?>
