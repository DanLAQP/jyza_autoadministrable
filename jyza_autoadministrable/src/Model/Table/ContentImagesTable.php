<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentImages Table
 */
class ContentImagesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('content_images');
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
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('ContentBlocks', [
            'foreignKey' => 'block_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'uploaded_by',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('original_filename')
            ->maxLength('original_filename', 255)
            ->requirePresence('original_filename', 'create')
            ->notEmptyString('original_filename');

        $validator
            ->scalar('stored_filename')
            ->maxLength('stored_filename', 255)
            ->requirePresence('stored_filename', 'create')
            ->notEmptyString('stored_filename');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 500)
            ->requirePresence('file_path', 'create')
            ->notEmptyString('file_path');

        $validator
            ->integer('file_size')
            ->allowEmptyString('file_size');

        $validator
            ->scalar('mime_type')
            ->maxLength('mime_type', 100)
            ->allowEmptyString('mime_type');

        $validator
            ->scalar('alt_text')
            ->maxLength('alt_text', 500)
            ->allowEmptyString('alt_text');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->integer('uploaded_by')
            ->notEmptyString('uploaded_by');

        return $validator;
    }

    /**
     * Obtener imágenes de una sección
     */
    public function getSectionImages($sectionId)
    {
        return $this->find()
            ->where([
                'section_id' => $sectionId,
                'is_active' => true,
            ])
            ->orderBy(['created' => 'DESC'])
            ->all();
    }

    /**
     * Obtener imágenes de un bloque
     */
    public function getBlockImages($blockId)
    {
        return $this->find()
            ->where([
                'block_id' => $blockId,
                'is_active' => true,
            ])
            ->all();
    }
}
