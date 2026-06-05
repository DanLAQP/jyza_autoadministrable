<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentSection Entity
 */
class ContentSection extends Entity
{
    protected array $_accessible = [
        'slug' => true,
        'title' => true,
        'description' => true,
        'metadata' => true,
        'is_active' => true,
        'sort_order' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'content_blocks' => true,
        'content_images' => true,
        'user' => true,
    ];

    protected array $_virtual = [];

    protected array $_hidden = [];

    /**
     * Convertir metadata JSON a array
     */
    protected function _getMetadata()
    {
        $meta = $this->_properties['metadata'] ?? null;

        if ($meta === null || $meta === '') {
            return [];
        }

        if (is_string($meta)) {
            return json_decode($meta, true) ?? [];
        }

        return (array)$meta;
    }

    /**
     * Convertir metadata array a JSON
     */
    protected function _setMetadata($value)
    {
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $value;
    }

    /**
     * Obtener bloque específico
     */
    public function getBlock($key)
    {
        if (!isset($this->content_blocks)) {
            return null;
        }

        foreach ($this->content_blocks as $block) {
            if ($block->block_key === $key) {
                return $block;
            }
        }

        return null;
    }

    /**
     * Obtener contenido de bloque
     */
    public function getBlockContent($key, $default = '')
    {
        $block = $this->getBlock($key);
        return $block ? $block->content : $default;
    }
}
