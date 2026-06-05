<?php
require __DIR__ . '/../config/bootstrap.php';

use Cake\ORM\TableRegistry;

header('Content-Type: application/json');

try {
    $contentSectionsTable = TableRegistry::getTableLocator()->get('ContentSections');

    // Obtener todas las secciones
    $sections = $contentSectionsTable->find()
        ->select(['id', 'slug', 'title', 'is_active'])
        ->orderBy(['sort_order' => 'ASC'])
        ->toArray();

    $result = [
        'total' => count($sections),
        'secciones' => array_map(fn($s) => [
            'id' => $s->id,
            'slug' => $s->slug,
            'title' => $s->title,
            'activa' => $s->is_active ? 'Sí' : 'No'
        ], $sections)
    ];

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
}
?>
