<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
echo "=== CONTENT SECTIONS ===\n";
$result = $db->query('SELECT id, slug, title FROM content_sections ORDER BY id');
while ($row = $result->fetch_assoc()) {
  echo "ID: {$row['id']}, Slug: {$row['slug']}, Title: {$row['title']}\n";
}
$db->close();
?>
