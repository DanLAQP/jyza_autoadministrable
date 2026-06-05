<?php
/**
 * Script simple para limpiar caché
 * Acceder a: http://localhost/jyza_autoadministrable/clear-cache.php
 */

// Eliminar archivos de caché
$cacheDir = __DIR__ . '/../tmp/cache';

if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ Caché limpiado desde: $cacheDir\n";
} else {
    echo "⚠️ Directorio de caché no encontrado: $cacheDir\n";
}

// También limpiar desde BD si es posible
try {
    // Incluir el archivo de configuración
    require __DIR__ . '/../config/bootstrap.php';

    use Cake\Cache\Cache;
    use Cake\ORM\TableRegistry;

    // Limpiar caché API
    Cache::delete('content_section_bienvenida', 'api');
    Cache::delete('content_section_porqueelegirnos', 'api');
    Cache::delete('content_all_sections', 'api');

    // Limpiar BD
    $contentCacheTable = TableRegistry::getTableLocator()->get('ContentCache');
    $result = $contentCacheTable->deleteAll([]);

    echo "✅ Caché de BD limpiado\n";

    // Verificar datos
    $contentSectionsTable = TableRegistry::getTableLocator()->get('ContentSections');
    $section = $contentSectionsTable->find()
        ->where(['slug' => 'porqueelegirnos'])
        ->contain(['ContentBlocks', 'ContentImages'])
        ->first();

    if ($section) {
        echo "\n✅ Datos de porqueelegirnos:\n";
        echo "   Bloques: " . count($section->content_blocks) . "\n";
        echo "   Imágenes: " . count($section->content_images) . "\n";

        if (count($section->content_blocks) === 0) {
            echo "\n⚠️ ADVERTENCIA: No hay bloques. Ejecuta el SQL porqueelegirnos_update.sql\n";
        }
    }
} catch (Exception $e) {
    echo "⚠️ No se pudo limpiar BD: " . $e->getMessage() . "\n";
}

echo "\n✅ Caché limpiado. Ahora carga http://localhost/jyza_autoadministrable/\n";
?>
