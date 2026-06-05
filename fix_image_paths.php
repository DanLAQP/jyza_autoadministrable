<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    die('DB error: ' . $mysqli->connect_error);
}

// Obtener todas las imágenes
$stmt = $mysqli->prepare('SELECT id, file_path FROM content_images LIMIT 10');
$stmt->execute();
$res = $stmt->get_result();

echo "Imágenes en BD:\n";
echo "===============\n";
while ($row = $res->fetch_object()) {
    echo "ID: {$row->id}\n";
    echo "Path: {$row->file_path}\n";
    echo "\n";
}

// Ver si las rutas empiezan con http
$checkStmt = $mysqli->prepare('SELECT COUNT(*) as total,
    SUM(CASE WHEN file_path LIKE "http%" THEN 1 ELSE 0 END) as with_http,
    SUM(CASE WHEN file_path LIKE "/jyza_autoadministrable/%" THEN 1 ELSE 0 END) as with_slash
    FROM content_images');
$checkStmt->execute();
$checkRes = $checkStmt->get_result();
$summary = $checkRes->fetch_object();

echo "Resumen:\n";
echo "Total imágenes: {$summary->total}\n";
echo "Con http: {$summary->with_http}\n";
echo "Con /jyza_autoadministrable/: {$summary->with_slash}\n";

$mysqli->close();
?>
