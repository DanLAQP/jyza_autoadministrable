<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Exception;
use Imagick;
use Cake\Log\Log;

/**
 * ImageService
 * Servicio para procesar y almacenar imágenes
 */
class ImageService
{
    protected $contentImages;
    protected $uploadDir;
    protected $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    // Default máximo aceptado por la aplicación (25MB)
    protected $maxFileSize = 26214400; // 25MB

    public function __construct()
    {
        $this->contentImages = TableRegistry::getTableLocator()->get('ContentImages');
        $this->uploadDir = rtrim(WWW_ROOT, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'content';
    }

    /**
     * Procesar y guardar imagen
     *
     * @param object $uploadedFile Archivo subido
     * @param int $userId ID del usuario
     * @param int|null $sectionId ID de la sección (opcional)
     * @param int|null $blockId ID del bloque (opcional)
     * @return array|null
     * @throws Exception
     */
    public function processAndStore($uploadedFile, int $userId, ?int $sectionId = null, ?int $blockId = null): ?array
    {
        Log::info('ImageService::processAndStore called', ['userId' => $userId, 'sectionId' => $sectionId, 'blockId' => $blockId]);
        // Validar archivo
        $this->_validateFile($uploadedFile);

        // Generar nombre único
        $filename = $this->_generateFilename($uploadedFile->getClientFilename());

        // Crear directorio si no existe
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0775, true) && !is_dir($this->uploadDir)) {
                throw new Exception('No se pudo crear el directorio de uploads');
            }
        }

        // Ruta absoluta donde se guardará el archivo
        $fullPath = $this->uploadDir . DIRECTORY_SEPARATOR . $filename;

        // Guardar archivo original
        try {
            $uploadedFile->moveTo($fullPath);
            Log::info('ImageService: archivo movido', ['path' => $fullPath]);
        } catch (\Throwable $e) {
            Log::error('ImageService: fallo moveTo', ['error' => $e->getMessage()]);
            throw $e;
        }

        // Procesar imágenes (resize, optimización)
        $dimensions = $this->_processImage($fullPath);

        // Guardar registro en BD
        $publicUrl = Router::url('/uploads/content/' . $filename, true);

        $image = $this->contentImages->newEntity([
            'original_filename' => $uploadedFile->getClientFilename(),
            'stored_filename' => $filename,
            'file_path' => $publicUrl,
            'file_size' => $uploadedFile->getSize(),
            'mime_type' => $uploadedFile->getClientMediaType(),
            'dimensions' => $dimensions,
            'uploaded_by' => $userId,
            'section_id' => $sectionId,
            'block_id' => $blockId,
        ]);

        if (!$this->contentImages->save($image)) {
            // Eliminar archivo si falla guardar
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            throw new Exception('No se pudo guardar el registro de la imagen');
        }

        return [
            'id' => $image->id,
            'url' => $publicUrl,
            'filename' => $filename,
            'dimensions' => $dimensions,
        ];
    }

    /**
     * Validar archivo subido
     *
     * @param object $file Archivo subido
     * @throws Exception
     */
    protected function _validateFile($file): void
    {
        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir archivo: {$file->getError()}");
        }

        if (!in_array($file->getClientMediaType(), $this->allowedMimes)) {
            throw new Exception('Tipo de archivo no permitido. Solo se aceptan imágenes.');
        }

        if ($file->getSize() > $this->maxFileSize) {
            $phpUpload = ini_get('upload_max_filesize');
            $phpPost = ini_get('post_max_size');
            $maxMb = intval($this->maxFileSize / 1048576);
            throw new Exception("El archivo es demasiado grande ({round($file->getSize()/1048576,2)} MB). Máximo permitido por la aplicación: {$maxMb} MB. PHP limits: upload_max_filesize={$phpUpload}, post_max_size={$phpPost}.");
        }
    }

    /**
     * Generar nombre único para archivo
     *
     * @param string $originalName Nombre original
     * @return string
     */
    protected function _generateFilename(string $originalName): string
    {
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $name = uniqid('img_', true);

        return "{$name}.{$ext}";
    }

    /**
     * Procesar imagen (resize, optimización)
     *
     * @param string $path Ruta de la imagen
     * @return array Dimensiones y versiones optimizadas
     */
    protected function _processImage(string $path): array
    {
        $dimensions = [
            'width' => 0,
            'height' => 0,
            'versions' => [],
        ];

        try {
            if (!class_exists(Imagick::class)) {
                throw new Exception('Imagick no está disponible en este entorno');
            }

            $image = new Imagick($path);

            // Obtener dimensiones originales
            $dimensions['width'] = $image->getImageWidth();
            $dimensions['height'] = $image->getImageHeight();

            // Crear versiones optimizadas
            $versions = [
                'thumbnail' => 300,
                'medium' => 800,
                'large' => 1920,
            ];

            foreach ($versions as $size => $maxWidth) {
                if ($dimensions['width'] > $maxWidth) {
                    $ratio = $maxWidth / $dimensions['width'];
                    $newHeight = intval($dimensions['height'] * $ratio);

                    $image->resizeImage($maxWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
                    $versionPath = $path . ".{$size}";
                    $image->writeImage($versionPath);

                    $dimensions['versions'][$size] = [
                        'width' => $maxWidth,
                        'height' => $newHeight,
                        'path' => Router::url('/uploads/content/' . basename($versionPath), true),
                    ];

                    // Recargar imagen original para siguiente iteración
                    $image->clear();
                    $image->readImage($path);
                }
            }

            // Optimizar imagen original
            $image->setImageCompression(Imagick::COMPRESSION_JPEG);
            $image->setImageCompressionQuality(85);
            $image->writeImage($path);

            $image->destroy();
        } catch (Exception $e) {
            // Si ImageMagick falla, continuar sin procesamiento
            error_log("Error procesando imagen: " . $e->getMessage());
        }

        return $dimensions;
    }

    /**
     * Eliminar imagen
     *
     * @param int $imageId ID de la imagen
     * @return bool
     */
    public function delete(int $imageId): bool
    {
        $image = $this->contentImages->get($imageId);

        if (!$image) {
            return false;
        }

        // Eliminar archivos
        $this->_deleteFiles((string)$image->get('file_path'));

        // Marcar como inactiva
        $image->set('is_active', false);

        return (bool)$this->contentImages->save($image);
    }

    /**
     * Eliminar archivos de imagen
     *
     * @param string $filePath Ruta del archivo
     */
    protected function _deleteFiles(string $filePath): void
    {
        $fullPath = WWW_ROOT . ltrim($filePath, '/');

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Eliminar versiones
        foreach (['thumbnail', 'medium', 'large'] as $size) {
            $versionPath = $fullPath . ".{$size}";
            if (file_exists($versionPath)) {
                unlink($versionPath);
            }
        }
    }

    /**
     * Obtener imágenes de una sección
     *
     * @param int $sectionId ID de la sección
     * @return array
     */
    public function getSectionImages(int $sectionId): array
    {
        return $this->contentImages->getSectionImages($sectionId)->toArray();
    }

    /**
     * Obtener URL de imagen en tamaño específico
     *
     * @param int $imageId ID de la imagen
     * @param string $size 'thumbnail', 'medium', 'large' o 'original'
     * @return string|null
     */
    public function getImageUrl(int $imageId, string $size = 'original'): ?string
    {
        $image = $this->contentImages->get($imageId);

        if (!$image) {
            return null;
        }

        if ($size === 'original') {
            return (string)$image->get('file_path');
        }

        return $image->dimensions['versions'][$size]['path'] ?? null;
    }
}
