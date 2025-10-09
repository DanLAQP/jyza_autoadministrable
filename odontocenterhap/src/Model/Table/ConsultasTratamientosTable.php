<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConsultasTratamientos Model
 *
 * @property \App\Model\Table\RegistrosConsultasTable&\Cake\ORM\Association\BelongsTo $RegistrosConsultas
 * @property \App\Model\Table\TratamientosTable&\Cake\ORM\Association\BelongsTo $Tratamientos
 *
 * @method \App\Model\Entity\ConsultasTratamiento newEmptyEntity()
 * @method \App\Model\Entity\ConsultasTratamiento newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ConsultasTratamiento> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConsultasTratamiento get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ConsultasTratamiento findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ConsultasTratamiento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ConsultasTratamiento> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConsultasTratamiento|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ConsultasTratamiento saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultasTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultasTratamiento>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultasTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultasTratamiento> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultasTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultasTratamiento>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConsultasTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConsultasTratamiento> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConsultasTratamientosTable extends Table
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

        $this->setTable('consultas_tratamientos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RegistrosConsultas', [
            'foreignKey' => 'registro_id',
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
            ->integer('registro_id')
            ->notEmptyString('registro_id');

        $validator
            ->integer('tratamiento_id')
            ->notEmptyString('tratamiento_id');

        $validator
            ->decimal('costo')
            ->notEmptyString('costo');

        $validator
            ->decimal('monto_clinica')
            ->notEmptyString('monto_clinica');

        $validator
            ->decimal('monto_doctor')
            ->notEmptyString('monto_doctor');

        $validator
            ->decimal('monto_materiales')
            ->notEmptyString('monto_materiales');

        $validator
            ->integer('cantidad')
            ->notEmptyString('cantidad');

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
        $rules->add($rules->existsIn(['registro_id'], 'RegistrosConsultas'), ['errorField' => 'registro_id']);
        $rules->add($rules->existsIn(['tratamiento_id'], 'Tratamientos'), ['errorField' => 'tratamiento_id']);

        return $rules;
    }
}
