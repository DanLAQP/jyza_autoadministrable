<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->set_charset('utf8mb4');

echo "=== BIENVENIDA BLOQUES ===\n";
$result = $db->query("
  SELECT b.id, b.block_key, b.block_type, b.content, b.section_id
  FROM content_blocks b
  JOIN content_sections s ON s.id = b.section_id
  WHERE s.slug = 'bienvenida'
  ORDER BY b.sort_order
");
while ($row = $result->fetch_assoc()) {
  echo "ID: {$row['id']}, Key: {$row['block_key']}, Type: {$row['block_type']}, Content: " . substr($row['content'], 0, 50) . "\n";
}

echo "\n=== PORQUEELEGIRNOS BLOQUES ===\n";
$result = $db->query("
  SELECT b.id, b.block_key, b.block_type, b.content, b.section_id
  FROM content_blocks b
  JOIN content_sections s ON s.id = b.section_id
  WHERE s.slug = 'porqueelegirnos'
  ORDER BY b.sort_order
");
while ($row = $result->fetch_assoc()) {
  echo "ID: {$row['id']}, Key: {$row['block_key']}, Type: {$row['block_type']}, Content: " . substr($row['content'], 0, 50) . "\n";
}

$db->close();
?>
