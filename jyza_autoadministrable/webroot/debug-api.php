<?php
/**
 * Script de debug para verificar API
 * Acceder a: http://localhost/jyza_autoadministrable/debug-api.php
 */

header('Content-Type: application/json; charset=utf-8');

$debug = [];

try {
    require __DIR__ . '/../config/bootstrap.php';

    use Cake\ORM\TableRegistry;
    use Cake\Cache\Cache;

    // 1. Verificar si la sección existe
    $contentSectionsTable = TableRegistry::getTableLocator()->get('ContentSections');
    $section = $contentSectionsTable->find()
        ->where(['slug' => 'porqueelegirnos'])
        ->first();

    $debug['seccion_existe'] = $section ? true : false;

    if ($section) {
        $debug['seccion'] = [
            'id' => $section->id,
            'slug' => $section->slug,
            'title' => $section->title,
            'is_active' => $section->is_active,
        ];

        // 2. Verificar bloques
        $blocksTable = TableRegistry::getTableLocator()->get('ContentBlocks');
        $blocks = $blocksTable->find()
            ->where(['section_id' => $section->id])
            ->order(['sort_order' => 'ASC'])
            ->toArray();

        $debug['bloques'] = [
            'cantidad' => count($blocks),
            'lista' => array_map(function($b) {
                return [
                    'id' => $b->id,
                    'key' => $b->block_key,
                    'type' => $b->block_type,
                    'content' => mb_substr($b->content, 0, 50),
                ];
            }, $blocks)
        ];

        // 3. Verificar imágenes
        $imagesTable = TableRegistry::getTableLocator()->get('ContentImages');
        $images = $imagesTable->find()
            ->where(['section_id' => $section->id])
            ->toArray();

        $debug['imagenes'] = [
            'cantidad' => count($images),
            'lista' => array_map(function($i) {
                return [
                    'id' => $i->id,
                    'file_path' => $i->file_path,
                    'alt_text' => $i->alt_text,
                ];
            }, $images)
        ];

        // 4. Obtener datos completos formateados (como lo hace ContentService)
        $contentService = new \App\Service\ContentService();
        $fullData = $contentService->getSectionContent('porqueelegirnos', useCache: false);

        $debug['datos_api'] = $fullData ? 'OK - Datos disponibles' : 'ERROR - No se puede obtener';

        if ($fullData) {
            $debug['bloques_en_api'] = count($fullData['blocks'] ?? []);
            $debug['imagenes_en_api'] = count($fullData['images'] ?? []);

            // Mostrar una muestra de bloques
            $debug['bloques_muestra'] = array_slice(
                array_map(fn($k, $v) => ['key' => $k, 'type' => $v['type']],
                    array_keys($fullData['blocks'] ?? []),
                    array_values($fullData['blocks'] ?? [])),
                0,
                5
            );
        }
    } else {
        $debug['error'] = 'Sección porqueelegirnos no encontrada en BD';
        $debug['instruccion'] = 'Ejecuta el archivo porqueelegirnos_update.sql en phpMyAdmin';
    }

} catch (Exception $e) {
    $debug['excepcion'] = $e->getMessage();
    $debug['linea'] = $e->getLine();
    $debug['archivo'] = $e->getFile();
}

echo json_encode($debug, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
