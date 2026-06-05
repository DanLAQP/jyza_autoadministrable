<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Query\SelectQuery;

/**
 * SoftDelete Behavior
 * 
 * Marca registros como eliminados en lugar de borrarlos físicamente.
 * Agrega un campo deleted_at que es NULL para registros activos y contiene
 * la fecha/hora para registros eliminados.
 */
class SoftDeleteBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected array $_defaultConfig = [
        'field' => 'deleted_at',
    ];

    /**
     * Antes de eliminar, marca como eliminado en lugar de borrar físicamente
     */
    public function beforeDelete(EventInterface $event, $entity, $options)
    {
        $field = $this->getConfig('field');
        
        // Marcar como eliminado
        $entity->set($field, new \DateTime());
        
        // Guardar en lugar de eliminar
        $this->_table->save($entity, ['skipValidation' => true]);
        
        // Prevenir la eliminación física
        $event->stopPropagation();
        
        return $event;
    }

    /**
     * Antes de encontrar, excluir registro eliminados
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, $options)
    {
        $field = $this->getConfig('field');
        $alias = $this->_table->getAlias();
        
        // Solo excluir si no está explícitamente permitido buscar deleteds
        if (!isset($options['includeDeleted']) || !$options['includeDeleted']) {
            $query->where(["{$alias}.{$field} IS" => null]);
        }
    }

    /**
     * Restaurar un registro eliminado
     */
    public function restore($entity)
    {
        $field = $this->getConfig('field');
        
        $entity->set($field, null);
        
        return $this->_table->save($entity, ['skipValidation' => true]);
    }
}
