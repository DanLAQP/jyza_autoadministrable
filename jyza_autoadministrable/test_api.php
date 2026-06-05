<?php
$url = 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/api/content/section/testimonios/index.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

echo "API Response:\n";
echo "Slug: " . $data['slug'] . "\n";
echo "Bloques: " . count($data['blocks']) . "\n";
echo "Imágenes: " . count($data['images']) . "\n\n";

echo "Primeros 10 bloques:\n";
$i = 0;
foreach ($data['blocks'] as $key => $block) {
    echo "  $key: {$block['content']}\n";
    if (++$i >= 10) break;
}

echo "\nÚltimos 5 bloques:\n";
$blocks = array_slice($data['blocks'], -5);
foreach ($blocks as $key => $block) {
    echo "  $key: {$block['content']}\n";
}

echo "\nImágenes:\n";
foreach ($data['images'] as $img) {
    echo "  ID {$img['id']}: {$img['url']}\n";
}
?>
