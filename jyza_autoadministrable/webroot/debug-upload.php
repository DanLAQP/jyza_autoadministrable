<?php
/**
 * Script de debug para verificar qué está recibiendo PHP en uploads
 */

$logFile = __DIR__ . '/../logs/upload-debug.log';

$debug = [
    'timestamp' => date('Y-m-d H:i:s'),
    'request_method' => $_SERVER['REQUEST_METHOD'],
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'N/A',
    'files_received' => count($_FILES),
    'post_data_size' => strlen(json_encode($_POST)),
    'files_list' => array_keys($_FILES),
];

// Detalles de FILES
foreach ($_FILES as $key => $file) {
    $debug["file_$key"] = [
        'name' => $file['name'],
        'type' => $file['type'],
        'size' => $file['size'],
        'error' => $file['error'],
        'error_msg' => $this->getUploadErrorMessage($file['error']),
    ];
}

file_put_contents($logFile, json_encode($debug, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

echo "✅ Debug registrado en: $logFile\n";

function getUploadErrorMessage($code) {
    $errors = array(
        UPLOAD_ERR_OK => 'No hay error',
        UPLOAD_ERR_INI_SIZE => 'Exceede upload_max_filesize',
        UPLOAD_ERR_FORM_SIZE => 'Exceede MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL => 'Archivo parcialmente subido',
        UPLOAD_ERR_NO_FILE => 'Ningún archivo subido',
        UPLOAD_ERR_NO_TMP_DIR => 'Falta carpeta temporal',
        UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir',
        UPLOAD_ERR_EXTENSION => 'Extensión bloqueada',
    );
    return $errors[$code] ?? "Código desconocido: $code";
}
?>
