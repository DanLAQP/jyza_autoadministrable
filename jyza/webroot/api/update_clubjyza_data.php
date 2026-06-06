<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'jyza_autoadministrable');
$mysqli->set_charset('utf8mb4');

$updates = [
    1 => [
        'name' => 'Consultorio Ginecológico JYZA',
        'specialty' => 'Jr dos de mayo 1600 con Pedro Puelles · 961 295 024',
        'description_1' => 'Centro especializado en el cuidado integral de la salud femenina. Somos los fundadores del Club JYZA, comprometidos con tu bienestar en cada etapa de tu vida.',
        'description_2' => 'Atención ginecológica con tecnología de vanguardia, trato cálido y enfoque en la salud preventiva y curativa de la mujer.',
        'quote' => 'En JYZA te queremos sana',
        'benefit' => '10% de descuento en todos nuestros servicios',
        'facebook_url' => 'https://www.facebook.com/jyza.cmeg',
        'instagram_url' => 'https://www.instagram.com/consultorio_ginecologico_jyza',
    ],
    2 => [
        'name' => 'Centro Pediátrico Rositas',
        'specialty' => 'Jr. Mayro 250 – Huánuco · +51 952 468 349',
        'description_1' => 'Brindamos atención pediátrica especializada con calidad, calidez y compromiso con la salud de los niños de Huánuco.',
        'description_2' => 'Un espacio pensado para que los más pequeños reciban la mejor atención médica en un ambiente seguro y acogedor.',
        'quote' => 'Porque cada niño merece lo mejor',
        'benefit' => '20% de descuento en la consulta pediátrica',
        'facebook_url' => 'https://www.facebook.com/profile.php?id=61563956279816',
        'instagram_url' => '',
    ],
    3 => [
        'name' => 'Clínica Dental Cabanillas',
        'specialty' => 'Jr. Aguilar 339 – Huánuco · 988 129 696',
        'description_1' => 'Brindamos atención odontológica integral con profesionalismo, tecnología y un trato cálido para cuidar tu sonrisa.',
        'description_2' => 'Desde limpiezas preventivas hasta tratamientos de alta complejidad, con equipos modernos y especialistas comprometidos con tu salud bucal.',
        'quote' => 'Tu sonrisa es nuestra especialidad',
        'benefit' => 'Evaluación odontológica gratuita',
        'facebook_url' => 'https://www.facebook.com/Clinica.Cabanillas',
        'instagram_url' => 'https://www.instagram.com/dental.cabanillas',
    ],
    4 => [
        'name' => 'Baby Shark Spa',
        'specialty' => 'Jr. Constitución 482 – Huánuco · +51 954 763 133',
        'description_1' => 'Especialistas en estimulación temprana, promoviendo el desarrollo físico, cognitivo y emocional del bebé en un ambiente seguro y lúdico.',
        'description_2' => 'Un espacio pensado para que los padres acompañen a sus hijos en sus primeras etapas de aprendizaje, fortaleciendo vínculos y potenciando sus habilidades.',
        'quote' => 'Cada pequeño logro, un gran paso',
        'benefit' => '10% de descuento en el paquete de estimulación temprana',
        'facebook_url' => 'https://www.facebook.com/profile.php?id=61571776081114',
        'instagram_url' => 'https://www.instagram.com/baby_sharkspa',
    ],
];

foreach ($updates as $num => $data) {
    foreach ($data as $key => $value) {
        $blockKey = "convenio_${num}_${key}";
        $value = $mysqli->real_escape_string($value);

        $query = "UPDATE content_blocks SET content = '{$value}' WHERE section_id = 14 AND block_key = '{$blockKey}'";
        if ($mysqli->query($query)) {
            echo "✅ Updated: {$blockKey}\n";
        } else {
            echo "❌ Error updating {$blockKey}: " . $mysqli->error . "\n";
        }
    }
    echo "\n";
}

echo "✅ Todos los datos han sido actualizados\n";
$mysqli->close();
?>
