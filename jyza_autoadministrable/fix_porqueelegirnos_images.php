<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->set_charset('utf8mb4');

// Obtener la URL base correcta
$baseUrl = 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot';

// Arreglar las imágenes existentes
$images = [
    15 => ['file' => 'imag1.webp', 'name' => 'imag1.webp'],
    16 => ['file' => 'imag2.webp', 'name' => 'imag2.webp'],
    17 => ['file' => 'imag3.webp', 'name' => 'imag3.webp'],
    18 => ['file' => 'imag4.webp', 'name' => 'imag4.webp'],
];

foreach ($images as $id => $imageData) {
    $newPath = $baseUrl . '/uploads/content/' . $imageData['file'];
    $db->query("UPDATE content_images SET file_path = '{$newPath}' WHERE id = {$id}");
    echo "✅ Actualizada imagen ID {$id}: {$imageData['file']}\n";
}

// Verificar cambios
echo "\n=== PORQUEELEGIRNOS IMAGES AFTER UPDATE ===\n";
$result = $db->query("
  SELECT ci.id, ci.original_filename, ci.file_path
  FROM content_images ci
  WHERE ci.section_id = (SELECT id FROM content_sections WHERE slug = 'porqueelegirnos')
  ORDER BY ci.id
");
while ($row = $result->fetch_assoc()) {
  echo "ID: {$row['id']}, Path: {$row['file_path']}\n";
}

$db->close();
?>
