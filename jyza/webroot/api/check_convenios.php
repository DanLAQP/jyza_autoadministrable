<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$mysqli->set_charset('utf8mb4');

echo "=== CONTENIDO DE CONVENIOS ===\n\n";

for ($i = 1; $i <= 4; $i++) {
    echo "--- CONVENIO $i ---\n";
    $result = $mysqli->query("
        SELECT block_key, content, block_type
        FROM content_blocks
        WHERE section_id = 14
        AND block_key LIKE 'convenio_${i}_%'
        ORDER BY block_key
    ");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $content = strlen($row['content']) > 50 ? substr($row['content'], 0, 50) . "..." : $row['content'];
            echo "  {$row['block_key']}: {$content}\n";
        }
    } else {
        echo "  [SIN DATOS]\n";
    }
    echo "\n";
}

$mysqli->close();
?>
