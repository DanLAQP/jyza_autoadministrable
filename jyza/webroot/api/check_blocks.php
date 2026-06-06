<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$mysqli->set_charset('utf8mb4');

$result = $mysqli->query("
    SELECT block_key, content
    FROM content_blocks
    WHERE section_id = 14
    LIMIT 20
");

echo "First 20 blocks content:\n";
while ($row = $result->fetch_assoc()) {
    echo "{$row['block_key']}: {$row['content']}\n";
}

$mysqli->close();
?>
