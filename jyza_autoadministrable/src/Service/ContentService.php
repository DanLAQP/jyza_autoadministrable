<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;

/**
 * ContentService
 * Servicio para gestionar contenido con caché y formateado para API
 */
class ContentService
{
    protected $contentSections;
    protected $contentBlocks;
    protected $contentVersions;

    public function __construct()
    {
        $this->contentSections = TableRegistry::getTableLocator()->get('ContentSections');
        $this->contentBlocks = TableRegistry::getTableLocator()->get('ContentBlocks');
        $this->contentVersions = TableRegistry::getTableLocator()->get('ContentVersions');
    }

    /**
     * Obtener contenido completo de una sección formateado para API
     *
     * @param string $slug Slug de la sección
     * @param bool $useCache Usar caché
     * @return array|null
     */
    public function getSectionContent(string $slug, bool $useCache = true): ?array
    {
        $cacheKey = "content_section_{$slug}";

        if ($useCache) {
            $cached = Cache::read($cacheKey, 'api');
            if ($cached !== null) {
                return $cached;
            }
        }

        $section = $this->contentSections->getFullContent($slug, useCache: false);

        if (!$section) {
            return null;
        }

        $data = $this->_formatSectionContent($section);

        if ($useCache) {
            Cache::write($cacheKey, $data, 'api');
        }

        return $data;
    }

    /**
     * Obtener todo el contenido por secciones formateado para API
     *
     * @param bool $useCache Usar caché
     * @return array
     */
    public function getAllSectionsContent(bool $useCache = true): array
    {
        $cacheKey = 'content_all_sections';

        if ($useCache) {
            $cached = Cache::read($cacheKey, 'api');
            if ($cached !== null) {
                return $cached;
            }
        }

        $sections = $this->contentSections->getAllActive(useCache: false);

        $data = [];
        foreach ($sections as $section) {
            $data[$section->slug] = $this->_formatSectionContent($section);
        }

        if ($useCache) {
            Cache::write($cacheKey, $data, 'api');
        }

        return $data;
    }

    /**
     * Obtener contenido de un bloque específico
     *
     * @param string $sectionSlug Slug de la sección
     * @param string $blockKey Clave del bloque
     * @return string|null
     */
    public function getBlockContent(string $sectionSlug, string $blockKey): ?string
    {
        $section = $this->contentSections->find()
            ->where(['slug' => $sectionSlug, 'is_active' => true])
            ->contain(['ContentBlocks'])
            ->first();

        if (!$section) {
            return null;
        }

        $block = $section->getBlock($blockKey);
        return $block ? $block->content : null;
    }

    /**
     * Formatear contenido de sección para API
     *
     * @param object $section Entidad de sección
     * @return array
     */
    private function _formatSectionContent($section): array
    {
        $blocks = [];

        if ($section->content_blocks) {
            foreach ($section->content_blocks as $block) {
                $blocks[$block->block_key] = [
                    'id' => $block->id,
                    'type' => $block->block_type,
                    'content' => $this->_formatBlockContent($block),
                    'metadata' => $block->metadata,
                ];
            }
        }

        $images = [];
        if ($section->content_images) {
            foreach ($section->content_images as $img) {
                $images[] = [
                    'id' => $img->id,
                    'url' => $img->file_path,
                    'alt' => $img->alt_text,
                    'title' => $img->title,
                    'dimensions' => $img->dimensions,
                ];
            }
        }

        return [
            'id' => $section->id,
            'slug' => $section->slug,
            'title' => $section->title,
            'description' => $section->description,
            'metadata' => $section->metadata,
            'blocks' => $blocks,
            'images' => $images,
            'updated_at' => $section->modified->toIso8601String(),
        ];
    }

    /**
     * Formatear contenido según el tipo de bloque
     *
     * @param object $block Entidad de bloque
     * @return mixed
     */
    private function _formatBlockContent($block)
    {
        switch ($block->block_type) {
            case 'json':
                return json_decode($block->content, true);

            case 'wysiwyg':
            case 'textarea':
            case 'text':
            case 'video':
            default:
                return $block->content;
        }
    }

    /**
     * Actualizar contenido de un bloque
     *
     * @param int $blockId ID del bloque
     * @param string $content Nuevo contenido
     * @param int $userId ID del usuario que realiza el cambio
     * @param string|null $reason Razón del cambio
     * @return bool
     */
    public function updateBlockContent(
        int $blockId,
        string $content,
        int $userId,
        ?string $reason = null
    ): bool {
        $block = $this->contentBlocks->get($blockId);

        if (!$block) {
            return false;
        }

        $contentBefore = $block->content;
        $block->content = $content;

        if (!$this->contentBlocks->save($block)) {
            return false;
        }

        // Registrar versión
        $this->contentVersions->recordChange(
            $blockId,
            $contentBefore,
            $content,
            $userId,
            $reason
        );

        // Invalidar caché
        $section = $this->contentSections->get($block->section_id);
        $this->contentSections->invalidateCache($section->slug);

        return true;
    }

    /**
     * Restaurar versión anterior de un bloque
     *
     * @param int $versionId ID de la versión
     * @param int $userId ID del usuario
     * @return bool
     */
    public function restoreVersion(int $versionId, int $userId): bool
    {
        $version = $this->contentVersions->get($versionId);

        if (!$version) {
            return false;
        }

        $result = $this->contentVersions->restoreVersion($versionId, $userId);

        if ($result) {
            // Invalidar caché
            $block = $this->contentBlocks->get($version->block_id);
            $section = $this->contentSections->get($block->section_id);
            $this->contentSections->invalidateCache($section->slug);
        }

        return (bool)$result;
    }

    /**
     * Obtener historial de un bloque
     *
     * @param int $blockId ID del bloque
     * @param int $limit Límite de registros
     * @return array
     */
    public function getBlockHistory(int $blockId, int $limit = 20): array
    {
        return $this->contentVersions->getBlockHistory($blockId, $limit)->toArray();
    }

    /**
     * Limpiar todo el caché de contenido
     */
    public function clearAllCache(): void
    {
        Cache::delete('content_all_sections', 'api');

        $sections = $this->contentSections->find()->all();
        foreach ($sections as $section) {
            Cache::delete("content_section_{$section->slug}", 'api');
        }
    }
}
