<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

echo "=== BLOQUES EN ESPECIALIDADES ===\n\n";

$result = $mysqli->query("
    SELECT block_key, block_type, content, is_active
    FROM content_blocks
    WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'especialidades')
    ORDER BY sort_order
");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['is_active'] == 1 ? '✅' : '❌';
        $content = strlen($row['content']) > 40 ? substr($row['content'], 0, 40) . '...' : $row['content'];
        echo "{$status} {$row['block_key']} ({$row['block_type']}): {$content}\n";
    }
} else {
    echo "No hay bloques configurados para Especialidades\n";
}

$mysqli->close();
?>
