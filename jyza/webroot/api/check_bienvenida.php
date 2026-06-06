<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

$result = $mysqli->query("
    SELECT block_key, content
    FROM content_blocks
    WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'bienvenida')
    ORDER BY sort_order
");

echo "=== CAMPOS DE BIENVENIDA ===\n\n";
while ($row = $result->fetch_assoc()) {
    $content = strlen($row['content']) > 50 ? substr($row['content'], 0, 50) . '...' : $row['content'];
    echo "{$row['block_key']}: {$content}\n";
}
$mysqli->close();
?>
