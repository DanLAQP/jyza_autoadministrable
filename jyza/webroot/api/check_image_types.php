<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

echo "=== TIPOS DE BLOQUES DE IMAGEN ===\n";
$result = $mysqli->query("
    SELECT block_key, block_type
    FROM content_blocks
    WHERE section_id = 14
    AND block_key LIKE '%image%'
");

while ($row = $result->fetch_assoc()) {
    echo "{$row['block_key']}: {$row['block_type']}\n";
}

echo "\n=== ACTUALIZANDO TIPOS ===\n";
$updateResult = $mysqli->query("
    UPDATE content_blocks
    SET block_type = 'image'
    WHERE section_id = 14
    AND block_key LIKE '%image%'
");

if ($updateResult) {
    echo "✅ Bloques de imagen actualizados a tipo 'image'\n";
} else {
    echo "❌ Error: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
