<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

$mysqli->query("UPDATE content_blocks SET is_active = 1 WHERE section_id = 1 AND block_key = 'titulo_parte1'");

if ($mysqli->affected_rows > 0) {
    echo "✅ Activado: titulo_parte1\n";
} else {
    echo "⚠️ No se actualizó nada\n";
}

// Verificar estado final
$result = $mysqli->query("
    SELECT block_key, is_active
    FROM content_blocks
    WHERE section_id = 1 AND block_key LIKE 'titulo%'
    ORDER BY sort_order
");

echo "\n=== ESTADO FINAL ===\n";
while ($row = $result->fetch_assoc()) {
    $status = $row['is_active'] == 1 ? '✅ Activo' : '❌ Inactivo';
    echo "{$row['block_key']}: $status\n";
}

$mysqli->close();
?>
