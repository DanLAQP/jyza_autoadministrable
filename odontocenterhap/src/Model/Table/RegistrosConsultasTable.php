<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegistrosConsultas Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 * @property \App\Model\Table\DoctoresTable&\Cake\ORM\Association\BelongsTo $Doctores
 *
 * @method \App\Model\Entity\RegistrosConsulta newEmptyEntity()
 * @method \App\Model\Entity\RegistrosConsulta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RegistrosConsulta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RegistrosConsulta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RegistrosConsulta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RegistrosConsulta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RegistrosConsulta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RegistrosConsulta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RegistrosConsulta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosConsulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosConsulta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosConsulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosConsulta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosConsulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosConsulta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RegistrosConsulta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RegistrosConsulta> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegistrosConsultasTable extends Table
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

        $this->setTable('registros_consultas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pacientes1', [
            'foreignKey' => 'paciente_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctores', [
            'foreignKey' => 'doctor_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('ConsultasTratamientos', [
            'foreignKey' => 'registro_id', 
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
            ->notEmptyString('paciente_id');

        $validator
            ->integer('doctor_id')
            ->notEmptyString('doctor_id');

        $validator
            ->scalar('observaciones')
            ->maxLength('observaciones', 255)
            ->allowEmptyString('observaciones');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 1)
            ->notEmptyString('estado');

        $validator
            ->scalar('tipo_pago')
            ->maxLength('tipo_pago', 255)
            ->requirePresence('tipo_pago', 'create')
            ->notEmptyString('tipo_pago');

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
        $rules->add($rules->existsIn(['paciente_id'], 'Pacientes1'), ['errorField' => 'paciente_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctores'), ['errorField' => 'doctor_id']);

        return $rules;
    }
}
