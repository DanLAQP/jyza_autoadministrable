<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentVersions Table - Auditoría de cambios
 */
class ContentVersionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('content_versions');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ]
            ]
        ]);

        // Relaciones
        $this->belongsTo('ContentBlocks', [
            'foreignKey' => 'block_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'changed_by',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('block_id')
            ->notEmptyString('block_id');

        $validator
            ->scalar('content_before')
            ->allowEmptyString('content_before');

        $validator
            ->scalar('content_after')
            ->allowEmptyString('content_after');

        $validator
            ->scalar('change_type')
            ->inList('change_type', ['created', 'updated', 'deleted'])
            ->requirePresence('change_type', 'create')
            ->notEmptyString('change_type');

        $validator
            ->integer('changed_by')
            ->notEmptyString('changed_by');

        $validator
            ->scalar('change_reason')
            ->allowEmptyString('change_reason');

        return $validator;
    }

    /**
     * Obtener historial de un bloque
     */
    public function getBlockHistory($blockId, $limit = 20)
    {
        return $this->find()
            ->where(['block_id' => $blockId])
            ->contain(['Users'])
            ->orderBy(['created' => 'DESC'])
            ->limit($limit)
            ->all();
    }

    /**
     * Crear registro de versión cuando se edita un bloque
     */
    public function recordChange($blockId, $contentBefore, $contentAfter, $userId, $reason = null)
    {
        $version = $this->newEntity([
            'block_id' => $blockId,
            'content_before' => $contentBefore,
            'content_after' => $contentAfter,
            'change_type' => $contentBefore === null ? 'created' : 'updated',
            'changed_by' => $userId,
            'change_reason' => $reason,
        ]);

        return $this->save($version);
    }

    /**
     * Restaurar una versión anterior
     */
    public function restoreVersion($versionId, $userId)
    {
        $version = $this->get($versionId);

        if (!$version) {
            return false;
        }

        // Actualizar el bloque con el contenido anterior
        $contentBlocks = $this->getTableLocator()->get('ContentBlocks');
        $block = $contentBlocks->get($version->block_id);
        $block->content = $version->content_before;

        $result = $contentBlocks->save($block);

        if ($result) {
            // Registrar la restauración como un cambio
            $this->recordChange(
                $version->block_id,
                $version->content_after,
                $version->content_before,
                $userId,
                "Restaurada versión del {$version->created->format('d/m/Y H:i:s')}"
            );
        }

        return $result;
    }
}
