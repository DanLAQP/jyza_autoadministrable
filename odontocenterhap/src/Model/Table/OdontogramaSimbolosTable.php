<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OdontogramaSimbolos Model
 *
 * @property \App\Model\Table\OdontogramaTable&\Cake\ORM\Association\BelongsTo $Odontograma
 * @property \App\Model\Table\SimbolosTable&\Cake\ORM\Association\BelongsTo $Simbolos
 *
 * @method \App\Model\Entity\OdontogramaSimbolo newEmptyEntity()
 * @method \App\Model\Entity\OdontogramaSimbolo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OdontogramaSimbolo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OdontogramaSimbolo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OdontogramaSimbolo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OdontogramaSimbolo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OdontogramaSimbolo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OdontogramaSimbolo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OdontogramaSimbolo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaSimbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaSimbolo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaSimbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaSimbolo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaSimbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaSimbolo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OdontogramaSimbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OdontogramaSimbolo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class OdontogramaSimbolosTable extends Table
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

        $this->setTable('odontograma_simbolos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Odontograma', [
            'foreignKey' => 'odontograma_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Simbolos', [
            'foreignKey' => 'simbolo_id',
            'joinType' => 'INNER', // Asegura que se carguen los símbolos relacionados.
        ]);
        $this->belongsTo('Dientes', [
            'foreignKey' => 'diente_id',
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
            ->integer('simbolo_id')
            ->notEmptyString('simbolo_id');

        // Permitir valores flotantes para posicion_x y posicion_y
    $validator
    ->decimal('posicion_x')
    ->allowEmptyString('posicion_x');

$validator
    ->decimal('posicion_y')
    ->allowEmptyString('posicion_y');

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
        $rules->add($rules->existsIn(['simbolo_id'], 'Simbolos'), ['errorField' => 'simbolo_id']);

        return $rules;
    }
}
