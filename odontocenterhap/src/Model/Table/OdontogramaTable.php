<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Odontograma Model
 *
 * @property \App\Model\Table\PacientesTable&\Cake\ORM\Association\BelongsTo $Pacientes
 * @property \App\Model\Table\DientesTable&\Cake\ORM\Association\BelongsToMany $Dientes
 * @property \App\Model\Table\SimbolosTable&\Cake\ORM\Association\BelongsToMany $Simbolos
 *
 * @method \App\Model\Entity\Odontograma newEmptyEntity()
 * @method \App\Model\Entity\Odontograma newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Odontograma> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Odontograma get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Odontograma findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Odontograma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Odontograma> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Odontograma|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Odontograma saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Odontograma>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Odontograma>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Odontograma>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Odontograma> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Odontograma>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Odontograma>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Odontograma>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Odontograma> deleteManyOrFail(iterable $entities, array $options = [])
 */
class OdontogramaTable extends Table
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

        $this->setTable('odontograma');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // $this->belongsTo('Pacientes', [
        //     'foreignKey' => 'paciente_id',
        //     'joinType' => 'INNER',
        // ]);
        $this->belongsTo('Pacientes1', [
            'foreignKey' => 'paciente_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsToMany('Dientes', [
            'foreignKey' => 'odontograma_id',
            'targetForeignKey' => 'diente_id',
            'joinTable' => 'odontograma_dientes',
        ]);
        $this->belongsToMany('Simbolos', [
            'foreignKey' => 'odontograma_id',
            'targetForeignKey' => 'simbolo_id',
            'joinTable' => 'odontograma_simbolos',
        ]);
        $this->hasMany('OdontogramaSimbolos', [
            'foreignKey' => 'odontograma_id',
        ]);
        
        $this->hasMany('OdontogramaDientes', [
            'foreignKey' => 'odontograma_id',
        ]);
        $this->hasMany('OdontogramaDetalles', [
            'foreignKey' => 'odontograma_id',
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
            ->notEmptyString('paciente_id', 'Por favor seleccione un paciente');


        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        $validator
            ->scalar('titulo')  // Define que el tipo de datos es una cadena de texto
            ->maxLength('titulo', 100, 'El título no puede tener más de 100 caracteres.')  // Límite de 100 caracteres
            ->notEmptyString('titulo', 'El título es obligatorio.');  // Obliga a que el campo sea no vacío
        

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
