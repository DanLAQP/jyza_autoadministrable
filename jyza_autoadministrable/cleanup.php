<?php
$db = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$db->query("DELETE FROM content_images WHERE id = 19");
echo "✅ Imagen de prueba eliminada\n";
$db->close();
?>
