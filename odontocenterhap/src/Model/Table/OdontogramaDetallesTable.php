<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OdontogramaDetalles Model
 *
 * @property \App\Model\Table\OdontogramaTable&\Cake\ORM\Association\BelongsTo $Odontograma
 *
 * @method \App\Model\Entity\OdontogramaDetalle newEmptyEntity()
 * @method \App\Model\Entity\OdontogramaDetalle newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OdontogramaDetalle> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OdontogramaDetalle get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OdontogramaDetalle findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OdontogramaDetalle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OdontogramaDetalle> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OdontogramaDetalle|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OdontogramaDetalle saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaDetalle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaDetalle>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaDetalle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaDetalle> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaDetalle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaDetalle>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaDetalle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaDetalle> deleteManyOrFail(iterable $entities, array $options = [])
 */
class OdontogramaDetallesTable extends Table
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

        $this->setTable('odontograma_detalles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Odontograma', [
            'foreignKey' => 'odontograma_id',
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
            ->integer('odontograma_id')
            ->notEmptyString('odontograma_id');

        $validator
            ->scalar('especificaciones')
            ->maxLength('especificaciones', 255)
            ->allowEmptyString('especificaciones');

        $validator
            ->scalar('observaciones')
            ->maxLength('observaciones', 255)
            ->allowEmptyString('observaciones');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['odontograma_id'], 'Odontograma'), ['errorField' => 'odontograma_id']);

        return $rules;
    }
}
