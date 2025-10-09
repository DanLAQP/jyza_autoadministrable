<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegistrosTratamientos Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 * @property \App\Model\Table\TratamientosTable&\Cake\ORM\Association\BelongsTo $Tratamientos
 *
 * @method \App\Model\Entity\RegistrosTratamientos newEmptyEntity()
 * @method \App\Model\Entity\RegistrosTratamientos newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RegistrosTratamientos> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RegistrosTratamientos get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RegistrosTratamientos findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RegistrosTratamientos patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RegistrosTratamientos> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RegistrosTratamientos|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RegistrosTratamientos saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosTratamientos>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosTratamientos>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosTratamientos>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosTratamientos> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosTratamientos>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosTratamientos>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosTratamientos>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosTratamientos> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegistrosTratamientosTable extends Table
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

        $this->setTable('registros_tratamientos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pacientes', [
            'foreignKey' => 'paciente_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tratamientos', [
            'foreignKey' => 'tratamiento_id',
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
            ->integer('paciente_id')
            ->allowEmptyString('paciente_id');

        $validator
            ->integer('tratamiento_id')
            ->allowEmptyString('tratamiento_id');

        $validator
            ->scalar('notas')
            ->allowEmptyString('notas');

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
        $rules->add($rules->existsIn(['paciente_id'], 'Pacientes'), ['errorField' => 'paciente_id']);
        $rules->add($rules->existsIn(['tratamiento_id'], 'Tratamientos'), ['errorField' => 'tratamiento_id']);

        return $rules;
    }
}
