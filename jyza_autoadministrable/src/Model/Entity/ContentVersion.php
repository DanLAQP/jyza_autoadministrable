<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentVersion Entity
 */
class ContentVersion extends Entity
{
    protected array $_accessible = [
        'block_id' => true,
        'content_before' => true,
        'content_after' => true,
        'change_type' => true,
        'changed_by' => true,
        'change_reason' => true,
        'created' => true,
        'content_block' => true,
        'user' => true,
    ];

    protected array $_virtual = ['change_summary'];

    protected array $_hidden = [];

    /**
     * Generar resumen del cambio
     */
    protected function _getChangeSummary()
    {
        $before = mb_substr($this->content_before ?? '', 0, 50);
        $after = mb_substr($this->content_after ?? '', 0, 50);

        return [
            'before' => $before . (strlen($this->content_before ?? '') > 50 ? '...' : ''),
            'after' => $after . (strlen($this->content_after ?? '') > 50 ? '...' : ''),
        ];
    }

    /**
     * Obtener etiqueta de tipo de cambio
     */
    public function getChangeBadge()
    {
        return match($this->change_type) {
            'created' => ['label' => 'Creado', 'class' => 'badge-success'],
            'updated' => ['label' => 'Actualizado', 'class' => 'badge-info'],
            'deleted' => ['label' => 'Eliminado', 'class' => 'badge-danger'],
            default => ['label' => $this->change_type, 'class' => 'badge-secondary'],
        };
    }
}
