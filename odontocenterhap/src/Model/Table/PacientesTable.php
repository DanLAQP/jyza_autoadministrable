<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pacientes Model
 *
 * @property \App\Model\Table\AntecedentesMedicosTable&\Cake\ORM\Association\HasMany $AntecedentesMedicos
 * @property \App\Model\Table\AntecedentesOdontologicosTable&\Cake\ORM\Association\HasMany $AntecedentesOdontologicos
 * @property \App\Model\Table\ContactosEmergenciaTable&\Cake\ORM\Association\HasMany $ContactosEmergencia
 * @property \App\Model\Table\EnfermedadesActualesTable&\Cake\ORM\Association\HasMany $EnfermedadesActuales
 * @property \App\Model\Table\EstadosCuentasTable&\Cake\ORM\Association\HasMany $EstadosCuentas
 * @property \App\Model\Table\PresupuestosTable&\Cake\ORM\Association\HasMany $Presupuestos
 * @property \App\Model\Table\RegistrosTratamientosTable&\Cake\ORM\Association\HasMany $RegistrosTratamientos
 *
 * @method \App\Model\Entity\Paciente newEmptyEntity()
 * @method \App\Model\Entity\Paciente newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Paciente> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Paciente get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Paciente findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Paciente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Paciente> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Paciente|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Paciente saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Paciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Paciente>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Paciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Paciente> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Paciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Paciente>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Paciente>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Paciente> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PacientesTable extends Table
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

        $this->setTable('pacientes');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('AntecedentesMedicos', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('AntecedentesOdontologicos', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('ContactosEmergencia', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('EnfermedadesActuales', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('EstadosCuentas', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('Presupuestos', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('RegistrosTratamientos', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('Citas', [
            'foreignKey' => 'paciente_id',
        ]);
        // Relación hasMany con Odontogramas
        $this->hasMany('Odontograma', [
            'foreignKey' => 'paciente_id',
            'propertyName' => 'odontogramas_asociados', // Cambiamos el nombre de la propiedad para evitar conflictos
        ]);
        $this->hasMany('ArchivosPacientes', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('RegistrosConsultas', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->belongsTo('Pacientes1', [
            'foreignKey' => 'paciente_id',
        ]);
        $this->hasMany('Ordenes', [
            'foreignKey' => 'paciente_id',
            'dependent' => true,
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
            ->scalar('dni')
            ->maxLength('dni', 20, 'El DNI no puede tener más de 20 caracteres.')
            ->allowEmptyString('dni')
            ->add('dni', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Este DNI ya está registrado.']);

        $validator
            ->scalar('ruc')
            ->maxLength('ruc', 20)
            ->allowEmptyString('ruc');

        $validator
            ->date('fecha_nacimiento')
            ->allowEmptyDate('fecha_nacimiento');

        $validator
            ->scalar('sexo')
            ->maxLength('sexo', 15)
            ->allowEmptyString('sexo');

        $validator
            ->integer('edad')
            ->allowEmptyString('edad');

        $validator
            ->scalar('nombre_apoderado')
            ->maxLength('nombre_apoderado', 50)
            ->allowEmptyString('nombre_apoderado');

        $validator
            ->scalar('parentesco_apoderado')
            ->maxLength('parentesco_apoderado', 20)
            ->allowEmptyString('parentesco_apoderado');

        $validator
            ->scalar('direccion')
            ->maxLength('direccion', 100)
            ->allowEmptyString('direccion');

        $validator
            ->scalar('distrito')
            ->maxLength('distrito', 50)
            ->allowEmptyString('distrito');

        $validator
            ->scalar('codigo_postal')
            ->maxLength('codigo_postal', 10)
            ->allowEmptyString('codigo_postal');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('telefono_oficina')
            ->maxLength('telefono_oficina', 20)
            ->allowEmptyString('telefono_oficina');

        $validator
            ->scalar('centro_trabajo')
            ->maxLength('centro_trabajo', 50)
            ->allowEmptyString('centro_trabajo');

        $validator
            ->scalar('centro_estudio')
            ->maxLength('centro_estudio', 50)
            ->allowEmptyString('centro_estudio');

        $validator
            ->scalar('recomendacion')
            ->maxLength('recomendacion', 255)
            ->allowEmptyString('recomendacion');

        return $validator;
    }
}
