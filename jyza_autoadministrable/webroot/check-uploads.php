<?php
echo "<h1>🔍 Diagnóstico de Uploads</h1>";

// 1. Verificar la carpeta de uploads
$uploadDir = __DIR__ . '/uploads/content';
echo "<h2>📁 Carpeta de Uploads</h2>";
echo "Ruta esperada: <code>$uploadDir</code><br>";

if (is_dir($uploadDir)) {
    echo "✅ Carpeta existe<br>";
    $perms = substr(sprintf('%o', fileperms($uploadDir)), -4);
    echo "Permisos: <code>$perms</code><br>";

    if (is_writable($uploadDir)) {
        echo "✅ Carpeta es escribible<br>";
    } else {
        echo "❌ Carpeta NO es escribible<br>";
    }

    $files = scandir($uploadDir);
    $fileCount = count($files) - 2; // Excluir . y ..
    echo "Archivos: <strong>$fileCount</strong><br>";

    if ($fileCount > 0) {
        echo "<strong>Primeros 5 archivos:</strong><ul>";
        $count = 0;
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "<li>$file</li>";
                $count++;
                if ($count >= 5) break;
            }
        }
        echo "</ul>";
    }
} else {
    echo "❌ Carpeta NO existe<br>";
    $parentDir = __DIR__ . '/uploads';
    if (is_dir($parentDir)) {
        echo "ℹ️ Carpeta padre existe: <code>$parentDir</code><br>";
        if (is_writable($parentDir)) {
            echo "✅ Carpeta padre es escribible - puedes crear /content<br>";
        } else {
            echo "❌ Carpeta padre NO es escribible<br>";
        }
    } else {
        echo "❌ Carpeta padre tampoco existe<br>";
    }
}

// 2. Verificar Imagick
echo "<h2>🖼️ ImageMagick (Imagick)</h2>";
if (extension_loaded('imagick')) {
    echo "✅ Extensión Imagick está disponible<br>";
    $imagick = new Imagick();
    $formats = $imagick->queryFormats();
    if (in_array('JPEG', $formats) && in_array('PNG', $formats)) {
        echo "✅ Soporta JPEG y PNG<br>";
    } else {
        echo "⚠️ Podría haber limitaciones en formatos<br>";
    }
} else {
    echo "⚠️ Extensión Imagick NO está disponible<br>";
    echo "Las imágenes se guardán pero sin optimización<br>";
}

// 3. Límites de PHP
echo "<h2>⚙️ Límites de PHP</h2>";
echo "upload_max_filesize: <code>" . ini_get('upload_max_filesize') . "</code><br>";
echo "post_max_size: <code>" . ini_get('post_max_size') . "</code><br>";
echo "memory_limit: <code>" . ini_get('memory_limit') . "</code><br>";

// 4. Logs
echo "<h2>📋 Logs Recientes</h2>";
$logFile = __DIR__ . '/../logs/error.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $recent = array_slice($lines, -10);
    echo "<pre style='background:#f0f0f0; padding:10px; border-radius:5px; max-height:300px; overflow-y:auto;'>";
    foreach ($recent as $line) {
        echo htmlspecialchars($line);
    }
    echo "</pre>";
} else {
    echo "ℹ️ No hay logs disponibles<br>";
}

// 5. Test de escritura
echo "<h2>✍️ Test de Escritura</h2>";
$testFile = $uploadDir . '/test_write_' . time() . '.txt';
if (@file_put_contents($testFile, 'test')) {
    echo "✅ Puedo escribir en la carpeta<br>";
    unlink($testFile);
} else {
    echo "❌ NO puedo escribir en la carpeta<br>";
}
?>
