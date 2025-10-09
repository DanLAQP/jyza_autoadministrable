<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use ArrayObject;

/**
 * Doctores Model
 *
 * @method \App\Model\Entity\Doctore newEmptyEntity()
 * @method \App\Model\Entity\Doctore newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Doctore> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Doctore get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Doctore findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Doctore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Doctore> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Doctore|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Doctore saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Doctore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Doctore>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Doctore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Doctore> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Doctore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Doctore>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Doctore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Doctore> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DoctoresTable extends Table
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

        $this->setTable('doctores');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Citas', [
            'foreignKey' => 'doctor_id',
        ]);
        $this->hasMany('HorariosDoctores', [
            'foreignKey' => 'doctor_id',
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
            ->maxLength('nombre', 50)
            ->requirePresence('nombre', 'create')
            ->notEmptyString('nombre');

        $validator
            ->scalar('apellido')
            ->maxLength('apellido', 50)
            ->requirePresence('apellido', 'create')
            ->notEmptyString('apellido');

        $validator
            ->scalar('especialidad')
            ->maxLength('especialidad', 50)
            ->requirePresence('especialidad', 'create')
            ->notEmptyString('especialidad');

        $validator
            ->scalar('telefono')
            ->maxLength('telefono', 20)
            ->requirePresence('telefono', 'create')
            ->notEmptyString('telefono');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        return $validator;
    }

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $usuariosTable = TableRegistry::getTableLocator()->get('Users');

            // Extraer inicial del nombre
            $nombreParts = explode(' ', trim($entity->nombre));
            $inicialNombre = strtolower(substr($nombreParts[0], 0, 1)); // Primera letra del primer nombre

            // Extraer primer apellido completo
            $apellidoParts = explode(' ', trim($entity->apellido));
            $primerApellido = strtolower($apellidoParts[0]); // Primer apellido completo

            // Extraer las dos primeras letras del segundo apellido
            $segundoApellido = isset($apellidoParts[1]) ? strtolower(substr($apellidoParts[1], 0, 2)) : '';

            // Generar username
            $username = $inicialNombre . $primerApellido . $segundoApellido;

            $usuario = $usuariosTable->newEntity([
                'username' => $username,
                'password' => 'Doc_' . $entity->telefono,
                'rol' => 3, // Rol de doctor
                'doctor_id' => $entity->id, // Relación con el doctor recién creado
            ]);

            $usuariosTable->save($usuario);
        }
    }
}
