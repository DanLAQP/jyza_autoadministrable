<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentSections Table
 */
class ContentSectionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('content_sections');
        $this->setDisplayField('title');
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
        $this->belongsTo('Users', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('ContentBlocks', [
            'foreignKey' => 'section_id',
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('ContentImages', [
            'foreignKey' => 'section_id',
        ]);

        $this->hasMany('ContentVersions', [
            'through' => 'ContentBlocks',
            'foreignKey' => 'section_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug')
            ->unique('slug', message: 'Este slug ya existe');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('is_active')
            ->notEmptyString('is_active');

        $validator
            ->integer('sort_order')
            ->notEmptyString('sort_order');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['slug']), 'unique_slug');
        $rules->add($rules->existsIn(['created_by'], 'Users'), 'valid_user');

        return $rules;
    }

    /**
     * Obtener contenido completo de la sección con caché
     */
    public function getFullContent($slug, $useCache = true)
    {
        $cacheKey = "content_section_{$slug}";

        if ($useCache) {
            $cached = cache($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        $section = $this->find()
            ->where([
                'slug' => $slug,
                'is_active' => true,
            ])
            ->contain([
                'ContentBlocks' => [
                    'sort' => ['ContentBlocks.sort_order' => 'ASC']
                ],
                'ContentImages' => [
                    'sort' => ['ContentImages.id' => 'DESC']
                ]
            ])
            ->first();

        if ($section && $useCache) {
            cache($cacheKey, $section, '+1 hour');
        }

        return $section;
    }

    /**
     * Obtener todas las secciones activas
     */
    public function getAllActive($useCache = true)
    {
        $cacheKey = 'content_all_sections';

        if ($useCache) {
            $cached = cache($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        $sections = $this->find()
            ->where(['is_active' => true])
            ->orderBy(['sort_order' => 'ASC'])
            ->contain([
                'ContentBlocks' => [
                    'sort' => ['ContentBlocks.sort_order' => 'ASC']
                ],
                'ContentImages'
            ])
            ->toArray();

        if ($useCache) {
            cache($cacheKey, $sections, '+1 hour');
        }

        return $sections;
    }

    /**
     * Invalidar caché de sección
     */
    public function invalidateCache($slug = null)
    {
        if ($slug) {
            cache("content_section_{$slug}", null);
        }
        cache('content_all_sections', null);
        cache('content_all', null);
    }
}
