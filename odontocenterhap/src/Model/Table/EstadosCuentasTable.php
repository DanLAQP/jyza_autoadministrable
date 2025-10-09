<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EstadosCuentas Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 *
 * @method \App\Model\Entity\EstadosCuenta newEmptyEntity()
 * @method \App\Model\Entity\EstadosCuenta newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EstadosCuenta> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EstadosCuenta get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EstadosCuenta findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EstadosCuenta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EstadosCuenta> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EstadosCuenta|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EstadosCuenta saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EstadosCuenta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EstadosCuenta>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EstadosCuenta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EstadosCuenta> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EstadosCuenta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EstadosCuenta>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EstadosCuenta>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EstadosCuenta> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EstadosCuentasTable extends Table
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

        $this->setTable('estados_cuentas');
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
            ->decimal('saldo_actual')
            ->allowEmptyString('saldo_actual');

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
