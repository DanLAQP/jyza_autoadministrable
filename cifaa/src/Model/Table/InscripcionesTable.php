<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inscripciones Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CursosTable&\Cake\ORM\Association\BelongsTo $Cursos
 *
 * @method \App\Model\Entity\Inscripcione newEmptyEntity()
 * @method \App\Model\Entity\Inscripcione newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Inscripcione> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inscripcione get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Inscripcione findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Inscripcione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Inscripcione> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inscripcione|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Inscripcione saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Inscripcione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscripcione>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inscripcione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscripcione> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inscripcione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscripcione>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inscripcione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inscripcione> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InscripcionesTable extends Table
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

        $this->setTable('inscripciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Cursos', [
            'foreignKey' => 'curso_id',
            'joinType' => 'INNER',
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
            ->integer('usuario_id')
            ->notEmptyString('usuario_id');

        $validator
            ->integer('curso_id')
            ->notEmptyString('curso_id');

        $validator
            ->integer('progreso')
            ->allowEmptyString('progreso');

        $validator
            ->inList('estado', ['pendiente', 'aprobada', 'rechazada'])
            ->notEmptyString('estado');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Users'), ['errorField' => 'usuario_id']);
        $rules->add($rules->existsIn(['curso_id'], 'Cursos'), ['errorField' => 'curso_id']);

        return $rules;
    }
}
