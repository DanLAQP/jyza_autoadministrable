<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentBlock Entity
 */
class ContentBlock extends Entity
{
    protected array $_accessible = [
        'section_id' => true,
        'block_key' => true,
        'block_type' => true,
        'content' => true,
        'metadata' => true,
        'sort_order' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'content_section' => true,
        'content_versions' => true,
    ];

    protected array $_virtual = ['formatted_content'];

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
     * Obtener contenido formateado según el tipo
     */
    protected function _getFormattedContent()
    {
        switch ($this->block_type) {
            case 'json':
                return json_decode($this->content, true);

            case 'wysiwyg':
                return $this->content; // Ya está en HTML

            case 'text':
            case 'textarea':
            case 'video':
            case 'image':
            default:
                return $this->content;
        }
    }

    /**
     * Validar contenido según tipo
     */
    public function validateContent()
    {
        switch ($this->block_type) {
            case 'json':
                json_decode($this->content);
                return json_last_error() === JSON_ERROR_NONE;

            case 'video':
                return filter_var($this->content, FILTER_VALIDATE_URL) !== false;

            case 'image':
                return is_numeric($this->content);

            default:
                return !empty($this->content);
        }
    }
}
