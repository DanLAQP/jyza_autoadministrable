<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

echo "=== ESTADO DE CAMPOS EN BD ===\n\n";

$result = $mysqli->query("
    SELECT block_key, content, is_active
    FROM content_blocks
    WHERE section_id = 1
    ORDER BY sort_order
");

while ($row = $result->fetch_assoc()) {
    $status = $row['is_active'] == 1 ? '✅ ACTIVO' : '❌ INACTIVO';
    $content = strlen($row['content']) > 40 ? substr($row['content'], 0, 40) . '...' : $row['content'];
    echo "{$row['block_key']}: $status - $content\n";
}

$mysqli->close();
?>
