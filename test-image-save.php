<?php
/**
 * Test directo de guardado de imagen
 */

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

echo "<h1>🧪 Test de Guardado de Imagen</h1>";

// 1. Crear una imagen de prueba
echo "<h2>1️⃣ Creando imagen de prueba</h2>";

$testDir = __DIR__ . '/jyza_autoadministrable/webroot/uploads/content';
if (!is_dir($testDir)) {
    mkdir($testDir, 0777, true);
}

// Crear una pequeña imagen PNG
$img = imagecreate(100, 100);
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
imagefill($img, 0, 0, $white);
imagerectangle($img, 10, 10, 90, 90, $black);

$testFile = $testDir . '/test_' . time() . '.png';
imagepng($img, $testFile);
imagedestroy($img);

echo "✅ Imagen de prueba creada: " . basename($testFile) . "<br>";

// 2. Insertar registro en BD
echo "<h2>2️⃣ Insertando en content_images</h2>";

$publicUrl = 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/' . basename($testFile);

$stmt = $mysqli->prepare("
    INSERT INTO content_images (
        section_id, original_filename, stored_filename, file_path,
        mime_type, alt_text, title, uploaded_by, is_active, created, modified
    ) VALUES (10, ?, ?, ?, 'image/png', 'Test', 'Test Image', 1, 1, NOW(), NOW())
");

$filename = basename($testFile);
$stmt->bind_param('sss', $filename, $filename, $publicUrl);

if ($stmt->execute()) {
    $imageId = $stmt->insert_id;
    echo "✅ Imagen insertada en BD con ID: " . $imageId . "<br>";
} else {
    echo "❌ Error al insertar: " . $stmt->error . "<br>";
    exit;
}

// 3. Intentar actualizar un bloque para apuntar a esta imagen
echo "<h2>3️⃣ Actualizando bloque img_1</h2>";

$blockId = 58; // img_1 según el output anterior
$stmt2 = $mysqli->prepare("UPDATE content_blocks SET content = ? WHERE id = ?");
$imageIdStr = (string)$imageId;
$stmt2->bind_param('si', $imageIdStr, $blockId);

if ($stmt2->execute()) {
    echo "✅ Bloque actualizado correctamente<br>";
    echo "   Block ID: " . $blockId . "<br>";
    echo "   Nuevo content (Image ID): " . $imageId . "<br>";
} else {
    echo "❌ Error al actualizar bloque: " . $stmt2->error . "<br>";
}

// 4. Verificar
echo "<h2>4️⃣ Verificación</h2>";

$check = $mysqli->query("SELECT id, content FROM content_blocks WHERE id = 58");
$block = $check->fetch_object();

if ($block && $block->content == $imageId) {
    echo "✅ ÉXITO: El bloque ahora apunta a la imagen ID: " . $block->content . "<br>";
} else {
    echo "❌ ERROR: El bloque no se actualizó correctamente<br>";
    echo "   Content en BD: " . ($block->content ?? 'NULL') . "<br>";
}

$mysqli->close();

// Limpiar
unlink($testFile);
echo "<br><strong>Conclusión:</strong> Si ves ✅ en todos los pasos, significa que el guardado funciona en la BD.";
?>
