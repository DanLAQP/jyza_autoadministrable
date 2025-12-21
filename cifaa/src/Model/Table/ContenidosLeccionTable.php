<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContenidosLeccion Model
 *
 * @property \App\Model\Table\LeccionesTable&\Cake\ORM\Association\BelongsTo $Lecciones
 *
 * @method \App\Model\Entity\ContenidosLeccion newEmptyEntity()
 * @method \App\Model\Entity\ContenidosLeccion newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContenidosLeccion> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContenidosLeccion get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContenidosLeccion findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContenidosLeccion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContenidosLeccion> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContenidosLeccion|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContenidosLeccion saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContenidosLeccion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContenidosLeccion>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContenidosLeccion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContenidosLeccion> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContenidosLeccion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContenidosLeccion>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContenidosLeccion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContenidosLeccion> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContenidosLeccionTable extends Table
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

        $this->setTable('contenidos_leccion');
        $this->setDisplayField('tipo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lecciones', [
            'foreignKey' => 'leccion_id',
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
            ->integer('leccion_id')
            ->notEmptyString('leccion_id', 'La lección es requerida');

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 50)
            ->requirePresence('tipo', 'create')
            ->notEmptyString('tipo', 'El tipo de contenido es requerido');

        $validator
            ->scalar('contenido')
            ->allowEmptyString('contenido');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

        $validator
            ->scalar('archivo')
            ->maxLength('archivo', 255)
            ->allowEmptyString('archivo');

        $validator
            ->integer('posicion')
            ->notEmptyString('posicion', 'La posición es requerida');

        $validator
            ->scalar('link_externo')
            ->maxLength('link_externo', 2083)
            ->allowEmptyString('link_externo');

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
        $rules->add($rules->existsIn(['leccion_id'], 'Lecciones'), ['errorField' => 'leccion_id']);

        return $rules;
    }
}
