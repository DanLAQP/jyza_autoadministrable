<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->set_charset('utf8mb4');

$sql = file_get_contents(__DIR__ . '/cluljyza.sql');

if ($db->multi_query($sql)) {
    while ($db->more_results()) $db->next_result();
    echo "✅ Sección Club JYZA creada\n";

    $result = $db->query("SELECT COUNT(*) as count FROM content_blocks WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'clubjyza')");
    $row = $result->fetch_assoc();
    echo "✅ Bloques creados: " . $row['count'] . "\n";
} else {
    echo "❌ Error: " . $db->error . "\n";
}

$db->close();
?>
