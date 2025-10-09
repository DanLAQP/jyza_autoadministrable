<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactosEmergencia Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 *
 * @method \App\Model\Entity\ContactosEmergencia newEmptyEntity()
 * @method \App\Model\Entity\ContactosEmergencia newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactosEmergencia> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContactosEmergencia get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContactosEmergencia findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContactosEmergencia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactosEmergencia> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContactosEmergencia|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContactosEmergencia saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContactosEmergencia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactosEmergencia>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactosEmergencia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactosEmergencia> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactosEmergencia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactosEmergencia>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactosEmergencia>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactosEmergencia> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ContactosEmergenciaTable extends Table
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

        $this->setTable('contactos_emergencia');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Pacientes', [
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
            ->integer('paciente_id')
            ->allowEmptyString('paciente_id');

        $validator
            ->scalar('medico_confianza')
            ->maxLength('medico_confianza', 50)
            ->allowEmptyString('medico_confianza');

        $validator
            ->scalar('servicio_ambulancia')
            ->maxLength('servicio_ambulancia', 50)
            ->allowEmptyString('servicio_ambulancia');

        $validator
            ->scalar('nombre_contacto')
            ->maxLength('nombre_contacto', 50)
            ->allowEmptyString('nombre_contacto');

        $validator
            ->scalar('telefono_contacto')
            ->maxLength('telefono_contacto', 20)
            ->allowEmptyString('telefono_contacto');

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
        $rules->add($rules->existsIn(['paciente_id'], 'Pacientes'), ['errorField' => 'paciente_id']);

        return $rules;
    }
}
