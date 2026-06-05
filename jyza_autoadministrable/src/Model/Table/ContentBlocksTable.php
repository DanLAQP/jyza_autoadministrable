<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentBlocks Table
 */
class ContentBlocksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('content_blocks');
        $this->setDisplayField('block_key');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ]
            ]
        ]);

        // Relaciones
        $this->belongsTo('ContentSections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('ContentVersions', [
            'foreignKey' => 'block_id',
            'cascadeCallbacks' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('block_key')
            ->maxLength('block_key', 100)
            ->requirePresence('block_key', 'create')
            ->notEmptyString('block_key');

        $validator
            ->scalar('block_type')
            ->inList('block_type', ['text', 'textarea', 'wysiwyg', 'image', 'video', 'json'])
            ->requirePresence('block_type', 'create')
            ->notEmptyString('block_type');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        $validator
            ->integer('section_id')
            ->notEmptyString('section_id');

        $validator
            ->integer('sort_order')
            ->notEmptyString('sort_order');

        $validator
            ->integer('is_active')
            ->notEmptyString('is_active');

        // Validación de contenido según el tipo
        $validator->add('content', 'validType', [
            'rule' => function($value, $context) {
                $type = $context['data']['block_type'] ?? null;

                if ($value === null || $value === '') {
                    return true;
                }

                switch ($type) {
                    case 'json':
                        // Validar que sea JSON válido
                        if (is_string($value)) {
                            json_decode($value);
                            return json_last_error() === JSON_ERROR_NONE;
                        }
                        return true;

                    case 'video':
                        // Validar URL
                        return filter_var($value, FILTER_VALIDATE_URL) !== false;

                    case 'image':
                        // Permitir ID numérico o ruta/URL guardada en el bloque
                        if (is_numeric($value)) {
                            return true;
                        }

                        return is_string($value)
                            && (
                                filter_var($value, FILTER_VALIDATE_URL) !== false
                                || str_starts_with($value, '/')
                            );

                    case 'wysiwyg':
                    case 'textarea':
                    case 'text':
                    default:
                        return true;
                }
            },
            'message' => 'El contenido no es válido para este tipo de bloque'
        ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['section_id'], 'ContentSections'));
        // Usar isUnique para validar unicidad compuesta
        $rules->add($rules->isUnique(['section_id', 'block_key']), 'unique_key');

        return $rules;
    }

    /**
     * Obtener bloque de contenido específico
     */
    public function getBlockContent($sectionId, $blockKey)
    {
        return $this->find()
            ->where([
                'section_id' => $sectionId,
                'block_key' => $blockKey,
                'is_active' => true,
            ])
            ->first();
    }

    /**
     * Obtener todos los bloques de una sección
     */
    public function getSectionBlocks($sectionId)
    {
        return $this->find()
            ->where([
                'section_id' => $sectionId,
                'is_active' => true,
            ])
            ->orderBy(['sort_order' => 'ASC'])
            ->all()
            ->indexBy('block_key');
    }
}
