<?php
// Simular lo que hace el componente Astro
$url = 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/api/content/section/testimonios/index.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$content = json_decode($response, true);
$blocks = $content['blocks'];
$images = $content['images'];

// Función helper para obtener datos de un testimonio
$getImageUrl = function($imageId) use ($images) {
    if (!$imageId) return '';
    foreach ($images as $image) {
        if ($image['id'] == $imageId) {
            return $image['url'];
        }
    }
    return '';
};

$getTestimonio = function($num) use ($blocks, $getImageUrl) {
    return [
        'avatar' => $getImageUrl($blocks["testimonio{$num}_avatar"]['content'] ?? null),
        'name' => $blocks["testimonio{$num}_name"]['content'] ?? '',
        'tag' => $blocks["testimonio{$num}_tag"]['content'] ?? '',
        'text' => $blocks["testimonio{$num}_text"]['content'] ?? '',
        'likes' => $blocks["testimonio{$num}_likes"]['content'] ?? '',
        'featured' => $blocks["testimonio{$num}_featured"]['content'] ?? '',
    ];
};

$testimonios = [];
for ($i = 1; $i <= 7; $i++) {
    $testimonios[] = $getTestimonio($i);
}

// Distribuir en columnas
$leftTestimonios = array_slice($testimonios, 0, 2);
$centerTestimonios = array_slice($testimonios, 2, 2);
$rightTestimonios = array_slice($testimonios, 4, 3);

echo "Testimonios izquierda: " . count($leftTestimonios) . "\n";
echo "Testimonios centro: " . count($centerTestimonios) . "\n";
echo "Testimonios derecha: " . count($rightTestimonios) . "\n\n";

foreach ($leftTestimonios as $i => $t) {
    echo "Izq[$i]: {$t['name']} - Avatar: {$t['avatar']}\n";
}

foreach ($centerTestimonios as $i => $t) {
    echo "Centro[$i]: {$t['name']} - Featured: {$t['featured']} - Avatar: {$t['avatar']}\n";
}

foreach ($rightTestimonios as $i => $t) {
    echo "Der[$i]: {$t['name']} - Avatar: {$t['avatar']}\n";
}
?>
