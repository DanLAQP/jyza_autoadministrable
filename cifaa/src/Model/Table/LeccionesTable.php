<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lecciones Model
 *
 * @property \App\Model\Table\ModulosTable&\Cake\ORM\Association\BelongsTo $Modulos
 * @property \App\Model\Table\ContenidosLeccionTable&\Cake\ORM\Association\HasMany $ContenidosLeccion
 *
 * @method \App\Model\Entity\Leccione newEmptyEntity()
 * @method \App\Model\Entity\Leccione newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Leccione> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Leccione get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Leccione findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Leccione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Leccione> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Leccione|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Leccione saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Leccione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Leccione>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Leccione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Leccione> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Leccione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Leccione>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Leccione>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Leccione> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeccionesTable extends Table
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

        $this->setTable('lecciones');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Modulos', [
            'foreignKey' => 'modulo_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('ContenidosLeccion', [
            'foreignKey' => 'leccion_id',
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
            ->integer('modulo_id')
            ->notEmptyString('modulo_id');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->scalar('tipo_contenido')
            ->maxLength('tipo_contenido', 50)
            ->allowEmptyString('tipo_contenido');

        $validator
            ->integer('posicion')
            ->notEmptyString('posicion');

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
        $rules->add($rules->existsIn(['modulo_id'], 'Modulos'), ['errorField' => 'modulo_id']);

        return $rules;
    }
}
