<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AntecedentesOdontologicos Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 *
 * @method \App\Model\Entity\AntecedentesOdontologico newEmptyEntity()
 * @method \App\Model\Entity\AntecedentesOdontologico newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AntecedentesOdontologico> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AntecedentesOdontologico get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AntecedentesOdontologico findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AntecedentesOdontologico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AntecedentesOdontologico> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AntecedentesOdontologico|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AntecedentesOdontologico saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesOdontologico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesOdontologico>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesOdontologico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesOdontologico> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesOdontologico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesOdontologico>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AntecedentesOdontologico>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AntecedentesOdontologico> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AntecedentesOdontologicosTable extends Table
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

        $this->setTable('antecedentes_odontologicos');
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
            ->scalar('motivo_consulta')
            ->allowEmptyString('motivo_consulta');

        $validator
            ->scalar('frecuencia_visita')
            ->maxLength('frecuencia_visita', 50)
            ->allowEmptyString('frecuencia_visita');

        $validator
            ->scalar('experiencia_traumatica')
            ->allowEmptyString('experiencia_traumatica');

        $validator
            ->scalar('extracciones_dentales')
            ->allowEmptyString('extracciones_dentales');

        $validator
            ->scalar('complicaciones_anestesia')
            ->allowEmptyString('complicaciones_anestesia');

        $validator
            ->scalar('sangrado_encias')
            ->allowEmptyString('sangrado_encias');

        $validator
            ->date('fecha_ultima_profilaxis')
            ->allowEmptyDate('fecha_ultima_profilaxis');

        $validator
            ->scalar('dolor_mandibula')
            ->allowEmptyString('dolor_mandibula');

        $validator
            ->scalar('satisfaccion_dental')
            ->maxLength('satisfaccion_dental', 50)
            ->allowEmptyString('satisfaccion_dental');

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
