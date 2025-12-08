<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modulos Model
 *
 * @property \App\Model\Table\CursosTable&\Cake\ORM\Association\BelongsTo $Cursos
 * @property \App\Model\Table\LeccionesTable&\Cake\ORM\Association\HasMany $Lecciones
 *
 * @method \App\Model\Entity\Modulo newEmptyEntity()
 * @method \App\Model\Entity\Modulo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Modulo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Modulo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Modulo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Modulo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Modulo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Modulo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Modulo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Modulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Modulo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Modulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Modulo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Modulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Modulo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Modulo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Modulo> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModulosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('modulos');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cursos', [
            'foreignKey' => 'curso_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Lecciones', [
            'foreignKey' => 'modulo_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('curso_id')
            ->notEmptyString('curso_id');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->integer('posicion')
            ->notEmptyString('posicion');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['curso_id'], 'Cursos'), ['errorField' => 'curso_id']);

        return $rules;
    }
}
