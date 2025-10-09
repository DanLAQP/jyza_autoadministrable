<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdenesTratamientos Model
 *
 * @property \App\Model\Table\OrdenesTable&\Cake\ORM\Association\BelongsTo $Ordenes
 * @property \App\Model\Table\TratamientosTable&\Cake\ORM\Association\BelongsTo $Tratamientos
 *
 * @method \App\Model\Entity\OrdenesTratamiento newEmptyEntity()
 * @method \App\Model\Entity\OrdenesTratamiento newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OrdenesTratamiento> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdenesTratamiento get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OrdenesTratamiento findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OrdenesTratamiento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OrdenesTratamiento> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdenesTratamiento|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OrdenesTratamiento saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesTratamiento>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesTratamiento> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesTratamiento>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrdenesTratamiento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrdenesTratamiento> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdenesTratamientosTable extends Table
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

        $this->setTable('ordenes_tratamientos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ordenes', [
    'foreignKey' => 'orden_id',
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
            ->integer('orden_id')
            ->allowEmptyString('orden_id');

        $validator
            ->integer('tratamiento_id')
            ->notEmptyString('tratamiento_id');

        $validator
            ->integer('cantidad')
            ->requirePresence('cantidad', 'create')
            ->notEmptyString('cantidad');

        $validator
            ->decimal('precio_unitario')
            ->requirePresence('precio_unitario', 'create')
            ->notEmptyString('precio_unitario');

        $validator
            ->decimal('subtotal')
            ->requirePresence('subtotal', 'create')
            ->notEmptyString('subtotal');

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
        $rules->add($rules->existsIn(['orden_id'], 'Ordenes'), ['errorField' => 'orden_id']);
        $rules->add($rules->existsIn(['tratamiento_id'], 'Tratamientos'), ['errorField' => 'tratamiento_id']);

        return $rules;
    }
}
