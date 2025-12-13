<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Asset Helper
 * 
 * Helper para generar URLs de archivos estáticos correctamente
 */
class AssetHelper extends Helper
{
    /**
     * Genera la URL completa de un archivo en webroot
     * 
     * @param string|null $path Ruta relativa del archivo (ej: 'uploads/cursos/imagen.jpg')
     * @param array $options Opciones adicionales
     * @return string|null URL completa del archivo
     */
    public function url(?string $path, array $options = []): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // Remover 'webroot/' si existe al inicio
        $path = preg_replace('#^webroot/#', '', $path);
        
        // Remover '/' del inicio si existe
        $path = ltrim($path, '/');
        
        // Generar URL completa
        $baseUrl = $this->getView()->getRequest()->getAttribute('base');
        
        return $baseUrl . '/' . $path;
    }
    
    /**
     * Verifica si un archivo existe en webroot
     * 
     * @param string|null $path Ruta relativa del archivo
     * @return bool
     */
    public function exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }
        
        $path = preg_replace('#^webroot/#', '', $path);
        $path = ltrim($path, '/');
        
        $fullPath = WWW_ROOT . $path;
        
        return file_exists($fullPath);
    }
    
    /**
     * Obtiene el tamaño del archivo en formato legible
     * 
     * @param string|null $path Ruta relativa del archivo
     * @return string|null Tamaño formateado (ej: "2.5 MB")
     */
    public function fileSize(?string $path): ?string
    {
        if (empty($path) || !$this->exists($path)) {
            return null;
        }
        
        $path = preg_replace('#^webroot/#', '', $path);
        $path = ltrim($path, '/');
        $fullPath = WWW_ROOT . $path;
        
        $bytes = filesize($fullPath);
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
