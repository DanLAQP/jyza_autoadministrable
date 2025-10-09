<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EnfermedadesActuales Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 *
 * @method \App\Model\Entity\EnfermedadesActuales newEmptyEntity()
 * @method \App\Model\Entity\EnfermedadesActuale newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EnfermedadesActuales> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EnfermedadesActuales get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EnfermedadesActuales findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EnfermedadesActuales patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EnfermedadesActuales> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EnfermedadesActuales|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EnfermedadesActuales saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EnfermedadesActuales>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EnfermedadesActuales>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EnfermedadesActuales>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EnfermedadesActuales> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EnfermedadesActuales>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EnfermedadesActuales>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EnfermedadesActuales>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EnfermedadesActuales> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EnfermedadesActualesTable extends Table
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

        $this->setTable('enfermedades_actuales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pacientes', [
            'foreignKey' => 'paciente_id',
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
            ->scalar('enfermedad')
            ->allowEmptyString('enfermedad');

        $validator
            ->scalar('tiempo_enfermedad')
            ->maxLength('tiempo_enfermedad', 50)
            ->allowEmptyString('tiempo_enfermedad');

        $validator
            ->scalar('sintomas_principales')
            ->allowEmptyString('sintomas_principales');

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

        return $rules;
    }
}
