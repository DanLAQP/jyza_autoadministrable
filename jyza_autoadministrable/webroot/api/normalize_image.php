<?php
/**
 * Normaliza rutas de imágenes para que funcionen tanto en desarrollo como en Docker
 */
function normalizeImagePath($filePath) {
    if (empty($filePath)) {
        return '';
    }

    // Si ya es una URL HTTP, retornarla tal cual
    if (strpos($filePath, 'http://') === 0 || strpos($filePath, 'https://') === 0) {
        return $filePath;
    }

    // Si es una ruta relativa, convertirla a relativa desde webroot
    $filePath = ltrim($filePath, '/');

    // Remover la parte duplicada de jyza_autoadministrable si existe
    $filePath = preg_replace('#^jyza_autoadministrable/#', '', $filePath);
    $filePath = preg_replace('#^webroot/#', '', $filePath);

    // Retornar ruta relativa que funciona en cualquier contexto
    return '/' . $filePath;
}
?>
