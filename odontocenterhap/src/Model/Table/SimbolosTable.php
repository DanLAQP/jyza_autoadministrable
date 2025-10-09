<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Simbolos Model
 *
 * @property \App\Model\Table\OdontogramaTable&\Cake\ORM\Association\BelongsToMany $Odontograma
 *
 * @method \App\Model\Entity\Simbolo newEmptyEntity()
 * @method \App\Model\Entity\Simbolo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Simbolo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Simbolo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Simbolo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Simbolo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Simbolo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Simbolo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Simbolo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Simbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Simbolo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Simbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Simbolo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Simbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Simbolo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Simbolo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Simbolo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SimbolosTable extends Table
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

        $this->setTable('simbolos');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Odontograma', [
            'foreignKey' => 'simbolo_id',
            'targetForeignKey' => 'odontograma_id',
            'joinTable' => 'odontograma_simbolos',
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
            ->scalar('nombre')
            ->maxLength('nombre', 100)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre');

        $validator
            ->scalar('imagen')
            ->maxLength('imagen', 255)
            ->requirePresence('imagen', 'create')
            ->notEmptyString('imagen');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }
}
