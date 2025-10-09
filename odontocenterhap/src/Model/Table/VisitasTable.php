<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Visitas Model
 *
 * @property \App\Model\Table\OrdenesTable&\Cake\ORM\Association\BelongsTo $Ordenes
 *
 * @method \App\Model\Entity\Visita newEmptyEntity()
 * @method \App\Model\Entity\Visita newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Visita> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Visita get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Visita findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Visita patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Visita> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Visita|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Visita saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Visita>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Visita>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Visita>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Visita> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Visita>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Visita>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Visita>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Visita> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VisitasTable extends Table
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

        $this->setTable('visitas');
        $this->setDisplayField('tipo_pago');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ordenes', [
            'foreignKey' => 'orden_id',
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
            ->notEmptyString('orden_id');

        $validator
            ->scalar('tipo_pago')
            ->maxLength('tipo_pago', 50)
            ->requirePresence('tipo_pago', 'create')
            ->notEmptyString('tipo_pago');

        $validator
            ->decimal('abonado')
            ->requirePresence('abonado', 'create')
            ->notEmptyString('abonado');

        $validator
            ->dateTime('fecha_entrega')
            ->allowEmptyDateTime('fecha_entrega');

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

        return $rules;
    }
}
