<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // NUEVA ARQUITECTURA: Usuarios se vinculan a Titulares
        $this->belongsTo('Titular', [
            'foreignKey' => 'titular_id',
            'className' => 'Titulares',
            'joinType' => 'LEFT',  // Opcional (NULL en DB para admin)
        ]);

        $this->hasMany('Transacciones', [
            'foreignKey' => 'user_id',
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
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'create')
            ->allowEmptyString('password', 'update');

        $validator
            ->integer('rol')
            ->requirePresence('rol', 'create')
            ->notEmptyString('rol');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 50)
            ->requirePresence('estado', 'create')
            ->notEmptyString('estado')
            ->inList('estado', ['activo', 'inactivo']);

        $validator
            ->scalar('dni')
            ->maxLength('dni', 20)
            ->allowEmptyString('dni'); // Optional for legacy users, arguably could be requirePresence('dni', 'create') if we enforce it

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
        // Username debe ser único
        $rules->add($rules->isUnique(['username']), [
            'errorField' => 'username',
            'message' => 'Este nombre de usuario ya existe.'
        ]);
        
        // DNI debe ser único (permitir NULLs múltiples)
        $rules->add($rules->isUnique(['dni'], ['allowMultipleNulls' => true]), [
            'errorField' => 'dni',
            'message' => 'Este DNI ya está registrado en otro usuario.'
        ]);
        
        // NUEVA REGLA CRÍTICA: titular_id debe ser único
        // Un titular solo puede estar vinculado a UN usuario
        $rules->add($rules->isUnique(['titular_id'], ['allowMultipleNulls' => true]), [
            'errorField' => 'titular_id',
            'message' => 'Este titular ya está vinculado a otro usuario. Un titular solo puede tener una cuenta.'
        ]);
        
        // Validar que titular_id exista en la tabla titulares
        $rules->add($rules->existsIn(['titular_id'], 'Titular', 'El titular especificado no existe.'), [
            'errorField' => 'titular_id'
        ]);

        return $rules;
    }
}
