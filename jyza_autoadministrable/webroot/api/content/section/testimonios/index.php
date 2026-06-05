<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

try {
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $mysqli->set_charset('utf8mb4');

    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }

    // Obtener la sección
    $sectionResult = $mysqli->query("
        SELECT id, slug, title, description
        FROM content_sections
        WHERE slug = 'testimonios'
    ");

    if (!$sectionResult || $sectionResult->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Section not found']);
        exit;
    }

    $section = $sectionResult->fetch_assoc();
    $sectionId = $section['id'];

    // Obtener bloques
    $blocksResult = $mysqli->query("
        SELECT id, block_key, block_type, content, metadata
        FROM content_blocks
        WHERE section_id = $sectionId
        ORDER BY sort_order ASC
    ");

    $blocks = [];
    while ($block = $blocksResult->fetch_assoc()) {
        $blocks[$block['block_key']] = [
            'type' => $block['block_type'],
            'content' => $block['content'],
            'metadata' => $block['metadata'] ? json_decode($block['metadata'], true) : null,
        ];
    }

    // Obtener imágenes
    $imagesResult = $mysqli->query("
        SELECT id, original_filename, file_path, alt_text, title
        FROM content_images
        WHERE section_id = $sectionId AND is_active = 1
        ORDER BY id ASC
    ");

    $images = [];
    while ($image = $imagesResult->fetch_assoc()) {
        $images[] = [
            'id' => (int)$image['id'],
            'url' => $image['file_path'],
            'alt' => $image['alt_text'] ?: $image['original_filename'],
            'title' => $image['title'],
        ];
    }

    $mysqli->close();

    echo json_encode([
        'id' => (int)$section['id'],
        'slug' => $section['slug'],
        'title' => $section['title'],
        'description' => $section['description'],
        'blocks' => $blocks,
        'images' => $images,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
