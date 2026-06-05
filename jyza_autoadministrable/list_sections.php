<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$result = $mysqli->query('SELECT id, slug, title FROM content_sections ORDER BY id');
while ($row = $result->fetch_assoc()) {
    echo "{$row['id']}: {$row['slug']} - {$row['title']}\n";
}
$mysqli->close();
?>
