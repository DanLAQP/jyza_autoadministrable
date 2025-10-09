<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AntecedentesMedicos Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 *
 * @method \App\Model\Entity\AntecedentesMedico newEmptyEntity()
 * @method \App\Model\Entity\AntecedentesMedico newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AntecedentesMedico> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AntecedentesMedico get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AntecedentesMedico findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AntecedentesMedico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AntecedentesMedico> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AntecedentesMedico|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AntecedentesMedico saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesMedico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesMedico>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesMedico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesMedico> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesMedico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesMedico>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesMedico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesMedico> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AntecedentesMedicosTable extends Table
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

        $this->setTable('antecedentes_medicos');
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
            ->scalar('alergias')
            ->allowEmptyString('alergias');

        $validator
            ->scalar('medicacion')
            ->allowEmptyString('medicacion');

        $validator
            ->scalar('nombre_medico')
            ->maxLength('nombre_medico', 50)
            ->allowEmptyString('nombre_medico');

        $validator
            ->scalar('telefono_medico')
            ->maxLength('telefono_medico', 20)
            ->allowEmptyString('telefono_medico');

        $validator
            ->scalar('hepatitis')
            ->allowEmptyString('hepatitis');

        $validator
            ->scalar('tipo_hepatitis')
            ->maxLength('tipo_hepatitis', 50)
            ->allowEmptyString('tipo_hepatitis');

        $validator
            ->scalar('diabetes')
            ->allowEmptyString('diabetes');

        $validator
            ->scalar('diabetes_estado')
            ->maxLength('diabetes_estado', 50)
            ->allowEmptyString('diabetes_estado');

        $validator
            ->scalar('condicion_cardiaca')
            ->maxLength('condicion_cardiaca', 50)
            ->allowEmptyString('condicion_cardiaca');

        $validator
            ->scalar('tratamiento_cardiaco')
            ->maxLength('tratamiento_cardiaco', 50)
            ->allowEmptyString('tratamiento_cardiaco');

        $validator
            ->scalar('presion_alta')
            ->allowEmptyString('presion_alta');

        $validator
            ->scalar('enfermedad_riesgo')
            ->allowEmptyString('enfermedad_riesgo');

        $validator
            ->scalar('estado_gestacion')
            ->allowEmptyString('estado_gestacion');

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
