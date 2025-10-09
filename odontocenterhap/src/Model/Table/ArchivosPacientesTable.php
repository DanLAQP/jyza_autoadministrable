<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ArchivosPacientes Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 *
 * @method \App\Model\Entity\ArchivosPaciente newEmptyEntity()
 * @method \App\Model\Entity\ArchivosPaciente newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ArchivosPaciente> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ArchivosPaciente get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ArchivosPaciente findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ArchivosPaciente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ArchivosPaciente> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ArchivosPaciente|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ArchivosPaciente saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ArchivosPaciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ArchivosPaciente>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ArchivosPaciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ArchivosPaciente> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ArchivosPaciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ArchivosPaciente>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ArchivosPaciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ArchivosPaciente> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArchivosPacientesTable extends Table
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

        $this->setTable('archivos_pacientes');
        $this->setDisplayField('ruta_archivo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pacientes1', [
            'foreignKey' => 'paciente_id',
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
            ->integer('paciente_id')
            ->notEmptyString('paciente_id');

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 20)
            ->requirePresence('tipo', 'create')
            ->notEmptyString('tipo');

        $validator
            ->scalar('ruta_archivo')
            ->maxLength('ruta_archivo', 255)
            ->requirePresence('ruta_archivo', 'create')
            ->notEmptyString('ruta_archivo');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

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
        $rules->add($rules->existsIn(['paciente_id'], 'Pacientes1'), ['errorField' => 'paciente_id']);

        return $rules;
    }
}
