<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->set_charset('utf8mb4');

if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Leer y ejecutar el SQL
$sql = file_get_contents(__DIR__ . '/especialistas.sql');

// Ejecutar múltiples sentencias
if ($db->multi_query($sql)) {
    echo "✅ Base de datos actualizada exitosamente\n";
    echo "Sección 'especialistas' creada con todos los bloques\n";

    // Consumir todos los resultados
    do {
        if ($result = $db->store_result()) {
            $result->free();
        }
    } while ($db->more_results() && $db->next_result());
} else {
    echo "❌ Error: " . $db->error . "\n";
}

// Verificar
$result = $db->query("SELECT COUNT(*) as count FROM content_blocks WHERE section_id = (SELECT id FROM content_sections WHERE slug = 'especialistas')");
$row = $result->fetch_assoc();
echo "\n✅ Bloques creados: " . $row['count'] . "\n";

$db->close();
?>
