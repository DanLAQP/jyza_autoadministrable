<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'jyza_autoadministrable';

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    die('DB error: ' . $mysqli->connect_error);
}

// Ver todos los tipos de rutas que hay
$stmt = $mysqli->prepare('SELECT DISTINCT file_path FROM content_images ORDER BY file_path');
$stmt->execute();
$res = $stmt->get_result();

echo "Rutas de imágenes en BD:\n";
echo "========================\n\n";

$routes = [];
while ($row = $res->fetch_object()) {
    $routes[] = $row->file_path;
    echo $row->file_path . "\n";
}

echo "\n\nResumen por tipo:\n";
echo "=================\n";

$http_count = 0;
$relative_count = 0;
$other_count = 0;

foreach ($routes as $route) {
    if (strpos($route, 'http') === 0) {
        $http_count++;
    } elseif (strpos($route, '/') === 0) {
        $relative_count++;
    } else {
        $other_count++;
        echo "OTRO: $route\n";
    }
}

echo "Con http: $http_count\n";
echo "Rutas relativas (/): $relative_count\n";
echo "Otras: $other_count\n";

$mysqli->close();
?>
