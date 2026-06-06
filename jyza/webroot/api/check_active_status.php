<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

echo "=== ESTADO is_active DE CONVENIOS ===\n\n";

for ($i = 1; $i <= 4; $i++) {
    $result = $mysqli->query("
        SELECT block_key, content, is_active
        FROM content_blocks
        WHERE section_id = 14
        AND block_key = 'convenio_{$i}_name'
    ");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Convenio $i:\n";
        echo "  Nombre: {$row['content']}\n";
        echo "  is_active: {$row['is_active']}\n";
        echo "  Tipo: " . gettype($row['is_active']) . "\n";
        echo "\n";
    }
}

$mysqli->close();
?>
