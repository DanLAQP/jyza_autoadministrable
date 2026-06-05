<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');

$result = $mysqli->query("
    SELECT block_key, content, is_active
    FROM content_blocks
    WHERE section_id = 1 AND block_key LIKE 'titulo%'
    ORDER BY sort_order
");

while ($row = $result->fetch_assoc()) {
    echo "{$row['block_key']}: {$row['content']} (is_active: {$row['is_active']})\n";
}

$mysqli->close();
?>
