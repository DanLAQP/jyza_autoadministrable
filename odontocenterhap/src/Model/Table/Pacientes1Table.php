<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pacientes1 Model
 *
 * @method \App\Model\Entity\Pacientes1 newEmptyEntity()
 * @method \App\Model\Entity\Pacientes1 newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Pacientes1> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pacientes1 get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Pacientes1 findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Pacientes1 patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Pacientes1> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pacientes1|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Pacientes1 saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Pacientes1>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pacientes1>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pacientes1>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pacientes1> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pacientes1>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pacientes1>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pacientes1>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pacientes1> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class Pacientes1Table extends Table
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

        $this->setTable('pacientes1');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('Pacientes', [
            'foreignKey' => 'paciente_id',
        ]);
        
        $this->hasMany('Presupuestos', [
            'foreignKey' => 'paciente_id',
            'dependent' => true, // opcional, útil si quieres que se eliminen en cascada
            'cascadeCallbacks' => true // si manejas dependencias más profundas
        ]);
        
        $this->hasMany('RegistrosConsultas', [
            'foreignKey' => 'paciente_id',
            'dependent' => true, // opcional, útil si quieres que se eliminen en cascada
            'cascadeCallbacks' => true // si manejas dependencias más profundas
        ]);
        $this->hasMany('ArchivosPacientes', [
            'foreignKey' => 'paciente_id',
            'dependent' => true, // opcional, útil si quieres que se eliminen en cascada
            'cascadeCallbacks' => true // si manejas dependencias más profundas
        ]);
        $this->hasMany('Odontograma', [
            'foreignKey' => 'paciente_id',
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
            ->maxLength('nombre', 255)
            ->allowEmptyString('nombre');

        $validator
            ->scalar('apellido')
            ->maxLength('apellido', 255)
            ->allowEmptyString('apellido');

        $validator
            ->scalar('telefono_celular')
            ->maxLength('telefono_celular', 10)
            ->allowEmptyString('telefono_celular');

        return $validator;
    }
}
