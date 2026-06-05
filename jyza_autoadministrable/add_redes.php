<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->set_charset('utf8mb4');

$sql = file_get_contents(__DIR__ . '/especialistas_update_redes.sql');

if ($db->multi_query($sql)) {
    while ($db->more_results()) $db->next_result();
    echo "✅ Bloques de redes sociales agregados\n";
} else {
    echo "❌ Error: " . $db->error . "\n";
}

$db->close();
?>
