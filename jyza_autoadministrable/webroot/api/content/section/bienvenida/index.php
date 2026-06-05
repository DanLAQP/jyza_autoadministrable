<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(['ok' => true]);
    exit;
}

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed', 'details' => $mysqli->connect_error]);
    exit;
}

$slug = 'bienvenida';

$stmt = $mysqli->prepare('SELECT id, slug, title, description, metadata, modified FROM content_sections WHERE slug = ? AND is_active = 1 LIMIT 1');
$stmt->bind_param('s', $slug);
$stmt->execute();
$res = $stmt->get_result();
$section = $res->fetch_object();
if (!$section) {
    http_response_code(404);
    echo json_encode(['error' => 'Section not found']);
    exit;
}

$sectionId = (int)$section->id;

$blocks = [];
$bstmt = $mysqli->prepare('SELECT id, block_key, block_type, content, metadata, is_active FROM content_blocks WHERE section_id = ? AND is_active = 1 ORDER BY sort_order ASC');
$bstmt->bind_param('i', $sectionId);
$bstmt->execute();
$bres = $bstmt->get_result();
while ($b = $bres->fetch_object()) {
    $meta = null;
    if ($b->metadata) {
        $meta = json_decode($b->metadata, true);
    }
    $blocks[$b->block_key] = [
        'id' => (int)$b->id,
        'type' => $b->block_type,
        'content' => $b->content,
        'metadata' => $meta ?: new stdClass(),
        'is_active' => (int)$b->is_active,
    ];
}

$images = [];
$istmt = $mysqli->prepare('SELECT id, file_path, alt_text, title, dimensions FROM content_images WHERE section_id = ? ORDER BY id DESC');
$istmt->bind_param('i', $sectionId);
$istmt->execute();
$ires = $istmt->get_result();
while ($img = $ires->fetch_object()) {
    $images[] = [
        'id' => (int)$img->id,
        'url' => $img->file_path,
        'alt' => $img->alt_text,
        'title' => $img->title,
        'dimensions' => $img->dimensions,
    ];
}

$out = [
    'id' => (int)$section->id,
    'slug' => $section->slug,
    'title' => $section->title,
    'description' => $section->description,
    'metadata' => (object)[],
    'blocks' => $blocks,
    'images' => $images,
    'updated_at' => date(DATE_ATOM, strtotime($section->modified)),
];

echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$mysqli->close();