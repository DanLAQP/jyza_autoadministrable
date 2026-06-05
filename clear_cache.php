<?php
/**
 * Script para limpiar caché de contenido
 */

// Incluir bootstrap de CakePHP
require __DIR__ . '/config/bootstrap.php';

use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;

try {
    echo "🔄 Limpiando caché de contenido...\n";

    // Limpiar caché de secciones individuales
    Cache::delete('content_section_bienvenida', 'api');
    Cache::delete('content_section_porqueelegirnos', 'api');

    // Limpiar caché de todas las secciones
    Cache::delete('content_all_sections', 'api');
    Cache::delete('content_all', 'api');

    // Limpiar tabla de caché de BD
    $contentCacheTable = TableRegistry::getTableLocator()->get('ContentCache');
    $contentCacheTable->deleteAll([]);

    echo "✅ Caché limpiado exitosamente\n";
    echo "🔍 Verificando datos de porqueelegirnos...\n";

    // Verificar que los datos existen
    $contentSectionsTable = TableRegistry::getTableLocator()->get('ContentSections');
    $section = $contentSectionsTable->find()
        ->where(['slug' => 'porqueelegirnos'])
        ->contain(['ContentBlocks', 'ContentImages'])
        ->first();

    if ($section) {
        echo "✅ Sección encontrada: " . $section->title . "\n";
        echo "   ID: " . $section->id . "\n";
        echo "   Bloques: " . count($section->content_blocks) . "\n";
        echo "   Imágenes: " . count($section->content_images) . "\n";

        echo "\n📋 Bloques:\n";
        foreach ($section->content_blocks as $block) {
            echo "   - {$block->block_key} ({$block->block_type}): {$block->content}\n";
        }

        echo "\n🖼️ Imágenes:\n";
        foreach ($section->content_images as $img) {
            echo "   - ID: {$img->id} | Path: {$img->file_path} | Alt: {$img->alt_text}\n";
        }
    } else {
        echo "❌ Sección porqueelegirnos no encontrada\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
