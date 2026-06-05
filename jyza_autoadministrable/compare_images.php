<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->set_charset('utf8mb4');

echo "=== BIENVENIDA IMAGES ===\n";
$result = $db->query("
  SELECT ci.id, ci.original_filename, ci.stored_filename, ci.file_path, ci.is_active, ci.section_id
  FROM content_images ci
  WHERE ci.section_id = (SELECT id FROM content_sections WHERE slug = 'bienvenida')
");
while ($row = $result->fetch_assoc()) {
  echo "ID: {$row['id']}, Original: {$row['original_filename']}, Path: {$row['file_path']}, Active: {$row['is_active']}\n";
}

echo "\n=== PORQUEELEGIRNOS IMAGES ===\n";
$result = $db->query("
  SELECT ci.id, ci.original_filename, ci.stored_filename, ci.file_path, ci.is_active, ci.section_id
  FROM content_images ci
  WHERE ci.section_id = (SELECT id FROM content_sections WHERE slug = 'porqueelegirnos')
");
while ($row = $result->fetch_assoc()) {
  echo "ID: {$row['id']}, Original: {$row['original_filename']}, Path: {$row['file_path']}, Active: {$row['is_active']}\n";
}

$db->close();
?>
