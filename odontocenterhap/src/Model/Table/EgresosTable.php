<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Egresos Model
 *
 * @method \App\Model\Entity\Egreso newEmptyEntity()
 * @method \App\Model\Entity\Egreso newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Egreso> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Egreso get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Egreso findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Egreso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Egreso> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Egreso|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Egreso saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Egreso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Egreso>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Egreso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Egreso> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Egreso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Egreso>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Egreso>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Egreso> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EgresosTable extends Table
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

        $this->setTable('egresos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('cantidad')
            ->allowEmptyString('cantidad');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

        return $validator;
    }
}
